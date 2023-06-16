<?php

    require_once "config.php";
    require_once "session.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

        $fullname = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        

        if($query = $db->prepare("SELECT * FROM utenti WHERE email = ?")){

            $error = '';

            $query->bind_param('s', $email);
            $query->execute();
            $query->store_result();

            //se la query restituisce un numero di righe maggiore di zero, vuol dire che esiste già una mail
            //come quella inserita nel form in fase di registrazione
            if ($query->num_rows > 0){
                $error .= '<p class="error"> Indirizzo email in uso! </p>';
            } else {
                //validare e verificare la password
                if (strlen($password) < 6){
                    $error .= '<p class="error">La password deve avere almeno 6 caratteri. </p>';
                }
            

                //verifico se la password reinserita è uguale alla password inserita prima
                if (empty($confirm_password)) {
                    $error .= '<p class="error"> Conferma password.</p>';
                 } else {
                    if (empty($error) && ($password != $confirm_password)){
                        $error .= '<p class="error">La password non corrisponde.</p>';
                    }
                }

                if (empty($error)){
                    $queryinsert = $db->prepare("INSERT INTO utenti(nome, email, password) VALUES (?, ?, ?);");
                    $queryinsert->bind_param("sss", $fullname, $email, $password);
                    $result = $queryinsert->execute();
                    if($result){
                        $error .= '<p class="success">Ti sei registrato correttamente!</p>';
                    } else {
                        $error .= '<p class="error">Qualcosa andato storto!</p>';
                    }
                }
            }
        }
        $query->close();
        $queryinsert->close();
        mysqli_close($db);
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Registrati</title>
        <link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class = "row">
                <div class="col-md-12">
                    <h2>Registrati!</h2>
                    <p>Riempi il form sottostante per creare un account.</p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nome completo</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Indirizzo email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Conferma password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Invia">
                        </div>
                        <p>Hai già un account? <a href="login.php">Effettua il login!</a></p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>