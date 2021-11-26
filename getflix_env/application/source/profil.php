<?php session_start();
$msg = '';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    return $data;
}

if (!empty($_POST)) {
    if (
        isset(
            $_POST['password'],
            $_POST['newpassword'],
            $_POST['newpassword2']
        ) &&
        !empty($_POST['password']) &&
        !empty($_POST['newpassword']) &&
        !empty($_POST['newpassword2'])
    ) {
        // connect db
        require_once './connect.php';

        $_SESSION['error'] = [];
        $password = $_POST['password'];
        $newpassword = $_POST['newpassword'];
        $newPassword2 = $_POST['newpassword2'];

        if ($newpassword != $newPassword2) {
            $_SESSION['error'] = [
                "<p style='color:red'>New passwords not identical</p>",
            ];
        }

        if ($_SESSION['error'] === []) {
            $email = $_SESSION['user']['email'];

            $sql = 'SELECT * FROM register WHERE email=:email';
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();
            if (!$user) {
                $_SESSION['error'][] =
                    "<p style='color:red'>Invalid user or password</p>";
            }
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error'][] =
                    "<p style='color:red'>Invalid password</p>";
            }

            if ($_SESSION['error'] === []) {
                // clean + hash
                $newpassword = test_input($newpassword);
                $newpassword = password_hash($newpassword, PASSWORD_ARGON2ID);

                // envoyé le nouveau mot de passe

                $con =
                    'update register set password=:newpassword where email=:email';
                $chngpwd1 = $conn->prepare($con);
                $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
                $chngpwd1->bindParam(
                    ':newpassword',
                    $newpassword,
                    PDO::PARAM_STR
                );
                $chngpwd1->execute();
                $msg =
                    "<p style='color:red'>Your Password succesfully changed</p>";
            }
        }
    } else {
        $_SESSION['error'] = ["<p style='color:red'>Empty field</p>"];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>profile</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
</head>

<body class="bg-dark text-white">
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <div class="text-center" id="logo_container">
                    <img src="./img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">Hello <?php echo $_SESSION['user'][
                    'first_name'
                ]; ?>, welcome in your profile Getflix</h5>
                <p class="text-center">Last name : <?php echo $_SESSION['user'][
                    'last_name'
                ]; ?> </p>
                <p class="text-center">First name : <?php echo $_SESSION[
                    'user'
                ]['first_name']; ?> </p>
                <p class="text-center">email : <?php echo $_SESSION['user'][
                    'email'
                ]; ?> </p>
            </div>
        </div>
    </div>

    <!-- Form new account -->
    <div class="container" id="changePass">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <h5 class="text-center">Change your password Getflix</h5>
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
                <!-- changer password // form -->
                <form method="post" action="<?php echo htmlspecialchars(
                    $_SERVER['PHP_SELF']
                ); ?>" id="form">

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" id="password"
                            placeholder="password" maxlength="12" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="newpassword" class="form-control form-control-lg" id="newpassword"
                            placeholder="new password" maxlength="12" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password2" class="form-control form-control-lg" id="newpassword2"
                            placeholder="repeat new password" maxlength="12" minlength="8" required>
                        <div class="form-text text-light">Passwords between 8 and 12 characters.</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Change password</button>
                    </div>
                </form>


                <br>
                <div class="border-top border-danger border-top-2 pb-4">
                    <br>
                    <h5 class="text-center">Change your information Getflix</h5>
                    <br>
                    <form method="post" action="<?php echo htmlspecialchars(
                        $_SERVER['PHP_SELF']
                    ); ?>" id="form">

                        <div class="mb-3">
                            <div class="form-text text-light">first name:</div>
                            <input type="text" name="first_name" class="form-control form-control-lg" id="first_name"
                                placeholder="first name" minlength="1" maxlength="40" value="<?php echo $_SESSION[
                                    'user'
                                ]['first_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-text text-light">last name:</div>
                            <input type="text" name="last_name" class="form-control form-control-lg" id="last_name"
                                placeholder="last name" minlength="1" maxlength="40" value=" <?php echo $_SESSION[
                                    'user'
                                ]['last_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-text text-light">email :</div>
                            <input type="email" name="email" class="form-control form-control-lg" id="email"
                                aria-describedby="emailHelp" placeholder="email address" minlength="5" maxlength="40"
                                value="<?php echo $_SESSION['user'][
                                    'email'
                                ]; ?>" required>
                            <div class="form-text text-light"></div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button name="submit" type="submit" class="btn btn-outline-light">Change your info</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="./create_account.js"></script>
</body>

</html>