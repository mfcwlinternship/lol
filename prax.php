<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ChartJS - BarGraph</title>
    <style type = "text/css">
            #chart-container{
                width: 640;
                height: auto; 
         }


		 body{
			 background-color : #C8EEFD;
			 
		 }
		 h1{
			 text-align : center;
			 font-family : verdana;
		 }
		 h2{
			 text-align : center;
			 font-family : verdana;
		 }
	</style>
	

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/Chart.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">

    <!-- <style>form{width:10%; margin:100px auto;}</style> -->

    <script type="text/javascript">
        $(document).ready(function () {
                $("#dateFrom").datepicker({
                    onClose: function () {
                        $("#dateTo").datepicker(
                            "change", {
                            minDate: new Date($('#dateFrom').val())
                        });
                       $("#dateFrom").datepicker({dateFormat: "dd/mm/yy"});

                    }
                });
        
                $("#dateTo").datepicker({
                    onClose: function () {
                        $("#dateFrom").datepicker(
                            "change", {
                            maxDate: new Date($('#dateTo').val())
                        });
                        $("#dateTo").datepicker({dateFormat: "dd/mm/yy"});

                    }
                });
            });
        </script>

</head>
<body>

<h1> Mahindra First Choice Wheels Ltd. 2018 <br> Data Access Dashboard </h1> 
<h2> Input details :- </h2>

<form method="post" id="result_form">
	<?php include 'index.php';?>
	<?php include 'client.php';?>
	<br>
	<?php include 'location.php';?>
	<br>
    <input type="submit" value="Submit" id="result_button">
    <style type="text/css">
        #chart-container {
            width: 1000px;
            height: auto;
        }
        </style>
   			 <center><div id="chart-container">

            <canvas id="mycanvas"></canvas>
            </div></center>
</form>

  <script>



  $("#result_button").click(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
		url: "http://localhost/chartjs/insert.php",
		


// The location of insert php was changed to fit my computer 


        data: $('#result_form').serialize(),
       success: function(data) {
			console.log(data);
			var date_time = [];
            var c =  [];
            

			for(var i in data) {
				date_time.push(data[i].date_time);
               c.push(data[i].c);
                
			}

			var chartdata = {
				labels: date_time,
				datasets : [
					{
						label: "Count ", //make this change dynamically 
						backgroundColor: 'rgba(0, 0, 0, 0)',
						borderColor: 'rgba(0, 255, 0, 1)',
						// hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						// hoverBorderColor: 'rgba(200, 200, 0, 0.75)',

						data: c
					}
				]
			}

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: "line",
                data: chartdata,
               options:{
				scales: {
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Number of Price Checks',
							fontSize: 20
						},
						ticks: {
							beginAtZero : true
						}
					}]
				}
			   } 
			});
		},
		error: function(data) {
			console.log(data);
		}
    });
});
  </script>
</body>
</html>
