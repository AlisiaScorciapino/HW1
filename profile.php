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
        <link rel='stylesheet' href='profile.css'>
        <script src='profile.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>F1<?php echo $userinfo['username']?></title><!--dubbio-->
    </head>

    <body>
        <header>
              <nav id="id_nav">
        <div id="links">
          <a href="home.php">Home</a>
                <a href="storia.php">Storia</a>   
                <a href="race.php">Race</a>
                <a href="logout.php">Logout</a>     
        </div>

                    <div id="menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>

                </div>
                <div class="userInfo">
                    <div class="profile" style="background-image: url(<?php echo $userinfo['profile'] == null ? "upload/default_profile.png" : $userinfo['profile'] ?>)">
                    </div>
                    <h1><?php echo $userinfo['username'] ?></h1>
                </div>               
            </nav>
        </header>

        <section class="container">

            <div id="results">
                
            </div>
    </section>
    </body>
</html>

<?php mysqli_close($connection); ?>