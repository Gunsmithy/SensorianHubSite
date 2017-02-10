from flask import Flask, abort, request
from flask_restful import Api, Resource, reqparse
from flask_httpauth import HTTPBasicAuth
import threading
import requests
import time
import socket

app = Flask(__name__)
api = Api(app)
auth = HTTPBasicAuth()

configUsername = "defaultUsername"
configPassword = "defaultPassword"

variable_queue = []
variableQueueLock = threading.Lock()

@auth.get_password
def get_password(username):
    if username == configUsername:
        return configPassword
    return None


class ConfigAPI(Resource):
    # decorators = [auth.login_required]

    def __init__(self):
        self.reqparse = reqparse.RequestParser()
        self.reqparse.add_argument('name', type=str, location='json')
        self.reqparse.add_argument('value', type=str, location='json')
        super(ConfigAPI, self).__init__()
    '''
    def get(self, name):
        config_temp = get_config_value(name)
        if config_temp != "ConfigNotFound":
            return {'name': name, 'value': config_temp}
        else:
            abort(404)
    '''
    def put(self, name):
        args = self.reqparse.parse_args()
        if args['value'] is not None:
            variable_queue.append({'name': name, 'value': args['value']})
            return {'name': name, 'value': args['value']}
        else:
            abort(400, 'No value received, please provide a value in the JSON')

api.add_resource(ConfigAPI, '/variables/<string:name>', endpoint='variable')


def run_flask():
    print("Running Flask")
    app.run(debug=True, use_reloader=False, host='0.0.0.0', port=5001)


def shutdown_server():
    func = request.environ.get('werkzeug.server.shutdown')
    if func is None:
        raise RuntimeError('Not running with the Werkzeug Server')
    func()


@app.route('/shutdown', methods=['POST'])
@auth.login_required
def shutdown_flask_api():
    shutdown_server()
    return 'Flask server shutting down...'


def kill_flask():
    url = 'http://127.0.0.1:5001/shutdown'
    try:
        requests.post(url, auth=(configUsername, configPassword))
    except requests.exceptions.ConnectionError:
        print("Flask server already shut down")


@app.route('/')
def hello_world():
    return 'Hello World!'


class FlaskThread(threading.Thread):
    # Initializes a thread to run Flask
    def __init__(self):
        threading.Thread.__init__(self)
        self.threadID = 99
        self.name = "FlaskThread"

    def run(self):
        run_flask()
        print("Killing " + self.name)


class ThreadedServer(object):
    def __init__(self, host, port):
        self.host = host
        self.port = port
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.sock.bind((self.host, self.port))

    def listen(self):
        self.sock.listen(5)
        while True:
            client, address = self.sock.accept()
            client.settimeout(10)
            threading.Thread(target=self.listenToClient, args=(client, address)).start()

    def listenToClient(self, client, address):
        size = 1024
        while True:
            try:
                data = client.recv(size)
                if data == "KeepAlive":
                    print "KeepAlive Received"
                    variableQueueLock.acquire()
                    if variable_queue:
                        print "PREPARE Sent"
                        client.send("PREPARE")
                    elif not variable_queue:
                        print "LIVE Sent"
                        client.send("LIVE")
                    variableQueueLock.release()
                elif data == "READY":
                    print "READY Received"
                    variableQueueLock.acquire()
                    if variable_queue:
                        temp_dict = variable_queue.pop(0)
                        payload = temp_dict['name'] + ":" + temp_dict['value']
                        client.send(payload)
                    elif not variable_queue:
                        print "CANCEL Sent"
                        client.send("CANCEL")
                    variableQueueLock.release()
                else:
                    print "Client disconnected"
                    raise Exception('Client disconnected')
            except:
                client.close()
                return False


# Main Method
def main():
    flask_thread = FlaskThread()
    flask_thread.start()
    ThreadedServer('', 5002).listen()


if __name__ == '__main__':
    try:
        main()
    except KeyboardInterrupt:
        print("...Quitting ...")
    # Tell all threads to stop if the main program stops by setting their
    # respective repeat sentinels to False
    finally:
        kill_flask()
