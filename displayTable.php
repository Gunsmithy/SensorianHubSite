  <?php 
  //session is created here
  session_start();
  //check for the login expired
  include("functions.php");
  //check for the userid set for login
  if(isset($_SESSION["userid"])) {
    if(isLoginSessionExpired()) {
      header("Location:logout.php?session_expired=1");
    }
  }
  //if the userid and name set in the session
  if($_SESSION['userid']=="" && $_SESSION['name']==""){
    header("location: loginPage.php");
  }
  //set the dbconnection
  require 'dbconnect.php';
  $userId = $_SESSION['userid'];   
  //variable to store userid from the session
  ?>
  <!--html code-->
  <!doctype html>
  <html lang="en">
  <head>
    <!--table css for the data-->
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
    //we call the script to check for the user data
    //we use the ajax request for that
    //call when the page is loaded
    $(function() {
        //check if the tab is active 
        $( "#tabs" ).tabs({active:1});
        //sets the interval for the ajax request
        var timer = setInterval(function(){
          $.ajax({//ajax called  
          //call for the php file to run script on database                                     
          url: 'allResult.php',
          method:"POST",
            data: ({uid:"<?php echo $userId?>"}),//php call for user id
            dataType: 'json', //json data return                    
            success: function(data)         
            {
              $("#tab-1-1").empty();//clear the id
              //append the table title to the element
              $("#tab-1-1").append("<tr><th>Time Stamp</th><th>IP</th><th>CPU TEMP</th><th>LUX</th><th>TEMP</th><th>ALTITUDE</th><th>PRESSURE</th><th>X</th><th>Y</th><th>Z</th></tr>");
              //now we parse the json data 
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
                //appends json data to the table
                $("#tab-1-1").append("<tr><td>"+time+"</td><td>"+ip+"</td><td>"+cpu+"</td><td>"+lux+"</td><td>"+temp+"</td><td>"+alt+"</td><td>"+press+"</td><td>"+acc_x+"</td><td>"+acc_y+"</td><td>"+acc_z+"</td></tr>");
              }
            } ,
            //check for the error in the parsing 
            error : function(request,error) 
            { 
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              //clear the time interval
              clearInterval(timer);
            } 

          });
        },5000);
        // check if the tab 1 is the active
        $("#tabs").on("tabsactivate", (event, ui) => {
          if (ui.newPanel.is("#tabs-1")){
           var timer1 =setInterval(function(){
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
                alert ("No data in the Database. Please connect to Raspberry Pi.");
                clearInterval(timer1);
              } 

            });
          },5000);
         }
         //check if the tab 2 is active
         else if(ui.newPanel.is("#tabs-2")){
          var timer2 = setInterval(function(){
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
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              clearInterval(timer2);
            } 
          });
          },5000);
        }
        //check if the tab 3 is active
        else if(ui.newPanel.is("#tabs-3")){
          var timer3 = setInterval(function(){
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
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              clearInterval(timer3); 
            } 

          });
          },5000);
        }
        //check if the tab 4 is active
        else if(ui.newPanel.is("#tabs-4")){
          var timer4 = setInterval(function(){
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
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              clearInterval(timer4); 
            } 

          });
          },5000);
        }
        //check if the tab 5 is active
        else if(ui.newPanel.is("#tabs-5")){
          var timer5 = setInterval(function(){
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
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              clearInterval(timer5); 
            } 

          });
          },5000);

        }
        //check if the tab 6 is active
        else if(ui.newPanel.is("#tabs-6")){
          var timer6 = setInterval(function(){
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
              alert ("No data in the Database. Please connect to Raspberry Pi.");
              clearInterval(timer6); 
            } 
          });
          },5000);

        }
        //check if the tab 0 is active 
        else if(ui.newPanel.is("#tabs-0")){
          var timer7 = setInterval(function(){
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
                alert ("No data in the Database. Please connect to Raspberry Pi.");
                clearInterval(timer7);
              } 
            });
          },5000);
        }
      });

});
</script>
</head>
<!-- page heading  -->
<h1 align="center">SENSORIAN HUB</h1>
<body>
  <h2 align="center">
    <?php //get the user name from the seesion to diaplay on page
    if(isset($_SESSION["name"])) {
      ?>
      Welcome <?php echo $_SESSION["name"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout.</a>
      <?php
    }
    ?>
    <!--get the data to be diaplayed on the page-->
    <?php include 'insertData.php' ;?>
    <h2>
      <!--crate the tab for the page--> 
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
         <p>
           <!--smoothie canavas-->
           <canvas id="mycanvas" width= "1700" height="300"></canvas>
           <script type="text/javascript" >
          //show the graph and make the ajax call everyinterval to get the recent data
          //graph for tab 0
          $(function(){
            var line1 = new TimeSeries();
            var line2 = new TimeSeries();
            var line3 = new TimeSeries();
            var line5= new TimeSeries();
            var line4 = new TimeSeries();
            var line6 = new TimeSeries();
            var line7 = new TimeSeries();
            var line8 = new TimeSeries();
            var line9 = new TimeSeries();
            var smoothie = new SmoothieChart({ grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
            smoothie.streamTo(document.getElementById("mycanvas"));
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
                //parse the data and display it on the graph
                for (var i=0; i<data.length;i++){
                  var jdata=  data[i].lux; 
                  var jdata1=  data[i].cpuTemp; 
                  var jdata2=  data[i].temp; 
                  var jdata3=  data[i].alti;
                  var jdata4=  data[i].press;
                  var jdata5=  data[i].acc_x;
                  var jdata6=  data[i].acc_y;
                  var jdata7=  data[i].acc_z;
                  var jdata8=  data[i].press;
                  line1.append(new Date().getTime(), jdata);
                  line2.append(new Date().getTime(), jdata1);
                  line3.append(new Date().getTime(), jdata2);
                  line4.append(new Date().getTime(), jdata3);
                  line5.append(new Date().getTime(), jdata4);
                  line6.append(new Date().getTime(), jdata5);
                  line7.append(new Date().getTime(), jdata6);
                  line8.append(new Date().getTime(), jdata7);
                  line9.append(new Date().getTime(), jdata8);
                }

              }
              //adding line to the graph
              smoothie.addTimeSeries(line1, { strokeStyle: 'rgb(0,0,0)', 
                fillStyle: 'rgba(0,0,0, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0,255,0)', 
                fillStyle: 'rgba(0,255,0, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line3, { strokeStyle: 'rgb(0,0,255)', 
                fillStyle: 'rgba(0,0,255, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line4, { strokeStyle: 'rgb(0, 0, 255)',
                fillStyle: 'rgba(0, 0, 255, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line5, { strokeStyle: 'rgb(0,255,255)',
                fillStyle: 'rgba(0,255,255, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line6, { strokeStyle: 'rgb(255,0,255)',
                fillStyle: 'rgba(255,0,255, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line7, { strokeStyle: 'rgb(128,0,0)', 
                fillStyle: 'rgba(128,0,0, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line8, { strokeStyle: 'rgb(128,0,128)',
                fillStyle: 'rgba(128,0,128, 0.4)', 
                lineWidth: 3 });
              smoothie.addTimeSeries(line9, { strokeStyle: 'rgb(0,128,0)', 
                fillStyle: 'rgba(0,128,0, 0.4)', 
                lineWidth: 3 });
            });

          </script></p>
          <table   id ="tab-0-1" style="width:100%">
            <!--we use ajax to append to the table-->
          </table>

        </div>
        <div id="tabs-1">
          <p>
            <canvas id="mycanvas1" width= "1700" height="300"></canvas>
            <!--graph for the tab -1-->
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
                var line9 = new TimeSeries();
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
                    var jdata8=  data[i].press;
                    line1.append(new Date().getTime(), jdata);
                    line2.append(new Date().getTime(), jdata1);
                    line3.append(new Date().getTime(), jdata2);
                    line4.append(new Date().getTime(), jdata3);
                    line5.append(new Date().getTime(), jdata4);
                    line6.append(new Date().getTime(), jdata5);
                    line7.append(new Date().getTime(), jdata6);
                    line8.append(new Date().getTime(), jdata7);
                    line9.append(new Date().getTime(), jdata8);
                  }
                }
                smoothie.addTimeSeries(line1, { strokeStyle: 'rgb(0,0,0)', 
                  fillStyle: 'rgba(0,0,0, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line2, { strokeStyle: 'rgb(0,255,0)',
                  fillStyle: 'rgba(0,255,0, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line3, { strokeStyle: 'rgb(0,0,255)',
                  fillStyle: 'rgba(0,0,255, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line4, { strokeStyle: 'rgb(0, 0, 255',fillStyle: 'rgba(0, 0, 255, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line5, { strokeStyle: 'rgb(0,255,255)',fillStyle: 'rgba(0,255,255, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line6, { strokeStyle: 'rgb(255,0,255)',fillStyle: 'rgba(255,0,255, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line7, { strokeStyle: 'rgb(128,0,0)', fillStyle: 'rgba(128,0,0, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line8, { strokeStyle: 'rgb(128,0,128)',fillStyle: 'rgba(128,0,128, 0.4)', 
                  lineWidth: 3 });
                smoothie.addTimeSeries(line9, { strokeStyle: 'rgb(0,128,0)', fillStyle: 'rgba(0,128,0, 0.4)', 
                  lineWidth: 3 });
              });
            </script></p>
            <table   id ="tab-1-1"  style="width:100%">       
            </table>
          </div>
          <div id="tabs-2">
           <p>
             <!--graph for the tab -2-->
             <canvas id="mycanvas2" width= "1700" height="300"></canvas>
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
             <!--graph for the tab -3-->
             <canvas id="mycanvas3" width= "1700" height="300"></canvas>
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
             <!--graph for the tab -4-->
             <canvas id="mycanvas4" width= "1700" height="300"></canvas>
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
            <!--graph for the tab -5-->
            <p>
              <canvas id="mycanvas5" width= "1700" height="300"></canvas>
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
              <!--graph for the tab -6-->
              <p>
                <canvas id="mycanvas6" width= "1700" height="300"></canvas>
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