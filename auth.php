<?php

//Controllo se l'utente è già autenticato

session_start();//Avvia la sessione

function checkAuth(){
    //Se esiste una sessione la ritorno, altrimento torno 0
    if(isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
    }else 
        return 0;
}
?>