<?php
const API_KEY = "api_key=4080ddd8f97d6721f32f9d82aba61857";
const BASE_URL = "https://api.themoviedb.org/3";

require 'vendor/autoload.php';

use VfacTmdb\Factory;
use VfacTmdb\Search;
use VfacTmdb\Item;

// Initialize Wrapper
$tmdb = Factory::create()->getTmdb('api_key=4080ddd8f97d6721f32f9d82aba61857');

// Search a movie
$search    = new Search($tmdb);
$responses = $search->movie('star wars');

// Get all results
foreach ($responses as $response)
{
    echo $response->getTitle();
}

// Get movie information
$item  = new Item($tmdb);
$infos = $item->getMovie(11, array('language' => 'fr-FR'));

echo $infos->getTitle();
?>