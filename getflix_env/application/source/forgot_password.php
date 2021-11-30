<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ./profil.php');
    exit();
}
use PHPMailer\PHPMailer\PHPMailer;
$msg = '';
if (!empty($_POST)) {
    if (isset($_POST['email']) and !empty($_POST['email'])) {
        // message à l'utilisateur
        $_SESSION['error'] = [];
        //  le formulaire est complété
        // On vérifie que le mail a le bon format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'This email is invalid.';
        }
        if ($_SESSION['error'] === []) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            // la connexion à la base de données
            include_once './connect.php';
            $sql = 'SELECT * FROM register WHERE `email` = :email';
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();

            if ($user) {
                // généré un nouveau mot de passe 13charactères unique
                $password = uniqid();
                $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

                // phpmailer
                $subject = 'Forgot password';
                $message = "hello, here is your new password : $password";

                require_once './PHPMailer/PHPMailer.php';
                require_once './PHPMailer/SMTP.php';
                require_once './PHPMailer/Exception.php';

                $mail = new PHPMailer();

                // smtp settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '	room237.getflix@gmail.com';
                $mail->Password = 'Getflixproject';
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';

                // email settings
                $mail->isHTML(true);
                $mail->setFrom($email);
                $mail->addAddress("$email");
                $mail->Subject = "$email ($subject)";
                $mail->Body = $message;

                // changé le mot de passe dans la base de donnée si email envoyé
                if ($mail->send()) {
                    $sql = 'UPDATE register SET password = ? WHERE email = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$hashedPassword, $email]);
                    $msg =
                        "<p style='color:green'>Check your mail for your new password </p>";
                } else {
                    $message =
                        "<p style='color:red'>Error, email not send.</p>";
                }
            }
        }
    } else {
        $_SESSION['error'] = [
            "<p style='color:red'>Please, fill-in the form correctly.</p>",
        ];
    }
}

//  // php mail
//  $subject = 'Forgot password';
//  $message = "hello, here is your new password : $password";
//  $headers = [
//      'FROM' => 'no-reply@site.be',
//      'Reply-To' => 'replyto@example.com',
//      'Cc' => 'copie@site.be',
//      'Bcc' => 'copiecache@site.be',
//      'Content-Type' => 'text/html; charset=utf-8',
//  ];

//  if (mail($email, $subject, $message, $headers)) {
//      $sql = 'UPDATE register SET password = ? WHERE email = ?';
//      $stmt = $conn->prepare($sql);
//      $stmt->execute([$hashedPassword, $email]);
//      $msg =
//          "<p style='color:green'>Your Password succesfully changed</p>";
//  }
?>


<!DOCTYPE html>
<html lang="en">
<?php include_once './head.php'; ?>

<body class="bg-dark text-white">
    <?php include_once './header.php'; ?>
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <div class="text-center" id="logo_container">
                    <img src="./img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">Plongez dans l'horreur avec Getflix</h5>
            </div>
        </div>
    </div>
    <!-- Form sign in -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <!-- S'identifier // form -->
                <h6 class="text-left">Enter your email</h6>
                <!-- message d'erreur -->
                <?php
                if (isset($_SESSION['error'])) {
                    foreach ($_SESSION['error'] as $message) { ?>
                <p><?php echo $message; ?></p>
                <?php }
                    unset($_SESSION['error']);
                }
                echo $msg;
                ?>
                <form method="post" action="" id="form">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="email address" autofocus>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once './footer.php'; ?>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>