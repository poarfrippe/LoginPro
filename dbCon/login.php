<?php

    $caesarkey = 3;

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

        $passArray = str_split($password);

        $decrypted = "";
        for ($i = 0; $i < count($passArray); ++$i){
            $decrypted .= chr(ord($passArray[$i]) - $caesarkey);
        }

        echo "vomserverzrugoberiatz: \n";
        echo "z";

        exit;
    }

    //header('Location: ./login.php');      //redirectet donn die gonze zeit lel lel lel
    //http_response_code(301);
    //print_r($_POST);
    //echo '<script>alert("Hello! I am an alert box!!");</script>';
