<?php

define('DBSERVER', 'localhost');
define('DBUSERNAME', 'root');
define('DBPASSWORD', '');
define('DBNAME', 'esercitazione0505');

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

//controllo connessione
if($db === false){
    die("Errore: errore connessione . " . mysqli_connect_error());
}

?>