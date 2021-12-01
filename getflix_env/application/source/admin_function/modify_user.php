<?php
session_start();
// si pas connecté redirige vers connexion
if (!isset($_SESSION['user'])) {
    header('Location: ./register.php');
    exit();
}
// si connecté mais type = user alors redirigé vers profil
if ($_SESSION['user']['user_type'] === 'user') {
    header('Location: ./profil.php');
    exit();
}
// recup des données et création de var pour le form modify
if (isset($_GET['id'])) {
    require_once '../connect.php';
    $req = $conn->query('SELECT * FROM register WHERE id=' . $_GET['id']);
    $userId = $req->fetch();
    if ($userId) {
        $userFirstName = $userId['first_name'];
        $userLastName = $userId['last_name'];
        $userMail = $userId['email'];
        $userType = $userId['user_type'];
        $userDisplayId = $userId['id'];
    } else {
        header('Location: ../profil.php');
    }
}

function test_input($data)
{
    // $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    return $data;
}

// modifier le profil

if (!empty($_POST)) {
    if (
        isset(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            $_POST['user_type'],
            $_POST['userDisplayId']
        ) &&
        !empty($_POST['first_name']) &&
        !empty($_POST['last_name']) &&
        !empty($_POST['email']) &&
        !empty($_POST['user_type']) &&
        !empty($_POST['userDisplayId'])
    ) {
        // clean les variables
        $newfirst_name = test_input($_POST['first_name']);
        $newlast_name = test_input($_POST['last_name']);
        $userDisplayId = test_input($_POST['userDisplayId']);
        $userType = test_input($_POST['user_type']);
        $_SESSION['error'] = [];

        if (strlen($newfirst_name) < 1) {
            $_SESSION['error'][] = 'first name to short';
        }

        if (strlen($newlast_name) < 1) {
            $_SESSION['error'][] = 'last name to short';
        }

        // je vérifie que le mail donné a bien une structure email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'This email is invalid.';
        }

        if (strlen($newlast_name) < 1) {
            $_SESSION['error'][] = 'last name to short';
        }
        if ($_SESSION['error'] === []) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            // prendre les mails de la db sans prendre l'email de l'user sur cette fiche
            require_once '../connect.php';
            // compare les emails de la db sauf la row de l'utilisateur
            $sql =
                'SELECT * FROM register WHERE email=:email EXCEPT SELECT * FROM register WHERE id=:id';
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':id', $userDisplayId, PDO::PARAM_STR);
            $query->execute();
            $dataMail = $query->fetch();
            $cnt = 1;
            if ($query->rowCount() > 0) {
                $_SESSION['error'][] = 'The email already exists.';
            }

            if ($userType != 'user' && $userType != 'admin') {
                $_SESSION['error'][] = 'Error wrong user type';
            }
            if ($_SESSION['error'] === []) {
                // ajouter tout dans la db
                $con = 'update register set first_name=:newfirst_name,
                last_name=:newlast_name,
                email=:email,
                user_type=:user_type
                 where id=:id';
                $chnginfo = $conn->prepare($con);
                $chnginfo->bindParam(':id', $userDisplayId, PDO::PARAM_STR);
                $chnginfo->bindParam(
                    ':newfirst_name',
                    $newfirst_name,
                    PDO::PARAM_STR
                );
                $chnginfo->bindParam(
                    ':newlast_name',
                    $newlast_name,
                    PDO::PARAM_STR
                );
                $chnginfo->bindParam(':email', $email, PDO::PARAM_STR);
                $chnginfo->bindParam(':user_type', $userType, PDO::PARAM_STR);
                $chnginfo->execute();
                // redirection vers admin room
                header('Location: ../admin.php');
            }
        }
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
    <link rel="stylesheet" href="../assets/css/HeaderFooter.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body class="bg-dark text-white">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-black">
            <div class="container-fluid">
                <a class="navbar-brand px-4" href="#">
                    <img src="../img/logo_room237.svg"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item px-4 mt-4">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item px-4 mt-4">
                            <a class="nav-link" href="../admin_function/profil.php">
                                My profile
                            </a>
                        </li>
                        <li class="nav-item px-4 mt-4">
                            <a class="nav-link" href="../admin_function/create_account.php">Create account</a>
                        </li>
                        <li class="nav-item px-4 mt-4">
                            <button class="btn btn-rounded btn-dark"><a class="nav-link"
                                    href="./admin_function/register.php">Register</a></button>
                        </li>
                        <li class="nav-item px-4 mt-4">
                            <button class="btn btn-rounded btn-danger"><a class="nav-link"
                                    href="../admin_function/deconnect.php">Deconnect</a></button>
                        </li>
                        <li class="nav-item px-4 mt-4">
                            <a class="nav-link" href="../admin_function/admin.php">Admin</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-danger" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <!-- nav admin -->
                <ul>
                    <li><a href="../admin.php">admin pannel</a></li>
                </ul>
                <div class="text-center" id="logo_container">
                    <img src="../img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">admin - modify profil</h5>
            </div>
        </div>
    </div>

    <!-- Form new account -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <!-- S'identifier // form -->

                <?php if (isset($_SESSION['error'])) {
                    foreach ($_SESSION['error'] as $message) { ?>
                <p style='color:red'><?php echo $message; ?></p>
                <?php }
                    unset($_SESSION['error']);
                } ?>

                <form method="post" action="<?php echo htmlspecialchars(
                    $_SERVER['PHP_SELF']
                ); ?>" id="form">
                    <div class="mb-3">
                        <input type="text" name="first_name" class="form-control form-control-lg" id="first_name"
                            placeholder="first name" minlength="1" maxlength="40" value="<?php echo $userFirstName; ?>"
                            autofocus required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="last_name" class="form-control form-control-lg" id="last_name"
                            minlength="1" maxlength="40" placeholder="last name" value="<?php echo $userLastName; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="email"
                            aria-describedby="emailHelp" placeholder="email address" minlength="5" maxlength="40"
                            value="<?php echo $userMail; ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="user_type" class="form-control form-control-lg" id="user_type"
                            placeholder="user type" maxlength="5" minlength="4" value="<?php echo $userType; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="userDisplayId" class="form-control form-control-lg" id="user_type"
                            placeholder="user type" value="<?php echo $userDisplayId; ?>" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">modify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once '../footer.php'; ?>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="../create_account.js"></script>
</body>

</html>