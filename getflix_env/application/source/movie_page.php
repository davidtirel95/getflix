<?php

// Ici ira le php 

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
    <title>Movie page details</title>
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

    <!-- Voici le MENU -->
    <div class="container">
        <div class="row" id="movie_details">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mx-auto justify-content-center mt-5 mb-3">
                <img src="https://image.tmdb.org/t/p/w300/5iGVofFc0mCr8aJYsVICm42ThIu.jpg" alt="movie_title" class="w-100 mb-4">
                <p><strong class="fs-6 fw-bold text-danger mt-4 mb-4">Trailer:</strong></p>
                <div>
                    <iframe width="560" height="315" class="w-100 h-100" id="video1" src="https://www.youtube.com/embed/AujRGaPAP7Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </iframe>
                </div>




            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center mt-5 mb-3">
                <h2 id="title" class="text-start">Last Night in Soho

                </h2>
                <div class="synopsis mt-4 mb-4 pt-4 pb-4 border-top border-danger">
                    <h4>Synopsis</h4>
                    <p>A young girl, passionate about fashion design, is mysteriously able to enter the 1960s where she encounters her idol, a dazzling wannabe singer. But 1960s London is not what it seems, and time seems to be falling apart with shady consequences.</p>
                </div>
                <div class="genres_badges d-flex flex-row align-items-start">
                    <p class="fs-6 fw-bold text-danger">Genres: </p>
                    <span class="mx-2 badge bg-light text-dark">Horror</span>
                </div>
                <p><strong class="fs-6 fw-bold text-danger">Language:</strong> EN</p>
                <p><strong class="fs-6 fw-bold text-danger">Year:</strong> 2021</p>
                <p><strong class="fs-6 fw-bold text-danger">Vote average:</strong> 6.4</p>
                <p><strong class="fs-6 fw-bold text-danger">Cast:</strong> Lorem acteurs</p>
                <p><strong class="fs-6 fw-bold text-danger">Director:</strong> Lorem directeurs</p>
                <p><strong class="fs-6 fw-bold text-danger">Duration:</strong> 2h07</p>

            </div>
        </div>
    </div>



    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!--  Mes js -->
</body>

</html>