<?php

error_reporting(0); // for stop showing warning message

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'POST'){

    $inputData = json_decode(file_get_contents('php://input'), true);

    if(empty($inputData)){
        // echo $_POST['name'];

        $storeCustomer = storeCustomer($_POST); // use for form data
    }else{
        $storeCustomer = storeCustomer($inputData); //use for raw data

    }
    echo $storeCustomer;

}else{

    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Method Not Allowed'
      ];
      header('HTTP/1.0 405 Method Not Allowed');
      echo json_encode($data);
}


?>