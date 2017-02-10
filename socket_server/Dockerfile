# Build from the official Python 2 image that runs pip automatically
FROM python:2-onbuild

# Expose ports 5001 for the Flask server and 5002 for the socket server
EXPOSE 5001 5002

# Run the Python script
CMD [ "python", "./FlaskServer.py" ]
