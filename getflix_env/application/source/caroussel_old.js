//const API_KEY = "api_key=4080ddd8f97d6721f32f9d82aba61857";
const HORROR_LATEST = "https://api.themoviedb.org/3/movie/upcoming?" + API_KEY + "&with_genres=27&language=en-US&page=1";

//https://api.themoviedb.org/3/movie/upcoming?api_key=<<api_key>>&language=en-US&page=1

showMovieData();

function sliderScrollLeft() {
    sliders.scrollTo({
        top: 0,
        left: (scrollAmount -= scrollPerClick),
        behavior: "smooth"
    });

    if (scrollAmount < 0) {
        scrollAmount = 0;
    }
}

function sliderScrollRight() {
    if(scrollAmount <= sliders.scrollWidth - sliders.clientWidth) {
        sliders.scrollTo({
            top: 0,
            left: (scrollAmount += scrollPerClick),
            behavior: "smooth"
        })
    }
}

async function showMovieData() {

    var result = await axios.get (
        HORROR_LATEST
    );

    console.log(result.data.results)
    result = result.data.results;

    result.map(function (cur, index){
        sliders.insertAdjacentHTML(
            "beforeend",
            `<img class="img-${index} slider-img" src="https://image.tmdb.org/t/p/w185/${cur.poster_path}" />`
        )
    })

    //scrollPerClick = document.querySelector(".img-1").clientWidth + imagePadding;
    scrollPerClick = 400;
    
}