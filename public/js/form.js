let sub_bxs = null;
let length_bxs = null;
let current_bx = null;
let whatForm = null;
const points = [
    "/img/point.svg",        
    "/img/point_filled.svg" 
];

function initialize() {
    sub_bxs = document.getElementsByClassName("sub-bx");
    length_bxs = sub_bxs.length;
    whatForm = document.getElementById("whatForm");
    whatForm.innerHTML = ''; 

    
    current_bx = localStorage.getItem('current_bx') ? parseInt(localStorage.getItem('current_bx')) : 0;

    for (let i = 0; i < length_bxs; i++) {
        const img = document.createElement("img");
        img.src = points[0]; 
        img.id = `point${i}`; 
        img.style.width = '20px'; 
        img.style.marginRight = '5px'; 
        whatForm.appendChild(img);
        sub_bxs[i].style.display = "none"; 
    }

    sub_bxs[current_bx].style.display = "block"; 
    updatePoints();
}

function nextForm() {
    if (current_bx < length_bxs - 1) {
        sub_bxs[current_bx].style.display = "none"; 
        current_bx++;
        sub_bxs[current_bx].style.display = "block"; 
        updatePoints(); 
        localStorage.setItem('current_bx', current_bx); 
    }
}

function prevForm() {
    if (current_bx > 0) {
        sub_bxs[current_bx].style.display = "none"; 
        current_bx--;
        sub_bxs[current_bx].style.display = "block"; 
        updatePoints(); 
        localStorage.setItem('current_bx', current_bx); 
    }
}

function updatePoints() {
    for (let i = 0; i < length_bxs; i++) {
        const img = document.getElementById(`point${i}`);
        img.src = i === current_bx ? points[1] : points[0]; 
    }
}

window.onload = function() {
    initialize();
};