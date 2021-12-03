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
    $commentId = $_GET['id'];
    $req = $conn->query('SELECT * FROM comments WHERE id=' . $commentId);
    $tableComment = $req->fetch();
    if ($tableComment) {
        $comment = $tableComment['comment'];
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

// corriger le textarea

if (!empty($_POST)) {
    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        // clean les variables
        $newComment = test_input($_POST['comment']);
        require_once '../connect.php';

        // ajouter tout dans la db
        $con = 'update comments set comment=:comment
                 where id=:id';
        $chnginfo = $conn->prepare($con);
        $chnginfo->bindParam(':id', $commentId, PDO::PARAM_STR);
        $chnginfo->bindParam(':comment', $newComment, PDO::PARAM_STR);
        $chnginfo->execute();
        // redirection vers admin room
        header(
            'Location: ../admin_function/modify_comment.php?id=' .
                $_SESSION['user']['id']
        );
    }
    header('refresh:1;url=../admin.php');
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

    <!-- My styles -->
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/caroussel.css">
    <link rel="stylesheet" href="./assets/css/movie_page.css">
    <title>Movie page details</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/8e9298d105.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <!-- Flèches typo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <!-- Voici le MENU -->

    <div class="container">
        <!-- nav admin -->
        <ul>
            <li><a href="../admin.php">admin pannel</a></li>
        </ul>
        <form method="post" action="" id="form">
            <?php echo $error; ?>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label" name="comment">leave a comment :</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="comment"
                    rows="3"><?php echo $comment; ?></textarea>
                <br>
                <button name="submit" type="submit" class="btn btn-outline-light" name="submit_comment">send</button>
            </div>
        </form>
        <div>



        </div>
    </div>
    <?php include_once '../footer.php'; ?>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <!--  Mes js -->
    <!-- <script src="./tous_les_films.js"></script> -->
</body>

</html>