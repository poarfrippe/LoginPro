<?php

    $dsn="mysql:host=localhost:3306;dbname=loginprodb;";
    $user="root";
    $pass="root";
    $opt=[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    $pdo = new PDO($dsn,$user,$pass,$opt);

    $stmt = $pdo->query("SELECT * FROM loginprodb.user;");
    $user = $stmt->fetch();

    print_r($user);
    print_r($stmt->fetch());
    print_r($stmt->fetch());

    $stmt = $pdo->prepare("select * from user Where username = ?");
    $stmt->execute(["seppl"]);
    $user = $stmt->fetch();

    echo "<br><br>";
    print_r($user);

    echo "<br><br>";
    echo sha1 ("seppl");
    echo "<br>";
    echo hash('sha256', "seppl");
    echo "<br>";
    echo hash('sha256', "hirete");