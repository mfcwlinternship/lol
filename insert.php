<?php
header('Content-Type: application/json');
//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'automart_demo');
//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
// Escape user inputs for security
//$varMake = $_POST['country-list'];

// $dateFrom = $_POST['dateFrom'];
// $date = DateTime::createFromFormat('m/d/Y',$dateFrom);
// $from_date = $date->format("Y-m-d");

// $dateTo = $_POST['dateTo'];
// $fate = DateTime::createFromFormat('m/d/Y',$dateTo);
// $to_date = $fate->format("Y-m-d");

 
// attempt insert query execution

//All is set
if (isset($_POST['state-list']) && !empty($_POST['state-list']) &&
    isset($_POST['country-list']) && !empty($_POST['country-list']) &&
     $_POST['dateFrom'] !=""  && $_POST['dateTo'] != "" )
     
{

 
    $varModel = $_POST['state-list'];
    $varMake = $_POST['country-list'];
    $dateFrom = $_POST['dateFrom'];
    $date = DateTime::createFromFormat('m/d/Y',$dateFrom);
    $from_date = $date->format("Y-m-d");

    $dateTo = $_POST['dateTo'];
    $fate = DateTime::createFromFormat('m/d/Y',$dateTo);
    $to_date = $fate->format("Y-m-d");

    $query = sprintf("SELECT date_time, count(*) as c 
    FROM ibb_cardetails_tracker WHERE date_time BETWEEN DATE '$from_date' AND '$to_date' AND make
    = '$varMake' AND model = '$varModel' GROUP BY CAST(date_time as DATE)"); 
    
    //echo $query;
}


//date + make
else if( $_POST['dateFrom'] !=""  && $_POST['dateTo'] != "" && 
isset($_POST['country-list']) && !empty($_POST['country-list']) &&
 !(isset($_POST['state-list']) && !empty($_POST['state-list']))){  
   
    $varMake = $_POST['country-list'];
    $dateFrom = $_POST['dateFrom'];
    $date = DateTime::createFromFormat('m/d/Y',$dateFrom);
    $from_date = $date->format("Y-m-d");

    $dateTo = $_POST['dateTo'];
    $fate = DateTime::createFromFormat('m/d/Y',$dateTo);
    $to_date = $fate->format("Y-m-d");
   $query = sprintf("SELECT date_time, count(*) as c 
    FROM ibb_cardetails_tracker WHERE date_time BETWEEN DATE '$from_date' AND '$to_date' AND make
    = '$varMake'  GROUP BY CAST(date_time as DATE)");  
}
//make + model

else if(isset($_POST['state-list']) && !empty($_POST['state-list']) &&
isset($_POST['country-list']) && !empty($_POST['country-list']) && $_POST['dateFrom'] ==""  && $_POST['dateTo'] == ""){
    $varModel = $_POST['state-list'];
    $varMake = $_POST['country-list'];
    $query = sprintf("SELECT date_time, count(*) as c FROM ibb_cardetails_tracker WHERE make
    = '$varMake' AND model = '$varModel' AND 
    DATE(date_time) >= last_day(now()) + INTERVAL 1 DAY - INTERVAL 3 MONTH GROUP BY CAST(date_time as DATE)"); 
}

//date only 

else if(!(isset($_POST['state-list']) && !empty($_POST['state-list'])) &&
!(isset($_POST['country-list']) && !empty($_POST['country-list'])) && $_POST['dateFrom'] !=""  && $_POST['dateTo'] != ""){
    $dateFrom = $_POST['dateFrom'];
    $date = DateTime::createFromFormat('m/d/Y',$dateFrom);
    $from_date = $date->format("Y-m-d");

    $dateTo = $_POST['dateTo'];
    $fate = DateTime::createFromFormat('m/d/Y',$dateTo);
    $to_date = $fate->format("Y-m-d");

    $query = sprintf("SELECT date_time, count(*) as c 
    FROM ibb_cardetails_tracker WHERE date_time BETWEEN DATE '$from_date' AND '$to_date'  GROUP BY CAST(date_time as DATE)");  
}

//make only
else if(!(isset($_POST['state-list']) && !empty($_POST['state-list'])) &&

    isset($_POST['country-list']) && !empty($_POST['country-list']) &&
    
    $_POST['dateFrom'] ==""  && $_POST['dateTo'] == ""){
    
     $varMake = $_POST['country-list'];

    $query = sprintf("SELECT date_time, count(*) as c FROM ibb_cardetails_tracker WHERE make
    = '$varMake' AND 
    DATE(date_time) >= last_day(now()) + INTERVAL 1 DAY - INTERVAL 3 MONTH GROUP BY CAST(date_time as DATE)"); 

}
//nothing 
else if (!(isset($_POST['state-list']) && !empty($_POST['state-list'])) &&
!(isset($_POST['country-list']) && !empty($_POST['country-list'])) && $_POST['dateFrom'] ==""  && $_POST['dateTo'] == "") {

    $query = sprintf("SELECT date_time, count(*) as c FROM ibb_cardetails_tracker WHERE 
    DATE(date_time) >= last_day(now()) + INTERVAL 1 DAY - INTERVAL 3 MONTH GROUP BY CAST(date_time as DATE)"); 

}




 $result = $mysqli->query($query);

 $data = array();
foreach ($result as $row) {
	$data[] = $row;
}



// close connection
$result->close();
//close connection
$mysqli->close();
print json_encode($data);
?>