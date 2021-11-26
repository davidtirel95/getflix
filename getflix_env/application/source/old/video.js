const video1 = document.getElementById('video1');

const VIDEO = "http://api.themoviedb.org/3/movie/157336/videos?api_key=4080ddd8f97d6721f32f9d82aba61857";


var youtube_link = "https://www.youtube.com/embed/";
var video_specific_link;


showVideo();

async function showVideo() {

    var result = await axios.get (
        VIDEO
    );

    video_specific_link = youtube_link + (result.data.results[7]["key"]);
    console.log(video_specific_link)
    video1.src = video_specific_link;

}






