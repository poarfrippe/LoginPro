<?php

    $request = 1;
    if(isset($_GET['request'])){
        echo "request get set to ".$_GET['request'];
        $request = $_GET['request'];        //1 = GET, 2 = POST
    }

    
    if ($request == 1) {
        if (isset($_GET['get'])) {
            if ($_GET['get'] == "publicKey") {
                $keyfile = fopen("totallyNotImportant.txt", "r") or die("Unable to open file!");
                $N = explode(" ", fgets($keyfile))[1];
                $e = explode(" ", fgets($keyfile))[1];
                fclose($keyfile);

                echo $e;
                echo " ".$N;
                $request = 2;
            } else {
                http_response_code(400);
                echo "ERROR2";
            }
        } else {
            http_response_code(400);
            echo "ERROR";
        }
    }
