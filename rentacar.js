const slides = document.querySelectorAll(".slide");

let maxSlide = slides.length - 1;
let curSlide = 0;

slides.forEach((slide, indx) => {
  slide.style.transform = `translateX(${indx * 100}%)`;
});

let nextSlide = document.querySelector("#btn-next");

nextSlide.addEventListener("click", function () {
  if (curSlide < maxSlide) {
    curSlide++;
  } else {
    curSlide = 0;
  }

  slides.forEach((slide, indx) => {
    slide.style.transform = `translateX(${(indx - curSlide) * 100}%)`;
  });
});

const prevSlide = document.querySelector("#btn-prev");

prevSlide.addEventListener("click", function () {
  if (curSlide > 0) {
    curSlide--;
  } else {
    curSlide = maxSlide;
  }

  slides.forEach((slide, indx) => {
    slide.style.transform = `translateX(${(indx - curSlide) * 100}%)`;
  });
});

let contacten = []
contacten.push({
    "naam": "Duurzame landbouw",
    "telefoon": "Bangladesh"
})
contacten.push({
    "naam": "Red de regenwouden",
    "telefoon": "Benin Republiek"
})
contacten.push({
    "naam": "Red de regenwouden",
    "telefoon": "Mali"
})
contacten.push({
    "naam": "Voedselbossen",
    "telefoon": "Colombia"
})
contacten.push({
    "naam": "Voedselbossen",
    "telefoon": "Mali"
})

function zoekContacten(zoektekst) {
    zoektekst = zoektekst.toUpperCase();
    let myGrid = 
    "<div class='cell'><b>Project</b></div><div class='cell'><b>Land</b></div>";

    for (x = 0; x < contacten.length; x++) {
        if (
            contacten[x].naam.toUpperCase().includes(zoektekst) ||
            contacten[x].telefoon.toUpperCase().includes(zoektekst)
        ){
            myGrid += '<div class="cell">' + contacten[x].naam + '</div>';
            myGrid += '<div class="cell">' + contacten[x].telefoon + '</div>'; 
        }
    }

    document.getElementById('grid').innerHTML = myGrid
}