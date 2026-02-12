<?php
$images = array_values(
    glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE)
);

$captions = file_exists("captions.json") 
    ? json_decode(file_get_contents("captions.json"), true) 
    : [];
?>
<!DOCTYPE html>
<html>
<head>
<style>
body { 
    font-family: Arial, sans-serif; 
    background: linear-gradient(135deg, #ffb6d9, #ffd6ec, #ffe6f5);
    margin:0;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    align-items:center;
    overflow-x:hidden;
}

/* TITLE */
h2 {
    margin-top:40px;
    padding:18px 60px;
    border-radius:30px;
    font-size:28px;
    color:#fff;

    background:rgba(65, 52, 52, 0.25);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
}

/* MAIN ROW */
.slider-wrapper {
    margin-top:80px;
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
}   

/* WHITE CARD */
.slider-card{
    background:white;
    padding:25px;
    border-radius:25px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);

    display:grid;
    grid-template-columns: auto 900px auto; /* left preview | center box | right preview */
    align-items:center;
    justify-items:center;  /* <-- THIS CENTERS THE BOX */
    gap:25px;
}

/* MAIN IMAGE CONTAINER */
/* PANORAMA VIEWPORT (THIS IS WHAT YOU WANT) */
.slider-container {
    width: 900px;
    height: 350px;
    overflow: hidden;
    text-align:center;
    border-radius: 20px;
    margin: 0 auto;   /* <-- centers the box inside its grid column */
}

/* IMAGE STRIP */
.slider {
    display: flex;
    transition: transform 0.6s ease-in-out;
}

/* ONE IMAGE PER VIEW — true panorama window */
.slider img {
    width: 900px;      /* MUST match WIDTH in JS */
    height: 350px;     /* matches container height */
    object-fit: cover; /* crops nicely like a real panorama */
    border-radius:15px;
    flex-shrink: 0;
}

/* SIDE PREVIEWS */
.preview-left, .preview-right{
    width:140px;
    opacity:.35;
    filter:blur(1px);
    border-radius:12px;
    border:2px solid #ddd;
}

/* ARROWS */
.arrow {
    font-size: 55px;
    cursor: pointer;
    padding: 20px;
    color:#1e88e5;
    transition:.2s;
}
.arrow:hover{
    transform:scale(1.2);
}

/* CAPTION */
.caption {
    margin-top: 12px;
    font-size: 20px;
    font-weight: bold;
    color:#1e88e5;
    text-align:center;
}

/* LINKS */
.links a{
    text-decoration:none;
    color:#7c4dff;
    font-weight:bold;
    margin:0 10px;
}
.carousel{
    position:relative;
    width:900px;
    height:380px;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ARROWS */
.arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:55px;
    cursor:pointer;
    color:#1e88e5;
    z-index:5;
    user-select:none;
}

.left-arrow{
    left:-80px;
}

.right-arrow{
    right:-80px;
}

.arrow:hover{
    transform:translateY(-50%) scale(1.2);
}

/* CENTER IMAGE */
.main-frame{
    width:900px;
    height:350px;
    border-radius:30px;
    overflow:hidden;
    z-index:2;
    text-align:center;

    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(15px);
    box-shadow:0 15px 40px rgba(0,0,0,.2);
}

.main-frame img{
    width:100%;
    height:100%;
    object-fit:contain;   /* THIS FIXES IT */
    background:#fff;      /* white background if image has space */
}

/* SIDE IMAGES */
.side{
    position:absolute;
    width:600px;
    height:300px;
    object-fit:contain;   /* changed */
    background:#fff;
    border-radius:25px;
    opacity:.45;
    filter:blur(2px);
    transition:.4s ease;
    z-index:1;
}

.left{
    left:-250px;
}

.right{
    right:-250px;
}

/* Caption */
.caption{
    margin-top:10px;
    font-size:20px;
    font-weight:bold;
    color:#1e88e5;
}
.subtitle{
    margin-top:15px;
    font-size:18px;
    color:#ffffff;
    background:rgba(65, 52, 52, 0.25);
    padding:10px 25px;
    border-radius:20px;
    backdrop-filter: blur(6px);
}
.hearts{
    position:fixed;
    width:100%;
    height:100%;
    pointer-events:none;
    overflow:hidden;
    top:0;
    left:0;
    z-index:0;
}

.heart{
    position:absolute;
    color:#ff4da6;
    font-size:20px;
    animation: floatUp 8s linear infinite;
    opacity:0.7;
}

@keyframes floatUp{
    from{
        transform:translateY(100vh) scale(1);
        opacity:0.8;
    }
    to{
        transform:translateY(-10vh) scale(1.5);
        opacity:0;
    }
}
.fade{
    opacity:0;
    transition: opacity .5s ease-in-out;
}
@media (max-width: 768px){

    h2{
        font-size:22px;
        padding:15px 30px;
    }

    .carousel{
        width:95%;
        height:auto;
    }

    .main-frame{
        width:100%;
        height:250px;
    }

    .main-frame img{
        height:100%;
        object-fit:contain;
    }

    .side{
        display:none; /* hide side previews on mobile */
    }

    .left-arrow{
        left:10px;
    }

    .right-arrow{
        right:10px;
    }

    .arrow{
        font-size:40px;
    }

    .slider-wrapper{
        margin-top:80px;
    }

}


</style>
</head>
<body>

<h2>💕Lovely Gallery</h2>
<p class="subtitle">
    A collection of memories 💕
</p>


<div class="slider-wrapper">

    <div class="carousel">

        <div class="arrow left-arrow" onclick="prevImage()">❮</div>

        <img id="prevPreview" class="side left">

        <div class="main-frame">
            <img id="mainImage">
            <div class="caption" id="caption"></div>
        </div>

        <img id="nextPreview" class="side right">

        <div class="arrow right-arrow" onclick="nextImage()">❯</div>

    </div>

</div>

<p class="links">
</p>

<script>
let images = <?= json_encode($images) ?>;
let captions = <?= json_encode($captions) ?>;
let current = 0;

const mainImage = document.getElementById("mainImage");
const captionBox = document.getElementById("caption");
const prevPreview = document.getElementById("prevPreview");
const nextPreview = document.getElementById("nextPreview");

function updateSlider() {

    if (images.length === 0) {
        mainImage.src = "";
        captionBox.innerText = "No images uploaded";
        return;
    }

    mainImage.classList.add("fade");

    setTimeout(() => {
        mainImage.src = images[current];

        let imgName = images[current];
        captionBox.innerText = captions[imgName] || "No caption";

        let prevIndex = (current - 1 + images.length) % images.length;
        let nextIndex = (current + 1) % images.length;

        prevPreview.src = images[prevIndex];
        nextPreview.src = images[nextIndex];

        mainImage.classList.remove("fade");
    }, 250);
}

function nextImage() {
    if (images.length === 0) return;
    current = (current + 1) % images.length;
    updateSlider();
}

function prevImage() {
    if (images.length === 0) return;
    current = (current - 1 + images.length) % images.length;
    updateSlider();
}

updateSlider();
function createHeart(){
    const heart = document.createElement("div");
    heart.classList.add("heart");
    heart.innerHTML = "💗";
    heart.style.left = Math.random() * 100 + "vw";
    heart.style.fontSize = (15 + Math.random()*25) + "px";
    heart.style.animationDuration = (6 + Math.random()*5) + "s";
    document.querySelector(".hearts").appendChild(heart);

    setTimeout(() => {
        heart.remove();
    }, 10000);
}

setInterval(createHeart, 800);

</script>
<div class="hearts"></div>
</body>
</html>
