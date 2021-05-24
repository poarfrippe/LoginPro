  
<?php

    function generate256bitKey() {
        
        $booleanKey = array();

        for($i = 0; $i < 256; ++$i){
            $booleanKey[$i] = (rand ( 0 , 1 ) == 1) ? true : false;
        }
        
        return $booleanKey;
    }

    function decryptcaesar(int $key, $encryptedpasswd) {
        $passArray = str_split($encryptedpasswd);

        $decrypted = "";
        for ($i = 0; $i < count($passArray); ++$i){
            $decrypted .= chr(ord($passArray[$i]) - $key);
        }

        return $decrypted;
    }

    function addbinarys ($key, $message) {

        //nur zum Teysten gewesen...
        //$key = array(false, false, true, true);
        //$message = array(false, true, true, true);
        
        $summ = array();
        $carry = false;

        //full adder i guess
        for ($i = 0; $i < 256; ++$i) {      //0+0, 1+0, 0+1 und halt carrybit
            if (!($key[$i] && $message[$i]) && !($key[$i] && $carry) && !($carry && $message[$i])) {
                $summ[$i] = $key[$i] || $message[$i] || $carry;
                $carry = false;
            } else {        //1+1 und holt carrybit
                if(!$carry) {
                    $summ[$i] = false;
                } else {
                    $summ[$i] = true;
                }
                $carry = true;
            }
        }

        return $summ;
    }
  

    $key256bit = generate256bitKey();
    $caesarkey = 3;
    
    $request = 2;
    if(isset($_GET['request'])){
        $request = $_GET['request'];        //1 = GET, 2 = POST
    }

    //POST
    if($request == 2){

        $data = json_decode(file_get_contents("php://input"));
        $username = $data->username;    
        $password = $data->password;

        //echo "vomserverzrugoberiatz: \n";
        echo decryptcaesar($caesarkey, $password);
        //print_r(generate256bitKey());
        //print_r(addbinarys(1, 1));

        exit;
    }