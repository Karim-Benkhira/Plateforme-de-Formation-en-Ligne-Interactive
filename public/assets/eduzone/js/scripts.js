// EduZone Theme Scripts
document.addEventListener('DOMContentLoaded', function() {
    // Sticky Header
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    }

    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }

    // Smooth Scroll for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (navLinks && navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    if (menuToggle) menuToggle.classList.remove('active');
                }
            }
        });
    });

    // Animation on Scroll
    const animateElements = document.querySelectorAll('.animate');
    
    if (animateElements.length > 0) {
        const checkIfInView = () => {
            animateElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        };
        
        window.addEventListener('scroll', checkIfInView);
        checkIfInView(); // Check on initial load
    }

    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    
    if (counters.length > 0) {
        const counterAnimation = () => {
            counters.forEach(counter => {
                const elementTop = counter.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible && !counter.classList.contains('counted')) {
                    counter.classList.add('counted');
                    
                    const target = parseInt(counter.getAttribute('data-count'));
                    let count = 0;
                    const speed = 2000 / target;
                    
                    const updateCount = () => {
                        if (count < target) {
                            count++;
                            counter.textContent = count;
                            setTimeout(updateCount, speed);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    
                    updateCount();
                }
            });
        };
        
        window.addEventListener('scroll', counterAnimation);
        counterAnimation(); // Check on initial load
    }
});
