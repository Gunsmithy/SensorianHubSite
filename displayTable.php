  <?php 
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();
  include("functions.php");
  if(isset($_SESSION["userid"])) {
    if(isLoginSessionExpired()) {
      header("Location:logout.php?session_expired=1");
    }
  }
  if($_SESSION['userid']=="" && $_SESSION['name']==""){
    header("location: loginPage.php");
  }
  require 'dbconnect.php';
  $userId = $_SESSION['userid'];   
  
  ?>
  <!doctype html>
  <html lang="en">

  <head>
  <style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
}
  </style>

    <meta charset="utf-8">
    <title>PI Result</title>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="tablestyle.css" type="text/css"/>
    <script type="text/javascript" src="smoothie.js"></script>
    <script id="source" language="javascript" type="text/javascript">


      $(function() {
        $( "#tabs" ).tabs({active:1});
        setInterval(function(){
          $.ajax({                                      
            url: 'allResult.php',
            method:"POST",
            data: ({uid:"<?php echo $userId?>"}),

            dataType: 'json',                     
            success: function(data)         
            {

              $("#tab-1-1").empty();
              $("#tab-1-1").append("<tr><th>Time Stamp</th><th>IP</th><th>CPU TEMP</th><th>LUX</th><th>TEMP</th><th>ALTITUDE</th><th>PRESSURE</th><th>X</th><th>Y</th><th>Z</th></tr>");
              for (var i=0; i<data.length; i++){
                var date=  data[i].date;
                var temp=  data[i].temp;
                var time=  data[i].time_p; 
                var cpu=data[i].cpuTemp;
                var alt=data[i].alti;
                var ip=  data[i].ip;
                var lux=  data[i].lux;
                var press=  data[i].press;
                var acc_x=  data[i].acc_x;
                var acc_y=  data[i].acc_y;
                var acc_z=  data[i].acc_z;
                
                $("#tab-1-1").append("<tr><td>"+time+"</td><td>"+ip+"</td><td>"+cpu+"</td><td>"+lux+"</td><td>"+temp+"</td><td>"+alt+"</td><td>"+press+"</td><td>"+acc_x+"</td><td>"+acc_y+"</td><td>"+acc_z+"</td></tr>");
              }

            } ,
            error : function(request,error) 

            { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 

          });
        },5000);

        $("#tabs").on("tabsactivate", (event, ui) => {
          if (ui.newPanel.is("#tabs-1")){
           setInterval(function(){
            $.ajax({                                      
              url: 'allResult.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-1-1").empty();
                $("#tab-1-1").append("<tr><th>Time Stamp</th><th>IP</th><th>CPU TEMP</th><th>LUX</th><th>TEMP</th><th>ALTITUDE</th><th>PRESSURE</th><th>X</th><th>Y</th><th>Z</th></tr>");
                for (var i=0; i<data.length; i++){
                  
                  var temp=  data[i].temp;
                  var time=  data[i].time_p; 
                  var cpu=data[i].cpuTemp;
                  var alt=data[i].alti;
                  var ip=  data[i].ip;
                  var lux=  data[i].lux;
                  var press=  data[i].press;
                  var acc_x=  data[i].acc_x;
                  var acc_y=  data[i].acc_y;
                  var acc_z=  data[i].acc_z;
                  $("#tab-1-1").append("<tr><td>"+time+"</td><td>"+ip+"</td><td>"+cpu+"</td><td>"+lux+"</td><td>"+temp+"</td><td>"+alt+"</td><td>"+press+"</td><td>"+acc_x+"</td><td>"+acc_y+"</td><td>"+acc_z+"</td></tr>");
                }
              } ,
              error : function(request,error) 
              { 
                alert (error);
                alert("Request: "+JSON.stringify(request)); 
              } 

            });
          },5000);
         }
         else if(ui.newPanel.is("#tabs-2")){
          setInterval(function(){
            $.ajax({                                      
              url: 'cpuTempData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-2-1").empty();
                 $("#tab-2-1").append("<tr><th>Time Stamp</th><th>CPU TEMP</th></tr>");
                for (var i=0; i<data.length; i++){
                 var time=  data[i].time_p; 
                 var cpu=data[i].cpuTemp;
                 $("#tab-2-1").append("<tr><td>"+time+"</td><td>"+cpu+"</td></tr>");
               }

             } ,
             error : function(request,error) 
             { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 
          });
          },5000);
        }
        else if(ui.newPanel.is("#tabs-3")){
          setInterval(function(){
            $.ajax({                                      
              url: 'luxData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-3-1").empty();
                $("#tab-3-1").append("<tr><th>Time Stamp</th><th>LUX</th></tr>");
                for (var i=0; i<data.length; i++){
                 var time=  data[i].time_p; 
                 var lux=  data[i].lux;
                 $("#tab-3-1").append("<tr><td>"+time+"</td><td>"+lux+"</td></tr>");
               }
             } ,
             error : function(request,error) 

             { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 

          });
          },5000);
        }
        else if(ui.newPanel.is("#tabs-4")){
          setInterval(function(){
            $.ajax({                                      
              url: 'tempData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-4-1").empty();
                 $("#tab-4-1").append("<tr><th>Time Stamp</th><th>ALTITUDE</th></tr>");
                for (var i=0; i<data.length; i++){
                 var temp=  data[i].temp; 
                 var time=  data[i].time_p;
                 $("#tab-4-1").append("<tr><td>"+time+"</td><td>"+temp+"</td></tr>");
               }

             } ,
             error : function(request,error) 

             { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 

          });
          },5000);
        }
        else if(ui.newPanel.is("#tabs-5")){
          setInterval(function(){
            $.ajax({                                      
              url: 'altiData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-5-1").empty();
                $("#tab-5-1").append("<tr><th>Time Stamp</th><th>ALTITUDE</th></tr>");
                for (var i=0; i<data.length; i++){
                 var time=  data[i].time_p; 
                 var alti=  data[i].alti;
              
                  $("#tab-5-1").append("<tr><td>"+time+"</td><td>"+alti+"</td></tr>");
               }

             } ,
             error : function(request,error) 

             { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 

          });
          },5000);

        }
        else if(ui.newPanel.is("#tabs-6")){
          setInterval(function(){
            $.ajax({                                      
              url: 'pressData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),

              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-6-1").empty();
                $("#tab-6-1").append("<tr><th>Time Stamp</th><th>PRESSURE</th></tr>");
                for (var i=0; i<data.length; i++){
                 var time=  data[i].time_p; 
                 var press=  data[i].press;
                 $("#tab-6-1").append("<tr><td>"+time+"</td><td>"+press+"</td></tr>");
               }
             } ,
             error : function(request,error) 

             { 
              alert (error);
              alert("Request: "+JSON.stringify(request)); 
            } 
          });
          },5000);

        }
        else if(ui.newPanel.is("#tabs-0")){
          var timeout= setInterval(function(){
            $.ajax({                                      
              url: 'currentData.php',
              method:"POST",
              data: ({uid:"<?php echo $userId?>"}),
              dataType: 'json',                     
              success: function(data)         
              {

                $("#tab-0-1").empty();
                $("#tab-0-1").append("<tr><th>Time Stamp</th><th>IP</th><th>CPU TEMP</th><th>LUX</th><th>TEMP</th><th>ALTITUDE</th><th>PRESSURE</th><th>X</th><th>Y</th><th>Z</th></tr>");
                for (var i=0; i<data.length; i++){
                  var date=  data[i].date;
                  var temp=  data[i].temp;
                  var time=  data[i].time_p; 
                  var cpu=data[i].cpuTemp;
                  var alt=data[i].alti;
                  var ip=  data[i].ip;
                  var lux=  data[i].lux;
                  var press=  data[i].press;
                  var acc_x=  data[i].acc_x;
                  var acc_y=  data[i].acc_y;
                  var acc_z=  data[i].acc_z;
                  
        
                  $("#tab-0-1").append("<tr><td>"+time+"</td><td>"+ip+"</td><td>"+cpu+"</td><td>"+lux+"</td><td>"+temp+"</td><td>"+alt+"</td><td>"+press+"</td><td>"+acc_x+"</td><td>"+acc_y+"</td><td>"+acc_z+"</td></tr>");
                }

              } ,
              error : function(request,error) 

              { 
                clearInterval(timeout);
                alert (error);
                alert("Request: "+JSON.stringify(request));
              } 

            });
          },5000);

        }
      });

});
</script>
</head>

<body>
  <?php
  if(isset($_SESSION["name"])) {
    ?>
    Welcome <?php echo $_SESSION["name"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout.</a>
    <?php
  }
  ?>
  <?php include 'insertData.php' ;?>

  <div id="tabs">
    <ul>
      <li><a href="#tabs-0">Current Result(Last 10 Record)</a></li>
      <li><a href="#tabs-1">Display All Result</a></li>
      <li><a href="#tabs-2">CPU Temp</a></li>
      <li><a href="#tabs-3">LUX</a></li>
      <li><a href="#tabs-4">Temp</a></li>
      <li><a href="#tabs-5">Altitude</a></li>
      <li><a href="#tabs-6">Pressure</a></li>
    </ul>
    <div id="tabs-0">
     <p id ="tab-0-2">
      <canvas id="mycanvas" width= "1200" height="300"></canvas>

      <script type="text/javascript" >
        $(function(){
          var timerId = 0;
          var line1 = new TimeSeries();
          var line2 = new TimeSeries();
          var line3 = new TimeSeries();
          var line5= new TimeSeries();
          var line4 = new TimeSeries();
          var line6 = new TimeSeries();
          var line7 = new TimeSeries();
          var line8 = new TimeSeries();
          var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
          smoothie.streamTo(document.getElementById("mycanvas"), 10000);
          setInterval(function(){
            $.ajax({                                      
              url: 'currentData1.php',
              method:"POST",
              data: ({uid:"<?php echo $userId ?>"}),

              dataType: 'json',                     
              success: function(data)         
              {
                plotLux(data);
                console.log(data);
              }
            });

          },5000);

          function plotLux(data){
            for (var i=0; i<data.length;i++){
              var jdata=  data[i].lux; 
              var jdata1=  data[i].cpuTemp; 
              var jdata2=  data[i].temp; 
              var jdata3=  data[i].alti;
              var jdata4=  data[i].press;
              var jdata5=  data[i].acc_x;
              var jdata6=  data[i].acc_y;
              var jdata7=  data[i].acc_z;
             

              var jdata4=  data[i].press; 
              console.log(jdata);
              line1.append(new Date().getTime(), jdata);
              line2.append(new Date().getTime(), jdata1);
              line3.append(new Date().getTime(), jdata2);
              line4.append(new Date().getTime(), jdata3);

              line5.append(new Date().getTime(), jdata4);
              line6.append(new Date().getTime(), jdata5);
              line7.append(new Date().getTime(), jdata6);
              line8.append(new Date().getTime(), jdata7);
            }

          }
          smoothie.addTimeSeries(line1, { strokeStyle: 'rgb(255, 255, 0)', 
            fillStyle: 'rgba(255, 255, 0, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(255, 0, 0)', 
            fillStyle: 'rgba(255, 0, 0, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line3, { strokeStyle: 'rgb(0, 255, 0)', 
            fillStyle: 'rgba(0, 255, 0, 0.4)', 
            lineWidth: 3 });

          smoothie.addTimeSeries(line4, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line5, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line6, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line7, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line8, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
        });
      </script></p>
      
        <table   id ="tab-0-1" style="width:100%">
        
        </table>
      
    </div>
    <div id="tabs-1">
      <p>
        <canvas id="mycanvas1" width= "1200" height="300"></canvas>

        <script type="text/javascript" >
          $(function(){
          var line1 = new TimeSeries();
          var line2 = new TimeSeries();
          var line3 = new TimeSeries();
          var line5= new TimeSeries();
          var line4 = new TimeSeries();
          var line6 = new TimeSeries();
          var line7 = new TimeSeries();
          var line8 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas1"));
            setInterval(function(){
              $.ajax({                                      
                url: 'allResult1.php',
                method:"POST",
                data: ({uid:"<?php echo $userId ?>"}),

                dataType: 'json',                     
                success: function(data)         
                {
                  plotLux(data);

                }
              });
            },5000);
            function plotLux(data){
              for (var i=0; i<data.length;i++){
              var jdata=  data[i].lux; 
              var jdata1=  data[i].cpuTemp; 
              var jdata2=  data[i].temp; 
              var jdata3=  data[i].alti;
              var jdata4=  data[i].press;
              var jdata5=  data[i].acc_x;
              var jdata6=  data[i].acc_y;
              var jdata7=  data[i].acc_z;
                 line1.append(new Date().getTime(), jdata);
              line2.append(new Date().getTime(), jdata1);
              line3.append(new Date().getTime(), jdata2);
              line4.append(new Date().getTime(), jdata3);

              line5.append(new Date().getTime(), jdata4);
              line6.append(new Date().getTime(), jdata5);
              line7.append(new Date().getTime(), jdata6);
              line8.append(new Date().getTime(), jdata7);
              }

            }
             smoothie.addTimeSeries(line1, { strokeStyle: 'rgb(255, 255, 0)', 
            fillStyle: 'rgba(255, 255, 0, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(255, 0, 0)', 
            fillStyle: 'rgba(255, 0, 0, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line3, { strokeStyle: 'rgb(0, 255, 0)', 
            fillStyle: 'rgba(0, 255, 0, 0.4)', 
            lineWidth: 3 });

          smoothie.addTimeSeries(line4, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line5, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line6, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line7, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          smoothie.addTimeSeries(line8, { strokeStyle: 'rgb(0, 0, 255)', 
            fillStyle: 'rgba(0, 0, 255, 0.4)', 
            lineWidth: 3 });
          });

        </script></p>
        
        <table   id ="tab-1-1"  style="width:100%">
        
        </table>
      </div>
      <div id="tabs-2">
       <p>
        <canvas id="mycanvas2" width= "1200" height="300"></canvas>
        <script type="text/javascript" >
          $(function(){
            var line2 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas2"));
            setInterval(function(){
              $.ajax({                                      
                url: 'cpuTempData1.php',
                method:"POST",
                data: ({uid:"<?php echo $userId ?>"}),

                dataType: 'json',                     
                success: function(data)         
                {
                  plotLux(data);

                }
              });
            },5000);
            function plotLux(data){
              for (var i=0; i<data.length;i++){
                var jdata1=  data[i].cpuTemp; 
                line2.append(new Date().getTime(), jdata1);
              }

            }
            smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', 
              fillStyle: 'rgba(0, 255, 0, 0.4)', 
              lineWidth: 3 });

          });
        </script></p>
        <table   id ="tab-2-1"  style="width:100%">
        </table>
      </div>
      <div id="tabs-3">
       <p>
        <canvas id="mycanvas3" width= "1200" height="300"></canvas>
        <script type="text/javascript" >
          $(function(){
            var line2 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas3"));
            setInterval(function(){
              $.ajax({                                      
                url: 'luxData1.php',
                method:"POST",
                data: ({uid:"<?php echo $userId ?>"}),
                dataType: 'json',                     
                success: function(data)         
                {
                  plotLux(data);

                }
              });
            },5000);
            function plotLux(data){
              for (var i=0; i<data.length;i++){
                var jdata1=  data[i].lux; 
                line2.append(new Date().getTime(), jdata1);
              }

            }
            smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', 
              fillStyle: 'rgba(0, 255, 0, 0.4)', 
              lineWidth: 3 });
          });

        </script></p>
        <table   id ="tab-3-1"  style="width:100%">
        
        </table>
      </div>
      <div id="tabs-4">
       <p>
        <canvas id="mycanvas4" width= "1200" height="300"></canvas>

        <script type="text/javascript" >
          $(function(){
            var line2 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas4"));
            setInterval(function(){
              $.ajax({                                      
                url: 'tempData1.php',
                method:"POST",
                data: ({uid:"<?php echo $userId ?>"}),
                dataType: 'json',                     
                success: function(data)         
                {
                  plotLux(data);

                }
              });
            },5000);
            function plotLux(data){
              for (var i=0; i<data.length;i++){
                var jdata1=  data[i].temp; 
                line2.append(new Date().getTime(), jdata1);
              }

            }
            smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', 
              fillStyle: 'rgba(0, 255, 0, 0.4)', 
              lineWidth: 3 });
          });
        </script></p>
        <table   id ="tab-4-1"  style="width:100%">
        
        </table>
      </div>
      <div id="tabs-5">
       <p>
        <canvas id="mycanvas5" width= "1200" height="300"></canvas>
        <script type="text/javascript" >
          $(function(){
            var line2 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas5"));
            setInterval(function(){
              $.ajax({                                      
                url: 'altiData.php',
                method:"POST",
                data: ({uid:"<?php echo $userId ?>"}),

                dataType: 'json',                     
                success: function(data)         
                {
                  plotLux(data);

                }
              });
            },5000);
            function plotLux(data){
              for (var i=0; i<data.length;i++){
                var jdata1=  data[i].alti; 
                line2.append(new Date().getTime(), jdata1);              
              }

            }
            smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', 
              fillStyle: 'rgba(0, 255, 0, 0.4)', 
              lineWidth: 3 });
          });

        </script></p>
        <table   id ="tab-5-1"  style="width:100%">
        
        </table>
      </div>
      <div id="tabs-6">
        <p>
          <canvas id="mycanvas6" width= "1200" height="300"></canvas>

          <script type="text/javascript" >
            $(function(){
              var line2 = new TimeSeries();
              var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
              smoothie.streamTo(document.getElementById("mycanvas6"));
              setInterval(function(){
                $.ajax({                                      
                  url: 'pressData1.php',
                  method:"POST",
                  data: ({uid:"<?php echo $userId ?>"}),
                  dataType: 'json',                     
                  success: function(data)         
                  {
                    plotLux(data);
                  }
                });
              },5000);
              function plotLux(data){
                for (var i=0; i<data.length;i++){
                  var jdata1=  data[i].press; 
                  line2.append(new Date().getTime(), jdata1);                }
              }
              smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0, 255, 0)', 
                fillStyle: 'rgba(0, 255, 0, 0.4)', 
                lineWidth: 3 });
            });

          </script></p>
          <table   id ="tab-6-1"  style="width:100%">
        
        </table>
        </div>
      </div>
    </body>
    </html>