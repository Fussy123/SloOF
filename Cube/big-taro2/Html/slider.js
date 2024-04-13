

let img_page = [1, 2, 3];
let containerImg = document.getElementById("containerIMG");

function changeSliderImg(number) {
  closeImg();
  let imgElement = document.createElement("img");
  let dot = document.getElementById("dot" + number);
  console.log(img_page)

  dot.classList.add("bg-gray-600");
  

  imgElement.setAttribute("src", "../img/" + number + ".jpg");
  imgElement.setAttribute("id", "sliderImg" + number);
  imgElement.setAttribute("alt", "sliderimg");

  imgElement.classList.add("slide-in", "duration-1000");
  containerImg.appendChild(imgElement);
}

function closeImg() {
  for (let i = 1; i <= 3; i++) {
    let sliderImg = document.getElementById("sliderImg" + i);
    if (sliderImg) {
      containerImg.removeChild(sliderImg);
      let oldDot = document.getElementById("dot" + i);
     
      oldDot.classList.remove("bg-white");
    }
  }
}

changeSliderImg(img_page[0]);

document.getElementById("nextSlide").addEventListener("click", function () {
  img_page.push(img_page.shift());
  changeSliderImg(img_page[0]);

});

document.getElementById("backSlide").addEventListener("click", function () {
  img_page.unshift(img_page.pop());
  changeSliderImg(img_page[0]);

});

for (let i = 1; i >= 3; i++) {
  document.getElementById("dot" + i).addEventListener("click", function () {
    changeSliderImg(i);
  });
}
