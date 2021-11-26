//const API_KEY = "api_key=4080ddd8f97d6721f32f9d82aba61857";
const HORROR = "https://api.themoviedb.org/3/discover/movie?" + API_KEY + "&with_genres=27";

tous_films();


async function tous_films() {

    var result = await axios.get (
        HORROR
    );

    result = result.data.results;

    result.map(function (cur, index){
        films_container.insertAdjacentHTML(
            "beforeend",
            `<img class="img-${index} img_movie" src="https://image.tmdb.org/t/p/w92/${cur.poster_path}" />`
        )
    })

    
}






