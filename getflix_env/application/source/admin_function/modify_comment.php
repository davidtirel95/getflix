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
    include_once '../connect.php';
    $req = $conn->query('SELECT * FROM comments WHERE user_id=' . $_GET['id']);
    $req->execute();
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
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- Flèches typo -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <div class="text-center" id="logo_container">
                    <img src="../img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">Admin room</h5>
            </div>
        </div>
    </div>
    <!-- nav admin -->
    <ul>
        <li><a href="../admin.php">admin pannel</a></li>
    </ul>
    <!-- Form new account -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <br>
                <?php
                echo '<table>
                 <tr>
                 <th>supprimer</th>
                 <th>modifier</th>
                 <th>comment</th>
                 <th>date</th>
                 </tr>';
                while ($row = $req->fetch()) {
                    echo '<tr>';
                    echo '<td>' .
                        "<a href='../admin_function/delete_comment.php?id=" .
                        $row['id'] .
                        "'>supprimer</a>" .
                        '</td>';
                    echo '<td>' .
                        "<a href='../admin_function/edit_comment.php?id=" .
                        $row['id'] .
                        "'>modifier</a>" .
                        '</td>';
                    echo '<td>' . $row['comment'] . '</td>';
                    echo '<td>' . $row['date_time'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                ?>



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
    <script src="./create_account.js"></script>
</body>

</html>