<?php

$curl = curl_init('https://api.themoviedb.org/3/discover/movie?api_key=4080ddd8f97d6721f32f9d82aba61857&with_genres=27');
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
    <title>Movies</title>
</head>

<body>

    <main>
        <?php foreach ($posters as $poster) { ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= "https://image.tmdb.org/t/p/w92/" . $poster['poster_path'] ?>" class="card-img-top" alt="<?= $poster['title'] ?>">.
            </div> <?php } ?>

    </main>

</body>

</html>