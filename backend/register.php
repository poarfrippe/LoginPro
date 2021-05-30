<?php

    $username = "hirte";
    $password = "omegaseppl";

    $dsn="mysql:host=localhost:3306;dbname=loginprodb;";
    $user="root";
    $pass="root";
    $opt=[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    $pdo = new PDO($dsn,$user,$pass,$opt);

    $salt = "";
    for($i = 0; $i < 3; ++$i) {
        $salt .= chr(rand(65, 126));
    }

    $sql = "INSERT INTO `loginprodb`.`user` (`username`, `hashedPassword`, `saltPlain`) VALUES (?, ?, ?);";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$username, hash('sha256', $password.$salt), $salt]);
