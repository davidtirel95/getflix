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
                <h5 class="text-center">Admin room</h5>
            </div>
        </div>
    </div>

    <!-- Form new account -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <?php
                include_once './connect.php';

                $qry = 'SELECT * FROM `register`'; // Your query
                $result = $conn->query($qry); // execute query

                $user = $result->fetch();

                echo '<table>
                <tr>
                <th>supprimer</th>
                <th>modifier</th>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>email</th>
                <th>type</th>
                </tr>';
                while ($row = $result->fetch()) {
                    echo '<tr>';
                    echo '<td>' .
                        "<a href='./admin_function/delete_user.php?id=" .
                        $row['id'] .
                        "'>supprimer</a>" .
                        '</td>';
                    echo '<td>' .
                        "<a href='./admin_function/modify_user.php?id=" .
                        $row['id'] .
                        "'>modifier</a>" .
                        '</td>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['first_name'] . '</td>';
                    echo '<td>' . $row['last_name'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['user_type'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                ?>




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
    <script src="./create_account.js"></script>
</body>

</html>