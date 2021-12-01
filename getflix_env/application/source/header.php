<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid">
        <a class="navbar-brand px-4" href="#">
            <img src="./img/logo_room237.svg"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item px-4 mt-4">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item px-4 mt-4">
                    <a class="nav-link" href="./profil.php">
                        My profile
                    </a>
                </li>
                <li class="nav-item px-4 mt-4">
                    <a class="nav-link" href="./create_account.php">Create account</a>
                </li>
                <li class="nav-item px-4 mt-4">
                <button class="btn btn-rounded btn-dark"><a class="nav-link" href="./register.php">Register</a></button>
                </li>
                <li class="nav-item px-4 mt-4">
                    <button class="btn btn-rounded btn-danger"><a class="nav-link" href="./deconnect.php">Deconnect</a></button>
                </li>
                <li class="nav-item px-4 mt-4">
                    <a class="nav-link" href="./admin.php">Admin</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-danger" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
    
</body>
</html>

