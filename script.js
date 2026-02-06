let menuIcon = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist');

if (menuIcon && navlist) {
    menuIcon.onclick = () => {
        menuIcon.classList.toggle('bx-x');
        navlist.classList.toggle('open');
    };

    window.onscroll = () => {
        menuIcon.classList.remove('bx-x');
        navlist.classList.remove('open');
    };
}

// Initialize MixItUp for the Portfolio Section
var containerEl = document.querySelector('.portfolio-gallery');

// Check if container exists AND if mixitup library is loaded to prevent errors
if (containerEl && typeof mixitup === 'function') {
    var mixer = mixitup(containerEl, {
        selectors: {
            target: '.port-box'
        },
        animation: {
            duration: 500
        }
    });
}

// Circle Skill Animation
const circles = document.querySelectorAll('.circle');
circles.forEach(elem => {
    var dots = parseInt(elem.getAttribute("data-dots"));
    var marked = parseInt(elem.getAttribute("data-percent"));
    var percent = Math.floor(dots * marked / 100);
    var points = "";
    var rotate = 360 / dots;

    for(let i = 0; i < dots; i++){
        // Add 'marked' class directly during creation
        let className = (i < percent) ? "point marked" : "point";
        points += `<div class="${className}" style="--i:${i}; --rot:${rotate}deg"></div>`;
    }
    elem.innerHTML = points;
});

// Text Animation (Rotating Words)
let words = document.querySelectorAll(".word");
words.forEach((word)=>{
    let letters = word.textContent.split("");
    word.textContent="";
    letters.forEach((letter)=>{
        let span = document.createElement("span");
        span.textContent = letter;
        span.className = "letter";
        word.append(span);
    });
});

let currentWordIndex = 0;
let maxWordIndex = words.length - 1;
if (words.length > 0) {
    words[currentWordIndex].style.opacity = "1";
}

let changeText = ()=>{
    let currentWord = words[currentWordIndex];
    let nextWord = currentWordIndex === maxWordIndex ? words[0] : words[currentWordIndex + 1];

    Array.from(currentWord.children).forEach((letter,i)=>{
        setTimeout(()=>{
            letter.className = "letter out";
        },i * 80);
    });
    nextWord.style.opacity="1";
    Array.from(nextWord.children).forEach((letter,i)=>{
        letter.className = "letter behind";
        setTimeout(()=>{
            letter.className = "letter in";
        },340 + i * 80);
    });
    currentWordIndex = currentWordIndex === maxWordIndex ? 0 : currentWordIndex + 1;
};

if (words.length > 0) {
    setInterval(changeText, 3000);
}