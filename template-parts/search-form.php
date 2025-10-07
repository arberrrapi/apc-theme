<?php
/**
 * APC Search Form with Autocomplete
 * 
 * @package APC_Theme
 */
?>

<?php 
// Generate unique ID for this search instance
$search_id = 'search-' . wp_generate_uuid4();
?>
<div class="apc-search-container" data-search-id="<?php echo esc_attr($search_id); ?>">
    <form class="apc-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="search-input-container">
            <input 
                type="search" 
                class="apc-search-input" 
                name="s" 
                placeholder="<?php esc_attr_e('Search resources...', 'apc-theme'); ?>"
                value="<?php echo get_search_query(); ?>"
                autocomplete="off"
                spellcheck="false"
            >
            <button type="submit" class="search-submit-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="sr-only"><?php _e('Search', 'apc-theme'); ?></span>
            </button>
        </div>
        <div class="apc-search-results" style="display: none;"></div>
    </form>
</div>

<style>
/* APC Search Styles */
.apc-search-container {
    position: relative;
    max-width: 500px;
    width: 100%;
}

.apc-search-form {
    position: relative;
}

.search-input-container {
    position: relative;
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid #e1e5e9;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-input-container:focus-within {
    border-color: #7055EE;
    box-shadow: 0 0 0 4px rgba(112, 85, 238, 0.1);
}

.apc-search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: none;
    background: transparent;
    font-size: 1rem;
    color: #333;
    outline: none;
    height: auto;
}

.apc-search-input::placeholder {
    color: #9ca3af;
}

.search-submit-btn {
    padding: 1rem 1.5rem;
    border: none;
    background: #7055EE;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-submit-btn:hover {
    background: #5a4bcc;
}

.apc-search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e1e5e9;
    border-top: none;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
}

.search-result-item {
    padding: 0.75rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-result-item:hover,
.search-result-item.active {
    background: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-title {
    font-size: 1rem;
    font-weight: 500;
    color: var(--text-color);
    margin: 0;
    line-height: 1.4;
    text-align:left;
}

.search-result-title mark {
    background: #fff3cd;
    color: #856404;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
}

.search-loading,
.search-no-results,
.search-error {
    padding: 1.5rem;
    text-align: center;
    color: #666;
    font-style: italic;
}

.search-error {
    color: #dc3545;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .search-input-container {
        background: #1f2937;
        border-color: #374151;
    }
    
    .search-input-container:focus-within {
        border-color: #7055EE;
    }
    
    .apc-search-input {
        color: white;
    }
    
    .apc-search-input::placeholder {
        color: #9ca3af;
    }
    
    .apc-search-results {
        background: #1f2937;
        border-color: #374151;
    }
    
    .search-result-item:hover,
    .search-result-item.active {
        background: #374151;
    }
    
    .search-result-title {
        color: white;
    }
    
    .search-result-excerpt {
        color: #d1d5db;
    }
    
    .search-loading,
    .search-no-results,
    .search-error {
        color: #d1d5db;
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .apc-search-container {
        max-width: 100%;
    }
    
    .apc-search-input {
        padding: 0.875rem 1rem;
        font-size: 0.9rem;
    }
    
    .search-submit-btn {
        padding: 0.875rem 1rem;
    }
    
    .search-result-item {
        padding: 0.875rem 1rem;
    }
    
    .search-result-meta {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>