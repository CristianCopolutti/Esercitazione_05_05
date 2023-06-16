<?php

session_start();

//controlla se l'utente è già loggato, in caso positivo verrà automaticamente indirizzato a una pagina home.php

if(isset($_SESSION["userid"]) && $_SESSION["userid"] === true){
    header("location: home.php");
    exit;
}

?>