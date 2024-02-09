export function slider() {
    const images = document.querySelectorAll(".slider-img");
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((image, i) => {
            if (i === index) {
                image.classList.remove("opacity-0");
                image.classList.add("opacity-100");
            } else {
                image.classList.remove("opacity-100");
                image.classList.add("opacity-0");
            }
        });
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    setInterval(nextImage, 5000);
}
