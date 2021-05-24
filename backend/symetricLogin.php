<?php

    session_start();

    $request = 2;
    if(isset($_GET['request'])){
        $request = $_GET['request'];        //1 = GET, 2 = POST
    }

    //POST
    if($request == 2){

        $data = json_decode(file_get_contents("php://input"));
        $username = $data->username;    
        $password = $data->password;

        $plainpassword = $password ^ $_SESSION["diffieKey"];

        echo $plainpassword;

        exit;
    }