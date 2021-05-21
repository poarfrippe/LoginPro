  
<?php

    function generate256bitKey() {
        
        
        return 7;
    }

    function decryptcaesar(int $key, $encryptedpasswd) {
        $passArray = str_split($encryptedpasswd);

        $decrypted = "";
        for ($i = 0; $i < count($passArray); ++$i){
            $decrypted .= chr(ord($passArray[$i]) - $key);
        }

        return $decrypted;
    }
  

    $key256bit = generate256bitKey();
    $caesarkey = 3;
    $request = 2;


    if(isset($_GET['request'])){
        $request = $_GET['request'];
    }

    //POST
    if($request == 2){

        $data = json_decode(file_get_contents("php://input"));
        $username = $data->username;    
        $password = $data->password;

        //echo "vomserverzrugoberiatz: \n";
        echo decryptcaesar($caesarkey, $password);

        exit;
    }