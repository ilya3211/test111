/**
 * Hamburger menu toggle for mobile navigation
 */
document.addEventListener('DOMContentLoaded', function() {
    // Hamburger menu toggle
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.nav-menu.mobile');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });
    }

    // Submenu toggle on mobile (click on parent item)
    const mobileParents = document.querySelectorAll('.nav-menu.mobile .menu-item-has-children');
    mobileParents.forEach(parent => {
        parent.addEventListener('click', function(e) {
            // Don't toggle if clicking directly on the link
            if (e.target.tagName === 'A' && e.target.parentElement === this) {
                // Allow navigation to parent category
                return;
            }
            // Toggle submenu
            e.preventDefault();
            this.classList.toggle('active');
        });
    });
});
