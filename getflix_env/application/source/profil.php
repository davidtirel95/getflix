<?php session_start();
$msg = '';
function test_input($data)
{
    // $data = trim($data);
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
        $password = test_input($_POST['password']);
        $newpassword = test_input($_POST['newpassword']);
        $newPassword2 = test_input($_POST['newpassword2']);

        if ($newpassword != $newPassword2) {
            $_SESSION['error'] = [
                "<p style='color:red'>New passwords not identical</p>",
            ];
        }

        if ($_SESSION['error'] === []) {
            $id = $_SESSION['user']['id'];

            $sql = 'SELECT * FROM register WHERE id=:id';
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
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
                $newpassword = trim(test_input($newpassword));
                $newpassword = password_hash($newpassword, PASSWORD_ARGON2ID);
                // regex
                if (
                    !preg_match(
                        '~(?=.*[0-9])(?=.*[a-z])^[a-zA-Z0-9]{8,13}$~',
                        $password
                    )
                ) {
                    $_SESSION['error'][] =
                        "<p style='color:red'>the password must contain at least 1 letter and 1 number and no space</p>";
                }

                if ($_SESSION['error'] === []) {
                    // envoyé le nouveau mot de passe

                    $con =
                        'update register set password=:newpassword where id=:id';
                    $chngpwd1 = $conn->prepare($con);
                    $chngpwd1->bindParam(':id', $id, PDO::PARAM_STR);
                    $chngpwd1->bindParam(
                        ':newpassword',
                        $newpassword,
                        PDO::PARAM_STR
                    );
                    $chngpwd1->execute();
                    $msg =
                        "<p style='color:green'>Your Password succesfully changed</p>";
                }
            }
        }
    } else {
        $_SESSION['error'] = [
            "<p style='color:red'>Please, fill-in the form correctly.</p>",
        ];
    }
}

// changement d'info
if (
    isset($_POST['first_name'], $_POST['last_name']) and
    !empty($_POST['first_name']) and
    !empty($_POST['last_name'])
) {
    require_once './connect.php';
    $_SESSION['message'] = [];
    $_SESSION['error2'] = [];
    // clean les variables
    $newfirst_name = test_input($_POST['first_name']);
    $newlast_name = test_input($_POST['last_name']);
    // récupérer l'id
    $id = $_SESSION['user']['id'];
    // comparé l'id à la base de donnée
    $sql = 'SELECT * FROM register WHERE id=:id';
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();
    if (!$user) {
        $_SESSION['error2'][] = "<p style='color:red'>Invalid user </p>";
    }
    if ($_SESSION['error2'] === []) {
        // changé les info
        $con = 'update register set first_name=:newfirst_name,
        last_name=:newlast_name
         where id=:id';
        $chnginfo = $conn->prepare($con);
        $chnginfo->bindParam(':id', $id, PDO::PARAM_STR);
        $chnginfo->bindParam(':newfirst_name', $newfirst_name, PDO::PARAM_STR);
        $chnginfo->bindParam(':newlast_name', $newlast_name, PDO::PARAM_STR);
        $chnginfo->execute();

        // update les info(nom et prenom) MAIS guardé les info id mal et type!!!!

        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $newfirst_name,
            'last_name' => $newlast_name,
            'email' => $user['email'],
            'user_type' => $user['user_type'],
        ];
        header('Location: ./profil.php');
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
    <title>Create account</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/8e9298d105.js" crossorigin="anonymous"></script>
    <!-- styles -->
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <!-- Flèches typo -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <?php include_once './header.php'; ?>
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
                <p class="text-center">First name : <?php echo $_SESSION[
                    'user'
                ]['first_name']; ?> </p>
                <p class="text-center">Last name : <?php echo $_SESSION['user'][
                    'last_name'
                ]; ?> </p>
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
                            placeholder="password" maxlength="13" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="newpassword" class="form-control form-control-lg" id="newpassword"
                            placeholder="new password" maxlength="13" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="newpassword2" class="form-control form-control-lg"
                            id="newpassword2" placeholder="repeat new password" maxlength="12" minlength="8" required>
                        <div class="form-text text-light">Passwords between 8 and 13 characters.</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Change password</button>
                    </div>
                </form>

                <!-- change info -->
                <br>
                <div class="border-top border-danger border-top-2 pb-4">
                    <br>
                    <h5 class="text-center">Change your information Getflix</h5>
                    <br>
                    <!-- mesage2 user -->
                    <?php if (isset($_SESSION['error2'])) {
                        foreach ($_SESSION['error2'] as $message) { ?>
                    <p><?php echo $message; ?></p>
                    <?php }
                        unset($_SESSION['error2']);
                    } ?>

                    <form method="post" action="<?php echo htmlspecialchars(
                        $_SERVER['PHP_SELF']
                    ); ?>" id="form2">

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
                                placeholder="last name" minlength="1" maxlength="40" value="<?php echo $_SESSION[
                                    'user'
                                ]['last_name']; ?>" required>
                        </div>
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

    <?php include_once './footer.php'; ?>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

</body>

</html>