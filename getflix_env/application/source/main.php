<!DOCTYPE html>
<html lang="en">

<?php include_once './head.php'; ?>

<body class="bg-dark text-white">

    <!-- Banniere d'acceuil -->
    <div class="container_banner" id="container_banner">
        <?php include_once './header.php'; ?>
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
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
        <div id="films_filters" class="d-flex flex-row justify-content-center mb-3 mT-1 text-center">
            <form action="" method="get">
                <button id="all" name="all" value="all" type="submit"
                    class="btn btn-outline-danger btn-sm m-1 rounded-pill">All</button>
            </form>
            <form action="" method="get">
                <button id="documentary" name="documentary" value="documentary" type="submit"
                    class="btn btn-outline-danger btn-sm m-1 rounded-pill">Documentary</button>
            </form>
            <form action="" method="get">
                <button id="thriller" name="thriller" value="thriller" type="submit"
                    class="btn btn-outline-danger btn-sm m-1 rounded-pill">Thriller</button>
            </form>
            <form action="" method="get">
                <button id="classics" name="classics" value="classics" type="submit"
                    class="btn btn-outline-danger btn-sm m-1 rounded-pill">Classics</button>
            </form>
        </div>

        <!-- Les visuels des films -->
        <?php
        if (
            !isset($_GET['all']) and
            !isset($_GET['documentary']) and
            !isset($_GET['thriller']) and
            !isset($_GET['classics'])
        ) {
            include './horror_all.php';
        }

        if (isset($_GET['all'])) {
            include './horror_all.php';
        }
        if (isset($_GET['documentary'])) {
            include './documentary.php';
        }
        if (isset($_GET['thriller'])) {
            include './thriller.php';
        }
        if (isset($_GET['classics'])) {
            include './old_movies.php';
        }
        ?>




    </div>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <!-- cdn js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.js"
        integrity="sha512-RT3IJsuoHZ2waemM8ccCUlPNdUuOn8dJCH46N3H2uZoY7swMn1Yn7s56SsE2UBMpjpndeZ91hm87TP1oU6ANjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--  Mes js -->
    <script src="./const_API.js"></script>
    <script src="./caroussel_last.js"></script>

</body>

</html>