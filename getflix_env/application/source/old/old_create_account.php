<?php

// Placer la partie logique autant que possible séparée de l'html
$first_name = "";
$last_name = "";
$email = "";
$password = "";

// la connexion à la base de données
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "getflix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "La connexion a été bien établie.";
} catch (PDOException $e) {
    // echo "La connexion a échoué: " . $e->getMessage();
}


if (isset($_POST["submit"])) {
    $first_name = htmlentities($_POST['first_name']);
    $last_name = htmlentities($_POST['last_name']);
    $email = htmlentities($_POST['email']);
    $password;

    $sql = ("INSERT INTO `register`(`first_name`, `last_name`, `email`, `password`) VALUES (:first_name, :last_name, :email, :password)");
    $stmt = $conn->prepare($sql);

    if (htmlentities($_POST['password']) == htmlentities($_POST['password2']) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // on crypte le password du nouveau client
        $password = password_hash(($_POST['password']), PASSWORD_DEFAULT);
        // rajoute un email validation API? (si le temps)
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- icone onglet à placer plus tard 
    <link rel="icon" type="image/png" href="">
    -->
    <!-- Bootstrap styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Create account</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body class="bg-dark text-white">
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <div class="text-center" id="logo_container">
                    <img src="./img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">Create your account and join Getflix</h5>
            </div>
        </div>
    </div>

    <!-- Form new account -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <!-- S'identifier // form -->
                <form method="post" action="" id="form">
                    <div class="mb-3">
                        <input type="text" name="first_name" class="form-control form-control-lg" id="first_name" placeholder="first name" minlength="1" maxlength="40" autofocus required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="last_name" class="form-control form-control-lg" id="last_name" minlength="1" maxlength="40" placeholder="last name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="email" aria-describedby="emailHelp" placeholder="email address" minlength="5" maxlength="40" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="password" maxlength="12" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password2" class="form-control form-control-lg" id="password2" placeholder="repeat password" maxlength="12" minlength="8" required>
                        <div class="form-text text-light">Password between 8 and 12 characters.</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Create account</button>
                    </div>
                </form>
                <div id="alert_message">
                    <p class="pt-2" id="password_verification" hidden>You must write the same password twice! </p>
                </div>
            </div>
        </div>
    </div>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="./create_account.js"></script>
</body>

</html>