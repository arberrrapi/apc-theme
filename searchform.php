<?php
/**
 * Search form template
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-form-group">
        <input type="search" 
               class="search-field" 
               placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'apc-theme'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" />
        <button type="submit" class="search-submit">
            <i class="fa-solid fa-search"></i>
            <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'apc-theme'); ?></span>
        </button>
    </div>
</form>

<style>
.search-form {
    width: 100%;
}

.search-form-group {
    position: relative;
    display: flex;
    width: 100%;
}

.search-field {
    flex: 1;
    padding: 12px 50px 12px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 25px;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.search-field:focus {
    border-color: var(--accent-blue, #3182ce);
}

.search-submit {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--accent-blue, #3182ce);
    color: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-submit:hover {
    background: var(--primary-blue, #1a365d);
}

.screen-reader-text {
    clip: rect(1px, 1px, 1px, 1px);
    position: absolute !important;
    height: 1px;
    width: 1px;
    overflow: hidden;
}
</style>