<?php

    #CONTROLLO USERNAME UNICO
    // require_once 'dbconfig.php';

    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }

    header('Content-Type: application/json');

    $connection = mysqli_connect("localhost", "root") or die("impossibile connettersi al server");

    mysqli_select_db ($connection, "HW1") or die("impossibile connettersi al database");
    $username = mysqli_real_escape_string($connection, $_GET["q"]);
    $query = "SELECT username FROM users WHERE username = '$username'";
    $res = mysqli_query($connection, $query) or die(mysqli_error($connection));

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));//codifica un valore dato ad una stringa usando la sintassi json

    mysqli_close($connection);

?>