export function slider() {
    const images = document.querySelectorAll(".slider-img");
    let currentIndex = 0;
  
    function showImage(index) {
      images.forEach((image, i) => {
        if (i === index) {
          image.classList.add("active");
        } else {
          image.classList.remove("active");
        }
      });
    }
  
    function nextImage() {
      currentIndex = (currentIndex + 1) % images.length;
      showImage(currentIndex);
    }
  
    setInterval(nextImage, 5000);
}
