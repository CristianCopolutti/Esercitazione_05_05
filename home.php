<?php

require_once "session.php";

// Controlla se l'utente è loggato, altrimenti reindirizzalo alla pagina di login
if (!isset($_SESSION["userid"]) || empty($_SESSION["userid"])) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>HomePage</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Welcome! <strong><?php echo $_SESSION["name"]; ?></strong></h1>
                </div>
                <p><a href="logout.php" class="btn btn-danger">Esci</a></p>
            </div>
        </div>
    </body>
</html>
