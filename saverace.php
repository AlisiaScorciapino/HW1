<?php 
    
    require_once 'auth.php';
    if (!$userid = checkAuth()) exit;

    header('Content-Type: application/json');

savedRace();
function savedRace(){
    global $userid;
    $connection = mysqli_connect("localhost", "root") or die("impossibile connettersi al server");
    mysqli_select_db ($connection, "HW1") or die("impossibile connettersi al database");

    $userid = mysqli_real_escape_string($connection, $userid);
    
    $queryRace = "SELECT * from race where user_id= '$userid'";

    $resRace = mysqli_query($conn, $queryRace) or die(mysqli_error($connection));
    
    $RaceArray = array();
    while($row = mysqli_fetch_assoc($resRace)) {
        // Scorro i risultati ottenuti e creo l'elenco di post
        $RaceArray[] = $row;
    }

    mysqli_close($connection);

    echo json_encode($RaceArray);
    
    exit;
}
?>