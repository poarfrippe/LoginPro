<?php

    $keyfile = fopen("totallyNotImportant.txt", "r") or die("Unable to open file!");
    $e;
    $d;
    $N;
    // Output one line until end-of-file
    $N = explode(" ", fgets($keyfile))[1];
    $e = explode(" ", fgets($keyfile))[1];
    $d = explode(" ", fgets($keyfile))[1];
    fclose($keyfile);

    

    echo $N." ".$e." ".$d;

    /*
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
    */