const API_KEY = "api_key=4080ddd8f97d6721f32f9d82aba61857";
const BASE_URL = "https://api.themoviedb.org/3";
const MOST_POPULAR = "/discover/movie?sort_by=popularity.desc";
const HORROR = "https://api.themoviedb.org/3/discover/movie?" + API_KEY + "&with_genres=27";
const API_URL = BASE_URL + MOST_POPULAR + "&" + API_KEY;
const IMG_URL = "https://image.tmdb.org/t/p/w200/";
const the_main = document.getElementById("main");
const GENRES = "https://api.themoviedb.org/3/genre/movie/list?"+API_KEY+"&language=en-US";

//getMovies(API_URL);
getMovies(GENRES);
getMovies(HORROR);

function getMovies(url) {
    fetch(url).then(res => res.json()).then(data => {
        console.log(data);
        //showMovies(data.results);
    });
}

function showMovies(data) {
    the_main.innerHTML = "";

    data.forEach(movie => { 
        const {title, poster_path, vote_average, overview} = movie;
        const movieEl = document.createElement("div");
        movieEl.classList.add("movie");
        movieEl.innerHTML = `
            <img src="${IMG_URL + poster_path}" alt="${title}">
            <div>
                <h2>${title}</h2>
                <span>${vote_average}</span>
            </div>
            <div>
                <h3>Overview</h3>
                <p>${overview}</p>
            </div>
            `
        the_main.appendChild(movieEl);
    })
    
}