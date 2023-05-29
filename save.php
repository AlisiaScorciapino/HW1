<?php
    
    #Inserisce nel database il post da pubblicare 
    
    require_once 'auth.php';
    if (!$userid = checkAuth()) exit;

    f1();

    function f1() {
        global $userid;

        $connection = mysqli_connect("localhost", "root") or die("impossibile connettersi al server");
        mysqli_select_db ($connection, "HW1") or die("impossibile connettersi al database");
        
        # Costruisco la query
        $userid = mysqli_real_escape_string($connection, $userid);
        $data = mysqli_real_escape_string($connection, $_POST['data']);
        $track = mysqli_real_escape_string($connection, $_POST['track']);

        # check se è già presente per quell'utente
        $query = "SELECT * FROM race WHERE user_id = '$userid' AND id = '$id'";
        $res = mysqli_query($connection, $query) or die(mysqli_error($connection));
        # se è presente bene
        if(mysqli_num_rows($res) > 0) {
            echo json_encode(array('ok' => true));
            exit;
        }


        # Eseguo
        $query = "INSERT INTO race(user_id,data,track) VALUES('$userid','$data','$track')";
        error_log($query);
        
        if(mysqli_query($connection, $query) or die(mysqli_error($connection))) {
            echo json_encode(array('ok' => true));
            exit;
        }

        mysqli_close($connection);
        echo json_encode(array('ok' => false));
    }