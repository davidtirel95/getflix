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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Create new account</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container" id="logo_et_titre">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <h1 class="text-center">Bienvenu sur Getflix</h1>
                <div class="text-center">Getflix</div>
            </div>
        </div>
        <!-- S'inscrire -->
        <div class="container" id="create_account">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mx-auto justify-content-center">
                    <!-- S'inscrire // form -->
                    <form>
                        <div class="mb-3">
                            <input type="text" name="first_name" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="first name" maxlength="30" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="last_name" class="form-control form-control-lg" id="exampleInputEmail1" maxlength="30" placeholder="last name">
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email address">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="password">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password2" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="repeat password">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-outline-light">Create account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
        <!--  Popper and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>