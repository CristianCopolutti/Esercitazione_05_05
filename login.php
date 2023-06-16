<?php

require_once "config.php";
require_once "session.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verifichiamo se l'utente non ha inserito l'email
    if (empty($email)) {
        $error .= '<p class="error">Riempi il campo email!</p>';
    }

    if (empty($password)) {
        $error .= '<p class="error">Riempi il campo password!</p>';
    }

    if (empty($error)) {
        if ($query = $db->prepare("SELECT * FROM utenti WHERE email = ?")) {
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($password === $row['password']) {
                    $_SESSION["userid"] = $row['id'];
                    $_SESSION["name"] = $row['email'];
                    header("location: home.php");
                    exit;
                } else {
                    $error .= '<p class="error">Password non corretta</p>'; 
                }
            } else {
                $error .= '<p class="error">Non esiste alcun utente con questo indirizzo email!</p>';
            }
        }
        $query->close();
    }
    mysqli_close($db);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Login!</h2>
                    <?php echo $error; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Indirizzo e-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Invio">
                        </div>
                        <p>Non hai un account? <a href="registrazione.php">Registrati qui</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
