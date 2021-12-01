<?php
$key = "api_key=4080ddd8f97d6721f32f9d82aba61857";
$genres = "&with_genres=27";

$curl = curl_init("https://api.themoviedb.org/3/discover/movie?" . $key . $genres);
// ici il s'agit de donner le certificat mais ça ne marche pas!!
//curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
// du coup, déconseillé:
curl_setopt_array($curl, [
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 1
]);
$data = curl_exec($curl);
if ($data === false) {
    var_dump(curl_error($curl));
} else {
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
        $data = json_decode($data, true);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
    } else {
        echo "Erreur";
    }
}
curl_close($curl);

$posters = $data["results"];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- My styles -->
    <link rel="stylesheet" href="./assets/css/caroussel.css">
    <title>Main page Room 237</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <!-- Flèches typo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    <!-- Banniere d'acceuil -->
    <div class="container_banner" id="container_banner">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto justify-content-center">
                <!-- The main banner goes here (3 img => one welcoming + 2 star movies) -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="./img/banners resized/shin.jpg" class="d-block w-100" alt="Welcome banner">
                        </div>
                        <div class="carousel-item">
                            <img src="./img/banners resized/or_mec.jpg" class="d-block w-100" alt="Banner latest">
                        </div>
                        <div class="carousel-item">
                            <img src="./img/banners resized/sil_ag.jpg" class="d-block w-100" alt="Banner latest">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Caroussel -->
    <p id="caroussel_title" class="text-start text-uppercase fs-4">Latest horror movies</p>
    <div class="caroussel">
        <div class="carousselbox">
            <!-- Random data will come here -->
        </div>

        <a href="#" class="switchLeft sliderButton" onclick="sliderScrollLeft()">
            <p>&lt;</p>
        </a>
        <a href="#" class="switchRight sliderButton" onclick="sliderScrollRight()">
            <p>&gt;</p>
        </a>
    </div>

    <!-- Tous les films -->
    <div id="films" class="justify-content-center">
        <!-- Les filtres possibles -->
        <div id="films_filters" class="justify-content-center mb-3 mT-1 text-center">
            <form action="" method="GET">
                <button id="documentary" type="submit" class="btn btn-outline-danger btn-sm mt-1 mb-1 rounded-pill" data-bs-toggle="button">Documentary</button>
            </form>
        </div>
        <!-- Les visuels des films -->
        <div class="container_banner" id="container_banner">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto justify-content-center" id="films_container_container">
                    <div id="films_container">
                        <!-- On injecte ici tous les films (img) -->
                        <?php foreach ($posters as $poster) { ?>
                            <form action="" method="GET" class="form_movie" name="movie" value="<?= $poster['id'] ?>">
                                <a class="lien" style="max-width: 185px;" href="./movie_page.php?id=<?= $poster['id'] ?>">
                                    <img style="max-width: 154px;" id=" <?= $poster['id'] ?>" src="<?= "https://image.tmdb.org/t/p/w154/" . $poster['poster_path'] ?>" class="img_poster" alt="<?= $poster['title'] ?>">
                                </a>
                            </form> <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- cdn js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.js" integrity="sha512-RT3IJsuoHZ2waemM8ccCUlPNdUuOn8dJCH46N3H2uZoY7swMn1Yn7s56SsE2UBMpjpndeZ91hm87TP1oU6ANjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--  Mes js -->
    <script src="./const_API.js"></script>
    <script src="./caroussel.js"></script>
    <!-- <script src="./tous_les_films.js"></script> -->
</body>

</html>