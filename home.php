<?php
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }

?>

<html>
    <?php 
    // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar (mobile)
        $connection = mysqli_connect("localhost", "root") or die("impossibile connettersi al server");
        mysqli_select_db ($connection, "HW1") or die("impossibile connettersi al database");
        $userid = mysqli_real_escape_string($connection, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($connection, $query);
        $userinfo = mysqli_fetch_assoc($res_1);
    ?>

    <head>
        <title>F1</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <script src="home.js" defer="true"></script>
        <link rel="stylesheet" href="home.css"/>

    </head>

    <body>
        <header id="id_header">
            <div id="overlay"></div>
            <h1> Homepage</h1>
            <nav id="id_nav">
                
                <a href="race.php">Race</a>
                <a href="storia.php">Storia</a>   
                <a href="profile.php">Profilo</a>
                <a href="logout.php">Logout</a> 
                        

            <div id="menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
        </header>

        <section id ="search">
            
        </section>

        <section id="results">
        </section>

        <footer id="id_footer">
           <adress> 
           ©Maria Alisia Scorciapino 1000015005
        </adress>
        </footer>
    </body>
</html>