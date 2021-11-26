<?php
// Placer la partie logique autant que possible séparée de l'html
$name = "";
$age = "";
$artist = "";
$life = "";

// la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "La connexion a été bien établie.";
} catch (PDOException $e) {
    //echo "La connexion a échoué: " . $e->getMessage();
}

if (isset($_POST["submit"])) {
    $name = htmlentities($_POST['name']);
    $age = intval($_POST['age']);
    $artist = htmlentities($_POST['artist']);
    $life = htmlentities($_POST['life']);

    $sql = ("INSERT INTO `profile`(`name`, `age`, `artist`, `life`) VALUES (:name, :age, :artist, :life)");
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':artist', $artist);
    $stmt->bindParam(':life', $life);
    $stmt->execute();


    // header('Location: http://localhost/PHP_learning/form.php');
    // exit();
}

// essayer de prendre les infos de la db est les placer sur l'html
$req = $conn->prepare("SELECT * FROM profile");
$req->execute();
$rows = $req->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lou Reed form</title>
</head>

<body>
    <h3>Please, fill-in the form</h3>
    <form method="post" action="">
        <!-- NAME -->
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="" maxlength="40"><br>
        <!-- AGE -->
        <label for="age">Age</label><br>
        <input type="number" name="age" min="0" max="150" value=""><br>
        <!-- CHOOSE BETWEEN 2 ARTISTS -->
        <label for="artist">Who do you prefer?</label><br>
        <div>
            <input type="radio" id="basquiat" name="artist" value="basquiat" checked>
            <label for="basquiat">Basquiat</label>
        </div>

        <div>
            <input type="radio" id="warhol" name="artist" value="warhol">
            <label for="warhol">Andy Warhol</label>
        </div>

        <!-- CHOOSE BETWEEN 2 ARTISTS -->
        <label for="life">Tell me about your life:</label><br>
        <textarea name="life" rows="20" cols="30" maxlength="3000" value=""></textarea><br>

        <input type="submit" name="submit" value="Send the data">
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>age</th>
            <th>artist</th>
            <th>life</th>
        </tr>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['age']; ?></td>
                <td><?= $row['artist']; ?></td>
                <td><?= $row['life']; ?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>