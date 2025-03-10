document.addEventListener('DOMContentLoaded', () => {
    const carouselWrap = document.querySelector('.horizontal-scroll');
    const prevButton = document.querySelector('.carousel-button.prev');
    const nextButton = document.querySelector('.carousel-button.next');
    
    if (!carouselWrap || !prevButton || !nextButton) {
        console.warn('カルーセルの必要な要素が見つかりませんでした。');
        return;
    }
    
    function updateButtonVisibility() {
        const isAtStart = carouselWrap.scrollLeft <= 10;
        const isAtEnd = carouselWrap.scrollLeft >= (carouselWrap.scrollWidth - carouselWrap.offsetWidth - 10);

        prevButton.style.display = isAtStart ? 'none' : 'flex';
        nextButton.style.display = isAtEnd ? 'none' : 'flex';
    }

    nextButton.addEventListener('click', () => {
        carouselWrap.scrollTo({
            left: carouselWrap.scrollLeft + carouselWrap.offsetWidth,
            behavior: 'smooth'
        });
    });

    prevButton.addEventListener('click', () => {
        carouselWrap.scrollTo({
            left: carouselWrap.scrollLeft - carouselWrap.offsetWidth,
            behavior: 'smooth'
        });
    });

    carouselWrap.addEventListener('scroll', updateButtonVisibility);
    
    if ('onscrollend' in window) {
        carouselWrap.addEventListener('scrollend', updateButtonVisibility);
    }

    prevButton.style.display = 'none';
    nextButton.style.display = 'flex';
});
