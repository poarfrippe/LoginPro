<?php

    function checkIfPrime($tocheck) {
        $a = false;
        for ($i = 2; $i < $tocheck; $i++) {
            if ($tocheck%$i===0) {
            $a = true;
            }
        }

        return !$a;
    }

    function generatePrime($howbig) {
        $obgefunden = false;
        $p = -1;
        while(!$obgefunden) {
            $p = rand($howbig/10 + 1, $howbig);
            if (checkIfPrime($p)) {
                $obgefunden = true;
            }
        }
        return $p;
    }

    function ggt ($a, $b) {
        return $b ? ggt($b, $a % $b) : $a;
    }

    function getE($phiN) {
        $i = 2;
        while(ggt($i, $phiN) != 1) {
            ++$i;
        }
        if ($i >= $phiN) {
            echo "e groesser als Phi(N)!! ERRRROR";
            return -1;
        }
        return $i;
    }

    function getD ($phiN, $e) {
        $k = 1;

        while((($k*$phiN)+1)%$e != 0) {
            ++$k;
        }

        return (($k*$phiN)+1)/$e;
    }


//------------------------------------------------------------------------------------------------------
    $p = generatePrime(100000);
    $q = -1;
    do {
        $q = generatePrime(100000);
    } while($q == $p);

    $N = $p*$q;
    $phiN = ($p-1)*($q-1);

    //1<e<phiN
    //e teilerfremd mit phiN
    $e = getE($phiN);

    /**
     * (e*d) mod phiN = 1
     * phiN + 1 mod phiN = 1
     * e*d = phiN + 1
     * d = (phiN + 1) / e
     * wenn kommazahl dann vielfaches von phiN nehmen und +1 dass mod phiN immer 1 reuskommt
     */

    $d = getD($phiN, $e);

    $keyfile = fopen("totallyNotImportant.txt", "w") or die("Unable to open file!");
    $txt = "N: ".$N."\ne: ".$e."\nd: ".$d;
    fwrite($keyfile, $txt);
    fclose($keyfile);

    echo "N: ".$N."<br>e: ".$e."<br>d: ".$d;
    
