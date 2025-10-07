/**
 * APC Image Block Parallax Effect - Simplified
 */
(function() {
    'use strict';
    
    console.log('APC Image Parallax script loaded');

    let ticking = false;

    function updateParallax() {
        const images = document.querySelectorAll('.wp-block-apc-image .apc-image-wrapper img');
        
        images.forEach(function(img) {
            const container = img.closest('.apc-image-container');
            if (!container) return;
            
            const rect = container.getBoundingClientRect();
            const speed = 0.5; // Parallax speed (0.5 = half speed of scroll)
            
            // Calculate parallax offset based on element position
            const yPos = -(rect.top * speed);
            
            // Apply transform
            img.style.transform = 'translateY(' + yPos + 'px)';
        });
        
        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }

    function initParallax() {
        console.log('Initializing simple parallax...');
        const images = document.querySelectorAll('.wp-block-apc-image .apc-image-wrapper img');
        console.log('Found', images.length, 'APC images for parallax');
        
        if (images.length === 0) {
            console.log('No APC images found, skipping parallax init');
            return;
        }

        // Add scroll event listener
        window.addEventListener('scroll', requestTick, { passive: true });
        window.addEventListener('resize', requestTick, { passive: true });

        // Initial update
        updateParallax();
        
        console.log('Parallax initialized successfully');
    }



    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initParallax();
        });
    } else {
        initParallax();
    }

    // Re-initialize for dynamically added content (Gutenberg editor)
    if (window.wp && window.wp.data) {
        let lastPostId = null;
        
        const checkForNewBlocks = () => {
            const currentPostId = wp.data.select('core/editor')?.getCurrentPostId?.();
            if (currentPostId !== lastPostId) {
                lastPostId = currentPostId;
                setTimeout(() => {
                    initParallax();
                }, 500);
            }
        };

        // Subscribe to block editor changes
        if (wp.data.subscribe) {
            wp.data.subscribe(checkForNewBlocks);
        }
    }

})();