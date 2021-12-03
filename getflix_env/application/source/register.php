<?php
// On va pouvoir connecter la session
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ./profil.php');
    exit();
}
// Placer la partie logique autant que possible séparée de l'html
$email = '';
$password = '';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    return $data;
}

// vérifier si le form a été envoye
if (!empty($_POST)) {
    // à partir d'ici je sais que le formulaire a été envoyé
    // Mnt on vérifie que tous les champs requis (ici tous) sont remplis
    if (
        isset($_POST['email'], $_POST['password']) and
        !empty($_POST['email']) and
        !empty($_POST['password'])
    ) {
        // messaga à l'utilisateur
        $_SESSION['error'] = [];
        // le formulaire est complété
        // On vérifie que le mail a le bon format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'This email is invalid.';
        }
        if ($_SESSION['error'] === []) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = test_input($_POST['password']);
            // la connexion à la base de données
            include_once './connect.php';
            $sql = 'SELECT * FROM register WHERE `email` = :email';
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();

            if (!$user) {
                $_SESSION['error'] = ['incorrect user or password'];
            }

            // Ici, on a donc un user existant. On peut vérifier son mdp
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error'] = ['incorrect user or password'];
            }

            if ($_SESSION['error'] === []) {
                // L'utilisateur et le mdp sont corrects

                // On stocke dans cette session les infos de l'utilisateur
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'user_type' => $user['user_type'],
                ];

                // On peut rediriger l'utilisateur
                header('Location: ./profil.php');
            }
        }
    } else {
        $_SESSION['error'] = ['Please, fill-in the form correctly.'];
    }
}
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
                <?php if (isset($_SESSION['error'])) {
                    foreach ($_SESSION['error'] as $message) { ?>
                <p style='color:red'><?php echo $message; ?></p>
                <?php }
                    unset($_SESSION['error']);
                } ?>
                <form method="post" action="" id="form">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="email address" autofocus required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg"
                            id="exampleInputPassword1" placeholder="password" maxlength="13" minlength="8" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Sign in</button>
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