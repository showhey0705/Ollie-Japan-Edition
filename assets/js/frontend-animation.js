document.addEventListener('DOMContentLoaded', function() {
    // Observe animation elements
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-animated');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0,
        rootMargin: '-5% -5%'
    });

    // Observe elements with data-motion attribute
    document.querySelectorAll('[data-motion]').forEach(element => {
        observer.observe(element);
    });

    // Debugging
    console.log('Animation elements initialized:', document.querySelectorAll('[data-motion]').length);
}); 