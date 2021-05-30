<?php

    function powMod($x, $y, $p) {               //x^y % p
        $res = 1;

        $x = $x % $p;                           //dass x < p

        if ($x == 0)
            return 0;

        while ($y > 0)
        {
            //wenn y ungerade ist
            if ($y & 1)
                $res = ($res * $x) % $p;

            //y jetzt sicher gerade
            
            $y = $y >> 1;                       // y = y/2
            $x = ($x * $x) % $p;
        }
        return $res;
    }

    $request = 2;
    if(isset($_GET['request'])){
        echo "request get set to ".$_GET['request'];
        $request = $_GET['request'];        //1 = GET, 2 = POST
    }

    if($request == 2){        
        $data = json_decode(file_get_contents("php://input"));
        $rsaArray = $data->rsaArray;
        $username = $data->username;

        $keyfile = fopen("totallyNotImportant.txt", "r") or die("Unable to open file!");
        $N = explode(" ", fgets($keyfile))[1];
        $d = explode(" ", fgets($keyfile))[1];      //muss einfach nur zur naechsten Zeile weil hier ist e fuer public key
        $d = explode(" ", fgets($keyfile))[1];
        fclose($keyfile);

        $plainArray = array();
        for ($i = 0; $i < count($rsaArray); ++$i) {
            $plainArray[$i] = chr(powMod((int)$rsaArray[$i], $d, (int)$N));
        }

        $plainPasswd = implode("", $plainArray);

        //print_r($plainArray);
        echo $plainPasswd;

        exit;
    }