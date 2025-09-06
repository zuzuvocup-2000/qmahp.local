/**
 * Custom JavaScript for Charity Website
 * Author: AI Assistant
 * Description: Contains all custom JavaScript functionality for the charity website
 */

(function() {
    'use strict';

    /**
     * Back to Top Button Functionality
     * Shows/hides back to top button based on scroll position
     * Provides smooth scroll to top functionality
     */
    function initBackToTop() {
        const backToTopBtn = document.getElementById('backToTop');
        
        if (!backToTopBtn) {
            return;
        }
        
        // Show/hide back to top button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        }
        
        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Event listeners
        window.addEventListener('scroll', toggleBackToTop);
        backToTopBtn.addEventListener('click', scrollToTop);
    }

    /**
     * Smooth Scroll for Anchor Links
     * Provides smooth scrolling for internal anchor links
     */
    function initSmoothScroll() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Social Media Link Handler
     * Opens social media links in new tabs
     */
    function initSocialLinks() {
        const socialLinks = document.querySelectorAll('.social-link');
        
        socialLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                if (href && href !== '#') {
                    window.open(href, '_blank', 'noopener,noreferrer');
                }
            });
        });
    }

    /**
     * Donation Button Animation
     * Adds special animation effects to donation buttons
     */
    function initDonationButtons() {
        const donateButtons = document.querySelectorAll('.donate-btn');
        
        donateButtons.forEach(function(button) {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    /**
     * Footer Link Hover Effects
     * Adds smooth hover effects to footer links
     */
    function initFooterLinks() {
        const footerLinks = document.querySelectorAll('.footer-link, .footer-link-bottom');
        
        footerLinks.forEach(function(link) {
            link.addEventListener('mouseenter', function() {
                this.style.paddingLeft = '10px';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.paddingLeft = '0';
            });
        });
    }

    /**
     * Activity Item Hover Effects
     * Adds hover effects to activity items in footer
     */
    function initActivityItems() {
        const activityItems = document.querySelectorAll('.activity-item');
        
        activityItems.forEach(function(item) {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.05)';
                this.style.borderRadius = '8px';
                this.style.padding = '10px';
                this.style.margin = '5px -10px';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
                this.style.borderRadius = '0';
                this.style.padding = '0 0 15px 0';
                this.style.margin = '0 0 15px 0';
            });
        });
    }

    /**
     * Contact Item Hover Effects
     * Adds hover effects to contact items
     */
    function initContactItems() {
        const contactItems = document.querySelectorAll('.contact-item');
        
        contactItems.forEach(function(item) {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.05)';
                this.style.borderRadius = '6px';
                this.style.padding = '8px';
                this.style.margin = '7px -8px';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
                this.style.borderRadius = '0';
                this.style.padding = '0';
                this.style.margin = '0 0 15px 0';
            });
        });
    }

    /**
     * Scroll Animation for Footer Elements
     * Adds fade-in animation when footer comes into view
     */
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe footer sections
        const footerSections = document.querySelectorAll('.footer-section');
        footerSections.forEach(function(section) {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    }

    /**
     * Mobile Menu Enhancement
     * Enhances mobile menu functionality
     */
    function initMobileMenu() {
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                this.classList.toggle('active');
            });
        }
    }

    /**
     * Search Functionality Enhancement
     * Enhances search functionality
     */
    function initSearchEnhancement() {
        const searchInputs = document.querySelectorAll('input[name="keyword"]');
        
        searchInputs.forEach(function(input) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    }

    /**
     * Lazy Loading for Images
     * Implements lazy loading for images in footer
     */
    function initLazyLoading() {
        const images = document.querySelectorAll('.activity-image img');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(function(img) {
                if (img.dataset.src) {
                    imageObserver.observe(img);
                }
            });
        }
    }

    /**
     * Initialize all functionality when DOM is ready
     */
    function init() {
        // Core functionality
        initBackToTop();
        initSmoothScroll();
        initSocialLinks();
        
        // Footer enhancements
        initDonationButtons();
        initFooterLinks();
        initActivityItems();
        initContactItems();
        
        // Advanced features
        initScrollAnimations();
        initMobileMenu();
        initSearchEnhancement();
        initLazyLoading();
        
        console.log('Charity website custom JavaScript initialized successfully');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose functions globally if needed
    window.CharityWebsite = {
        init: init,
        initBackToTop: initBackToTop,
        initSmoothScroll: initSmoothScroll,
        initSocialLinks: initSocialLinks
    };

})();
