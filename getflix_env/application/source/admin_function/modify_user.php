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
    } else {
        header('Location: ../profil.php');
    }
} else {
    header('Location: ../profil.php');
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
            $_POST['user_type']
        ) &&
        !empty($_POST['first_name']) &&
        !empty($_POST['last_name']) &&
        !empty($_POST['email']) &&
        !empty($_POST['user_type'])
    ) {
        $_SESSION['message'] = [];
        // clean les variables
        $newfirst_name = test_input($_POST['first_name']);
        $newlast_name = test_input($_POST['last_name']);

        if (strlen($first_name) < 1) {
            $_SESSION['error'][] = 'first name to short';
        }
        if (strlen($last_name) < 1) {
            $_SESSION['error'][] = 'last name to short';
        }

        // je vérifie que le mail donné a bien une structure email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'This email is invalid.';
        }
        if ($_SESSION['error'] === []) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            // select * from your_table where id !=5
            // comparé l'id a a db
            $sql = 'SELECT * FROM register WHERE id=:id';
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();
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
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid px-5">
                <a class="navbar-brand" href="#">
                    <h1>GetFlix</h1>
                </a><img src="../img/EyeHorror.png" alt="..." height="80">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded=" false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav px-5">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>

                        <li class="nav-item dropdown px-5">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Genres
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Animated movies</a></li>
                                <li><a class="dropdown-item" href="#">Cannibal</a></li>
                                <li><a class="dropdown-item" href="#">Comedy</a></li>
                                <li><a class="dropdown-item" href="#">Gore</a></li>
                                <li><a class="dropdown-item" href="#">Killer</a></li>
                                <li><a class="dropdown-item" href="#">Monster movies</a></li>
                                <li><a class="dropdown-item" href="#">Paranormal</a></li>
                                <li><a class="dropdown-item" href="#">Psychological</a></li>
                                <li><a class="dropdown-item" href="#">Slasher</a></li>
                                <li><a class="dropdown-item" href="#">Zombies</a></li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li><a class="dropdown-item" href="#">More genres</a></li>
                            </ul>
                        </li>

                        <li class="nav-item px-4">
                            <a class="nav-link" href="./profil.php">My profile</a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link" href="./create_account.php">Create account</a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link" href="./register.php">Connect</a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link" href="./deconnect.php">Deconnect</a>
                        </li>


                    </ul>
                </div>


                <form action="" class="">
                    <div class="input-group my-4">
                        <input type="text" class="form-control form-control-lg" placeholder="let's scream...">
                        <button type="submit" class="input-group-text btn-danger"><i class="bi bi-search me-2"></i>
                            Search</button>
                    </div>
                </form>

            </div>
        </nav>
    </header>
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
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
                <div id="alert_message">
                    <?php if (isset($_SESSION['error'])) {
                        foreach ($_SESSION['error'] as $message) { ?>
                    <p style='color:red'><?php echo $message; ?></p>
                    <?php }
                        unset($_SESSION['error']);
                    } ?>
                </div>
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