/**
 * APC Search Autocomplete Functionality
 */
(function($) {
    'use strict';

    // Initialize search autocomplete
    function initSearchAutocomplete() {
        $('.apc-search-container').each(function() {
            const $container = $(this);
            const $searchInput = $container.find('.apc-search-input');
            const $searchResults = $container.find('.apc-search-results');
            const $searchForm = $container.find('.apc-search-form');
            let searchTimeout;

            if (!$searchInput.length) return;

            // Handle input changes
            $searchInput.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    $searchResults.hide().empty();
                    return;
                }

                // Debounce search requests
                searchTimeout = setTimeout(function() {
                    performSearch(query, $searchResults);
                }, 300);
            });

            // Handle form submission
            $searchForm.on('submit', function(e) {
                e.preventDefault();
                const query = $searchInput.val().trim();
                if (query.length > 0) {
                    window.location.href = apcSearch.searchUrl + '?s=' + encodeURIComponent(query);
                }
            });

            // Handle result clicks
            $searchResults.on('click', '.search-result-item', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                if (url) {
                    window.location.href = url;
                }
            });

            // Handle keyboard navigation
            $searchInput.on('keydown', function(e) {
                const $results = $searchResults.find('.search-result-item');
                const $activeResult = $results.filter('.active');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if ($activeResult.length === 0) {
                        $results.first().addClass('active');
                    } else {
                        const $next = $activeResult.removeClass('active').next('.search-result-item');
                        if ($next.length > 0) {
                            $next.addClass('active');
                        } else {
                            $results.first().addClass('active');
                        }
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if ($activeResult.length === 0) {
                        $results.last().addClass('active');
                    } else {
                        const $prev = $activeResult.removeClass('active').prev('.search-result-item');
                        if ($prev.length > 0) {
                            $prev.addClass('active');
                        } else {
                            $results.last().addClass('active');
                        }
                    }
                } else if (e.key === 'Enter') {
                    if ($activeResult.length > 0) {
                        e.preventDefault();
                        const url = $activeResult.data('url');
                        if (url) {
                            window.location.href = url;
                        }
                    }
                } else if (e.key === 'Escape') {
                    $searchResults.hide();
                    $searchInput.blur();
                }
            });
        });

        // Close results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.apc-search-container').length) {
                $('.apc-search-results').hide();
            }
        });
    }

    // Perform AJAX search
    function performSearch(query, $searchResults) {
        // Show loading state
        $searchResults.html('<div class="search-loading">Searching...</div>').show();

        $.ajax({
            url: apcSearch.ajaxUrl,
            type: 'POST',
            data: {
                action: 'apc_search_posts',
                query: query,
                nonce: apcSearch.nonce
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    let html = '';
                    
                    response.data.forEach(function(post) {
                        html += `
                            <div class="search-result-item" data-url="${post.url}">
                                <div class="search-result-content">
                                    <h4 class="search-result-title">${post.title}</h4>
                                </div>
                            </div>
                        `;
                    });
                    
                    $searchResults.html(html).show();
                } else {
                    $searchResults.html('<div class="search-no-results">No results found for "' + query + '"</div>').show();
                }
            },
            error: function() {
                $searchResults.html('<div class="search-error">Search failed. Please try again.</div>').show();
            }
        });
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initSearchAutocomplete();
    });

})(jQuery);