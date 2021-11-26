const sliders2 = document.getElementById("caroussel-2");
var scrollPerClick2;

var scrollAmount2 = 0;

showMovieData2();

function sliderScrollLeft2() {
    sliders2.scrollTo({
        top: 0,
        left: (scrollAmount2 -= scrollPerClick2),
        behavior: "smooth"
    });

    if (scrollAmount2 < 0) {
        scrollAmount2 = 0;
    }
}

function sliderScrollRight2() {
    if(scrollAmount2 <= sliders2.scrollWidth - sliders2.clientWidth) {
        sliders2.scrollTo({
            top: 0,
            left: (scrollAmount2 += scrollPerClick2),
            behavior: "smooth"
        })
    }
}

async function showMovieData2() {

    var result = await axios.get (
        HORROR_DOCUMENTARY
    );

    console.log(result.data.results)
    result = result.data.results;

    result.map(function (cur, index){
        sliders2.insertAdjacentHTML(
            "beforeend",
            `<img class="img-${index} slider-img" src="https://image.tmdb.org/t/p/w185/${cur.poster_path}" />`
        )
    })

    //scrollPerClick = document.querySelector(".img-1").clientWidth + imagePadding;
    scrollPerClick2 = 400;
    
}