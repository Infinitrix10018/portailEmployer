let currentIndex = 0;
const displayDuration = 10000; 
const opacityDuration = 250;
let slideShow = 0;
let slides = 0;
let totalSlides = 0;

let slideShowText = 0;
let texts = 0;

let isTransitioning = false; 
let autoRotationInterval; 

function initialize() {
    slideShow = document.getElementById('slideShow');
    slides = slideShow ? slideShow.children : [];
    totalSlides = slides.length;
    slides[currentIndex].style.opacity = 1;

    slideShowText = document.getElementById('slideShowText');
    texts = slideShowText ? slideShowText.children : [];
    texts[currentIndex].style.opacity = 1;

    autoRotation(); 
}

function showNextSlide() {
    if (totalSlides === 0 || isTransitioning) return; 
    isTransitioning = true; 
    toggleButtons(true); 

    slides[currentIndex].style.opacity = 0;
    texts[currentIndex].style.opacity = 0;

    setTimeout(() => {
        slides[currentIndex].style.display = 'none';
        texts[currentIndex].style.display = 'none';

        currentIndex = (currentIndex + 1 + totalSlides) % totalSlides; 
        slides[currentIndex].style.display = 'block';
        texts[currentIndex].style.display = 'block';

        setTimeout(() => {
            slides[currentIndex].style.opacity = 1;
            texts[currentIndex].style.opacity = 1;
            isTransitioning = false; 
            toggleButtons(false); 
            resetAutoRotation(); 
        }, opacityDuration);
    }, opacityDuration);
}

function showPrevSlide() {
    if (totalSlides === 0 || isTransitioning) return; 
    isTransitioning = true; 
    toggleButtons(true); 

    slides[currentIndex].style.opacity = 0;
    texts[currentIndex].style.opacity = 0;
    
    setTimeout(() => {
        slides[currentIndex].style.display = 'none'; 
        texts[currentIndex].style.display = 'none'; 

        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; 
        slides[currentIndex].style.display = 'block';
        texts[currentIndex].style.display = 'block';
        
        setTimeout(() => {
            slides[currentIndex].style.opacity = 1;
            texts[currentIndex].style.opacity = 1;
            isTransitioning = false; 
            toggleButtons(false); 
            resetAutoRotation(); 
        }, opacityDuration);
    }, opacityDuration);
}

function autoRotation() {
    if (totalSlides > 0) {
        slides[currentIndex].style.display = 'block';
        texts[currentIndex].style.display = 'block'; 
        autoRotationInterval = setInterval(showNextSlide, displayDuration); 
    }
}

function resetAutoRotation() {
    clearInterval(autoRotationInterval); 
    autoRotation();
}

function toggleButtons(disable) {
    document.getElementById('buttonLeft').disabled = disable; 
    document.getElementById('buttonRight').disabled = disable; 
}

window.onload = function() {
    initialize();
};