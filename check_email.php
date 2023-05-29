<?php
    #CONTROLLO EMAIL UNICA

    //require_once 'dbconfig.php';
    
    // Controllo che l'accesso sia legittimo
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }

    // Imposto l'header della risposta
    header('Content-Type: application/json');//dubbio
    
    // Connessione al DB
    $connection = mysqli_connect("localhost", "root") or die("Impossibile connettersi al server");
    mysqli_select_db ($connection, "HW1") or die("Impossibile connettersi al database");

    // Leggo la stringa dell'email
    $email = mysqli_real_escape_string($connection, $_GET["q"]);

    // Costruisco la query
    $query = "SELECT email FROM users WHERE email = '$email'";

    // Eseguo la query
    $res = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // Torna un JSON con chiave exists e valore boolean
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    // Chiudo la connessione
    mysqli_close($connection);
?>