<?php
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>


<!DOCTYPE html>
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
        <title>Race</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="logo.png">
        <link rel="stylesheet" href="race.css">

        <script src='race.js' defer></script>

    </head>

    <body>
        <header id="id_header">
            <h1>Race</h1>

            <nav id="id_nav">
        <div id="links">
          <a href="home.php">Home</a>
                <a href="storia.php">Storia</a>   
                <a href="profile.php">Profilo</a>
                <a href="logout.php">Logout</a> 
                        </div>
        </div>


        <div id="menu">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </nav>
      
      <img src="race.gif"></img>
        </header>

      <section id="search">
        <form id="form" utocomplete="off">
          <div class="search">
            <label for='search'>Cerca</label>
            <input type='text' name="search" class="searchBar">
            <input type="submit" value="Cerca">
          </div>
        </form>
        
        <div id="results">   
            
        </div>

      </section>
        
    </body>
    <footer id="id_footer">
        <adress> ©Maria Alisia Scorciapino 1000015005</adress>
    </footer>
</html>




