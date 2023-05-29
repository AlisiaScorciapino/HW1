<?php
    //Verifica se l'utente è già registrato
    include 'auth.php';
    if(checkAuth()){
        //Va alla Home
        header("Location: home.php");
        exit;
    }

    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        //Se username e password sono stati inviati

        //Connessione al db
        $connection = mysqli_connect("localhost", "root") or die(mysqli_error($connection));
        mysqli_select_db ($connection, "HW1") or die("Impossibile connettersi al database");
    

        $username = mysqli_real_escape_string($connection,$_POST['username']);

        $query= "SELECT * FROM users WHERE username = '".$username."'";
        //Funzione per l'esecuzione della query
        $res = mysqli_query($connection, $query) or die(mysqli_error($connection));

        if (mysqli_num_rows($res) > 0){//Per leggere il numero di righe del result set
            //Ritorna una sola riga e questo non è un problema
            $row = mysqli_fetch_assoc($res);

            if(password_verify($_POST["password"], $row["password"]))
            {
                //Imposto una sessione
                $_SESSION["user_username"]= $row["username"];
                $_SESSION["user_id"]= $row["id"];
                header("Location: home.php");
                mysqli_free_result($res);//Libera lo spazio occupato dai risultati di una query
                mysqli_close($connection);
                exit;
            }
        }
        //Se l'utente non è stato trovato o ha inserito una password che non va bene
        $error="Username e/o password errati";
    }else if(isset($_POST["username"]) || isset($_POST["password"]))
    {
        //Se è stato impostato solo uno dei campi,quindi solo username o password
        $error = "Inserisci username e/o password";
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="login.css">
        <link rel="icon" type="image/png" href="logo.png">

        <title>Sign in</title>
    </head>

    <body>
        <section id="id_section">
        <main class="main">
            <?php
                // Verifica se ci sono errori
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
            ?>

            <form name='login' id='login 'method='post'>
                <!-- Seleziono il valore di ogni campo sulla base dei valori inviati al server via POST -->
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' id='username' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>

                <div class="password">
                    <input type='password' id='password' name='password' placeholder='Password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>

                <div class="submit_container">
                    <div class="login_btn">
                        <input type='submit' value="Sign in">
                    </div>
                </div>
            </form>

            <div class="signup"><h4>Non hai un account?</h4></div>
            <div class="signup_btn_container">
                <a class="signup_btn" href="signup.php">Sign up</a>
            </div>
            </main>
            </section>
    </body>
</html>