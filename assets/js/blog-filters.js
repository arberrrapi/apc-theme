/**
 * Blog Post Filtering System
 * Handles filtering posts by content type and category with smooth animations
 */
document.addEventListener('DOMContentLoaded', function() {
    const postTypeSelect = document.getElementById('post-type-select');
    const categorySelect = document.getElementById('category-select');
    const postsContainer = document.getElementById('blog-posts-container');
    const allButton = document.getElementById('all-button');
    const loadingState = document.getElementById('loading-state');
    
    let currentFilters = {
        post_type: 'all',
        category: 'all'
    };
    
    // Initialize filters
    initializeFilters();
    
    function initializeFilters() {
        postTypeSelect.addEventListener('change', handleFilterChange);
        categorySelect.addEventListener('change', handleFilterChange);
        allButton.addEventListener('click', clearAllFilters);
        
        // Check initial pagination state
        updatePaginationVisibility();
    }
    
    function updatePaginationVisibility() {
        const pagination = document.querySelector('.blog-pagination');
        const hasActiveFilters = currentFilters.post_type !== 'all' || currentFilters.category !== 'all';
        
        if (pagination) {
            pagination.style.display = hasActiveFilters ? 'none' : 'block';
        }
    }
    
    function showEmptyMessage() {
        const postsGrid = document.getElementById('blog-posts-container');
        let emptyMessage = postsGrid.querySelector('.empty-filter-results');
        
        if (!emptyMessage) {
            emptyMessage = document.createElement('div');
            emptyMessage.className = 'empty-filter-results';
            emptyMessage.innerHTML = `
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>No posts found</h3>
                <p>Try adjusting your filters or search terms</p>
            `;
            postsGrid.appendChild(emptyMessage);
        }
        
        // Start with scaled down and transparent
        emptyMessage.style.display = 'block';
        emptyMessage.style.transform = 'scale(0.7)';
        emptyMessage.style.opacity = '0';
        
        // Smooth scale and fade in animation
        setTimeout(() => {
            emptyMessage.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            emptyMessage.style.transform = 'scale(1)';
            emptyMessage.style.opacity = '1';
        }, 100);
    }
    
    function hideEmptyMessage() {
        const emptyMessage = document.querySelector('.empty-filter-results');
        if (emptyMessage) {
            emptyMessage.style.transition = 'all 0.3s ease';
            emptyMessage.style.transform = 'scale(0.8)';
            emptyMessage.style.opacity = '0';
            setTimeout(() => {
                emptyMessage.style.display = 'none';
                emptyMessage.style.transform = 'scale(0.7)'; // Reset for next show
            }, 300);
        }
    }
    
    function handleFilterChange(e) {
        const select = e.target;
        const filterType = select.dataset.type;
        const filterValue = select.value;
        
        // Update current filters
        currentFilters[filterType] = filterValue;
        
        // Update pagination visibility immediately
        updatePaginationVisibility();
        
        // Apply filters with animation
        applyFilters();
        
        // Add select animation feedback
        addSelectFeedback(select);
    }
    
    function applyFilters() {
        const posts = document.querySelectorAll('.blog-post-card');
        
        // Determine posts to show/hide
        const postsToHide = Array.from(posts).filter(post => !shouldShowPost(post));
        const postsToShow = Array.from(posts).filter(post => shouldShowPost(post));
        
        // Check if we'll have empty results
        const willBeEmpty = postsToShow.length === 0;
        
        if (willBeEmpty) {
            // Hide all posts for empty results
            posts.forEach(post => {
                post.classList.add('hide');
                post.classList.remove('show');
            });
            
            // Show empty message after hide animation
            setTimeout(() => {
                showEmptyMessage();
                updatePaginationVisibility();
            }, 300);
            
        } else {
            // Normal filtering with show/hide animation
            hideEmptyMessage();
            
            // Hide posts that should be hidden
            postsToHide.forEach(post => {
                post.classList.add('hide');
                post.classList.remove('show');
            });
            
            // Show posts that should be shown
            postsToShow.forEach(post => {
                post.classList.remove('hide');
                post.classList.add('show');
            });
            
            // Update pagination after animation
            setTimeout(() => {
                updatePaginationVisibility();
            }, 300);
        }
    }
    
    function shouldShowPost(post) {
        const postType = post.dataset.postType;
        const postCategories = post.dataset.categories ? post.dataset.categories.split(',') : [];
        
        // Check post type filter
        const typeMatch = currentFilters.post_type === 'all' || postType === currentFilters.post_type;
        
        // Check category filter
        const categoryMatch = currentFilters.category === 'all' || 
                            postCategories.includes(currentFilters.category);
        
        return typeMatch && categoryMatch;
    }
    

    

    
    function clearAllFilters() {
        // Reset all filters to 'all'
        currentFilters = {
            post_type: 'all',
            category: 'all'
        };
        
        // Reset select boxes
        postTypeSelect.value = 'all';
        categorySelect.value = 'all';
        
        // Update pagination visibility
        updatePaginationVisibility();
        
        // Show all posts
        applyFilters();
        
        // Add success feedback to All button
        allButton.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        allButton.innerHTML = '<i class="fa-solid fa-check"></i> Cleared';
        
        setTimeout(() => {
            allButton.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            allButton.innerHTML = '<i class="fa-solid fa-list"></i> All';
        }, 1000);
        
        // Add visual feedback to selects
        addSelectFeedback(postTypeSelect);
        addSelectFeedback(categorySelect);
    }
    
    function showLoading() {
        loadingState.style.display = 'block';
        postsContainer.style.opacity = '0.7';
    }
    
    function hideLoading() {
        loadingState.style.display = 'none';
        postsContainer.style.opacity = '1';
    }
    
    function triggerGridAnimation() {
        const visiblePosts = document.querySelectorAll('.blog-post-card:not(.filtering-out)');
        
        visiblePosts.forEach((post, index) => {
            post.style.animationDelay = `${index * 0.1}s`;
            post.classList.add('filtering-in');
        });
    }
    
    function addSelectFeedback(selectElement) {
        // Add pulsing feedback animation
        selectElement.style.transform = 'scale(1.05)';
        selectElement.style.borderColor = '#667eea';
        selectElement.style.boxShadow = '0 0 20px rgba(102, 126, 234, 0.4)';
        
        // Create ripple effect
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: rgba(102, 126, 234, 0.6);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: selectRipple 0.6s ease-out;
            pointer-events: none;
            z-index: 1000;
        `;
        
        selectElement.parentNode.style.position = 'relative';
        selectElement.parentNode.appendChild(ripple);
        
        setTimeout(() => {
            selectElement.style.transform = 'scale(1)';
            selectElement.style.borderColor = '#e1e5e9';
            selectElement.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.05)';
            ripple.remove();
        }, 600);
    }
    
    // Add CSS animation for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .filter-tab {
            position: relative;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
    
    // Keyboard accessibility for select boxes
    postTypeSelect.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            this.blur(); // Remove focus after selection
        }
    });
    
    categorySelect.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            this.blur(); // Remove focus after selection
        }
    });
    
    // URL hash support for deep linking
    function updateURLHash() {
        const params = new URLSearchParams();
        if (currentFilters.post_type !== 'all') {
            params.set('type', currentFilters.post_type);
        }
        if (currentFilters.category !== 'all') {
            params.set('category', currentFilters.category);
        }
        
        const hash = params.toString();
        if (hash) {
            window.history.replaceState(null, null, `#${hash}`);
        } else {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }
    
    // Load filters from URL on page load
    function loadFiltersFromURL() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const params = new URLSearchParams(hash);
            const typeFilter = params.get('type');
            const categoryFilter = params.get('category');
            
            if (typeFilter && postTypeSelect.querySelector(`option[value="${typeFilter}"]`)) {
                postTypeSelect.value = typeFilter;
                currentFilters.post_type = typeFilter;
            }
            
            if (categoryFilter && categorySelect.querySelector(`option[value="${categoryFilter}"]`)) {
                categorySelect.value = categoryFilter;
                currentFilters.category = categoryFilter;
            }
            
            if (typeFilter || categoryFilter) {
                updatePaginationVisibility();
                applyFilters();
            }
        }
    }
    
    // Initialize URL hash support
    loadFiltersFromURL();
    
    // Update hash when filters change
    const originalHandleFilterChange = handleFilterChange;
    handleFilterChange = function(e) {
        originalHandleFilterChange.call(this, e);
        updateURLHash();
    };
});