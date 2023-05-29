<?php
    require_once 'auth.php';
    if (checkAuth()) {
        header("Location: home.php");
        exit;
    } 

    // Verifica l'esistenza dei dati POST
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
    {
        $error = array();//dubbio
        $connection = mysqli_connect("localhost","root") or die(mysqli_error($connection));
        mysqli_select_db ($connection, "HW1") or die("Impossibile connettersi al database");

        #USERNAME
        // Controlla che l'username rispetti il pattern specificato
        //preg_match ha come parametri il pattern e l'oggetto
        if(!preg_match('/^[a-z0-9_-]{3,15}$/', $_POST['username'])){ //Pattern
            $error[] = "Username non valido";//dubbio $error
        }else{
            $username = mysqli_real_escape_string($connection,$_POST['username']);
            $query = "SELECT username FROM users WHERE username = '".$username."'";
            $res = mysqli_query($connection, $query); //risultato
            if (mysqli_num_rows($res) > 0) { //numero righe risultato
                $error[] = "Username già utilizzato";
            }
        }

        # PASSWORD
        if (strlen($_POST["password"]) < 8) { //calcola la lunghezza della stringa
            $error[] = "La password non rispetta il numero di caratteri richiesti";
        } 

        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Errore password";
        }

        # EMAIL
        //Controlla se è un indirizzo email valido
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $error[] = "Email non valida";
        }else{
            //strtolower converte tutti i caratteri in minuscolo
            $email = mysqli_real_escape_string($connection, strtolower($_POST['email']));
            $query = "SELECT email FROM users WHERE email = '".$email."'";
            $res = mysqli_query($connection, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }


        #IMMAGINE PROFILO
        if (count($error) == 0) { 
            if ($_FILES['profile']['size'] != 0) {//dubbio
                $file = $_FILES['profile'];
                $type = exif_imagetype($file['tmp_name']);//nome temporaneo dei file caricati generato automaticamente da php
                //funzione di php per determinare il tipo di una immagine
                $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
                if (isset($allowedExt[$type])) {
                    if ($file['error'] === 0) {
                        if ($file['size'] < 7000000) {
                            $fileNameNew = uniqid('', true).".".$allowedExt[$type];//uniqid=funzione che genera un id unico basato sul microtime
                            $fileDestination = 'upload/'.$fileNameNew;
                            move_uploaded_file($file['tmp_name'], $fileDestination);
                        } else {
                            $error[] = "L'immagine non deve avere dimensioni maggiori di 7MB";
                        }
                    } else {
                        $error[] = "Errore nel carimento del file";
                    }
                }else {
                    $error[] = "I formati consentiti sono .png, .jpeg, .jpg e .gif";
                }
            }else{
                echo "Non hai caricato nessuna immagine";
            }
        }

        #REGISTRAZIONE NEL DATABASE
         if (count($error) == 0){
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);//crea un nuovo ash della password

            $query = "INSERT INTO users(username, password, email, img) VALUES('$username', '$password', '$email', '$fileDestination')";

            if (mysqli_query($connection, $query)) {
                $_SESSION["user_username"] = $_POST["username"];
                $_SESSION["user_id"] = mysqli_insert_id($connection);//Ritorna il valore generato dall'ultima query per una colonna auto_increment
                mysqli_close($connection);
                header("Location: home.php");
                exit;
            } else{
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($connection);
    }
    else if(isset($_POST["username"])){
        $error = array("Riempi tutti i campi");
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Sign up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="logo.png">
        <link rel="stylesheet" href="signup.css">

        <script src='signup.js' defer></script>
        
    </head>

    <body>
        <section class="main">
            <h1>Welcome to F1! Let’s begin the adventure</h1>
            <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                    
                <div class="username">
                    <label for='username'> Username </label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <div><img src="close.svg"/><span></span></div>
                </div>

                <div class="email">
                    <label for='email'> Email </label>
                    <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <div><img src="close.svg"/><span></span></div>
                </div>

                <div class="password">
                    <label for='password'> Password </label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    <div><img src="close.svg"/><span></span></div>
                </div>

                <div class="confirm_password">
                    <label for='confirm_password'> Conferma Password </label>
                    <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                    <div><img src="close.svg"/><span></span></div>
                </div>

                <div class="fileupload">
                    <label for='profile'>Scegli un'immagine profilo</label>
                        <input type='file' name='profile' accept='.jpg, .jpeg, image/gif, image/png' id="upload_original">
                        <div id="upload"><div class="file_name"></div><div class="file_size"></div></div>
                    <span></span>
                </div>

                <div class="allow"> 
                    <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                    <label for='allow'>Accetto i termini e condizioni d'uso</label>
                </div>

                <?php 
                if(isset($error)){
                    foreach($error as $err) {
                        echo "<div class='errorj'><img src= 'close.svg'/><span>".$err."</span></div>";
                    }
                } 
                ?>
                
                <div class="submit">
                    <input type='submit' value="Sign up" id="submit">
                </div>
            </form>

            <div class="signup">Already have an account? 
                <a href="login.php"> Sign in </a>
            </div>
        </section>
    </body>
</html>