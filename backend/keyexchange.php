<?php

    session_start();

    $request = 2;
    if(isset($_GET['request'])){
        $request = $_GET['request'];        //1 = GET, 2 = POST
    }

    if ($request == 2) {
        $data = json_decode(file_get_contents("php://input"));
        $p = $data->p;
        $g = $data->g;
        $A = $data->A;

        //b generieren und B = g^b mod p und schicken
        //donn A^b mod p und fertig

        $b = -1;
        $B = -1;
        $key = -1;
        $b = rand (2, 100);
        $B = powMod($g, $b, $p);        //mit modularen Potenzieren, weil sunst fasst ers ueberhaupt nimmer

        $key = powMod($A, $b, $p);
        $_SESSION["diffieKey"] = $key;

        echo $B." ";
        exit;

    }

    function powMod($x, $y, $p) {
        // Initialize result
        $res = 1;
    
        // Update x if it is more
        // than or equal to p
        $x = $x % $p;
    
        if ($x == 0)
            return 0;
    
        while ($y > 0)
        {
            // If y is odd, multiply
            // x with result
            if ($y & 1)
                $res = ($res * $x) % $p;
    
            // y must be even now
            
            // y = $y/2
            $y = $y >> 1;
            $x = ($x * $x) % $p;
        }
        return $res;
    }
