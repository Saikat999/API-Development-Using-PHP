<?php

require '../includes/db-connect.php';

//Fetch all the customer list
function getCustomerList(){

     global $con;

     $query = "SELECT * FROM customers";
     $query_run = mysqli_query($con,$query);

     if($query_run){
        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message'=> 'Customer List Fetched Successfully',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);


        }else{
            $data = [
                'status' => 404,
                'message'=> 'Customer Not Found'
            ];
            header('HTTP/1.0 404 Customer Not Found');
            return json_encode($data);
        }

     }else{

        $data = [
            'status' => 500,
            'message'=> 'Internal Server Error'
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
     }

}

//Function for create customer

function error422($message){

    $data = [
        'status' => 422,
        'message' =>$message
      ];
      header('HTTP/1.0 422 Unprocessable Entity');
      echo json_encode($data);
      exit();
}
function storeCustomer($customerInput){

    global $con;

    $name = mysqli_real_escape_string($con, $customerInput['name']);
    $email = mysqli_real_escape_string($con, $customerInput['email']);
    $phone = mysqli_real_escape_string($con, $customerInput['phone']);

    if(empty(trim($name))){
        return error422('Enter your name');

    }elseif(empty(trim($email))){
        return error422('Enter your email');

    }elseif(empty(trim($phone))){
        return error422('Enter your phone');

    }else{

        $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($con, $query);

        if($result){
            $data = [
                'status' => 201,
                'message'=> 'Customer Created Successfully'
            ];
            header('HTTP/1.0 201 Created');
            return json_encode($data);

        }else{

            $data = [
                'status' => 500,
                'message'=> 'Internal Server Error'
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }
    }
}


//Fetch single customer data

function getCustomer($customerParams){

    global $con;

    if($customerParams['id'] == null){

        return error422('Enter customer id');
    }

    $customerId = mysqli_real_escape_string($con,$customerParams['id']);

    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1 ";
    $result = mysqli_query($con, $query);

    if($result){

        if(mysqli_num_rows($result) > 0){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message'=> 'Customer Fetched Successfully',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);

        }else{

            $data = [
                'status' => 404,
                'message'=> 'No Customer Found'
            ];
            header('HTTP/1.0 404 Not Found');
            return json_encode($data);
        }

    }else{

        $data = [
            'status' => 500,
            'message'=> 'Internal Server Error'
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);

    }

}



?>