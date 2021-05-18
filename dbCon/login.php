<?php

    $request = 2;

    // Read $_GET value
    if(isset($_GET['request'])){
    $request = $_GET['request'];
    }

    //POST
    if($request == 2){

        // Read POST data
        $data = json_decode(file_get_contents("php://input"));

        $username = $data->username;
        $password = $data->password;

        echo "coolcoolcool";
        exit;
    }

    //header('Location: ./login.php');      //redirectet donn die gonze zeit lel lel lel
    //http_response_code(301);
    //print_r($_POST);
    //echo '<script>alert("Hello! I am an alert box!!");</script>';
