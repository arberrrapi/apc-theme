/**
 * Q&A Display Block
 */
(function (blocks, element, editor, components, i18n, apiFetch) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var ToggleControl = components.ToggleControl;
    var RangeControl = components.RangeControl;
    var CheckboxControl = components.CheckboxControl;
    var Spinner = components.Spinner;
    var __ = i18n.__;
    var useState = element.useState;
    var useEffect = element.useEffect;

    blocks.registerBlockType('apc/qa-display', {
        title: __('Q&A Display'),
        icon: 'editor-help',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Frequently Asked Questions'
            },
            description: {
                type: 'string',
                default: 'Find answers to commonly asked questions about our services.'
            },
            selectedCategories: {
                type: 'array',
                default: []
            },
            showAllCategories: {
                type: 'boolean',
                default: true
            },
            itemsPerPage: {
                type: 'number',
                default: 10
            },
            accordionStyle: {
                type: 'boolean',
                default: true
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // State for categories and posts
            var categoriesState = useState([]);
            var qaCategories = categoriesState[0];
            var setQaCategories = categoriesState[1];

            var postsState = useState([]);
            var qaPosts = postsState[0];
            var setQaPosts = postsState[1];

            var loadingState = useState(true);
            var isLoading = loadingState[0];
            var setIsLoading = loadingState[1];

            // Load categories on component mount
            useEffect(function() {
                apiFetch({ path: '/wp/v2/qa_category?per_page=100' })
                    .then(function(categories) {
                        setQaCategories(categories || []);
                        setIsLoading(false);
                    })
                    .catch(function(error) {
                        console.error('Error loading categories:', error);
                        setQaCategories([]);
                        setIsLoading(false);
                    });
            }, []);

            // Load posts when categories or settings change
            useEffect(function() {
                var query = '/wp/v2/qa?per_page=' + attributes.itemsPerPage + '&status=publish';
                
                if (!attributes.showAllCategories && attributes.selectedCategories.length > 0) {
                    query += '&qa_category=' + attributes.selectedCategories.join(',');
                }
                
                apiFetch({ path: query })
                    .then(function(posts) {
                        setQaPosts(posts || []);
                    })
                    .catch(function(error) {
                        console.error('Error loading posts:', error);
                        setQaPosts([]);
                    });
            }, [attributes.selectedCategories, attributes.showAllCategories, attributes.itemsPerPage]);

            var toggleCategory = function (categoryId) {
                var updatedCategories = [...attributes.selectedCategories];
                var index = updatedCategories.indexOf(categoryId);
                
                if (index > -1) {
                    updatedCategories.splice(index, 1);
                } else {
                    updatedCategories.push(categoryId);
                }
                
                setAttributes({ selectedCategories: updatedCategories });
            };

            return el('div', { className: 'qa-display-block' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Q&A Settings', 'apc-theme'), initialOpen: true },
                        el(ToggleControl, {
                            label: __('Show All Categories', 'apc-theme'),
                            checked: attributes.showAllCategories,
                            onChange: function (value) {
                                setAttributes({ showAllCategories: value });
                            }
                        }),
                        
                        !attributes.showAllCategories && el('div', { style: { marginTop: '16px' } },
                            el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, 
                                __('Select Categories', 'apc-theme')
                            ),
                            
                            isLoading ? el('p', {}, __('Loading categories...', 'apc-theme')) :
                            qaCategories.length === 0 ? el('p', {}, __('No categories found. Create some Q&A categories first.', 'apc-theme')) :
                            el('div', {},
                                qaCategories.map(function (category) {
                                    return el(CheckboxControl, {
                                        key: category.id,
                                        label: category.name + ' (' + (category.count || 0) + ' items)',
                                        checked: attributes.selectedCategories.includes(category.id),
                                        onChange: function () {
                                            toggleCategory(category.id);
                                        }
                                    });
                                }),
                                el('div', { style: { marginTop: '12px', paddingTop: '12px', borderTop: '1px solid #ddd' } },
                                    el('button', {
                                        type: 'button',
                                        className: 'components-button is-link',
                                        onClick: function() {
                                            if (attributes.selectedCategories.length === qaCategories.length) {
                                                // Deselect all
                                                setAttributes({ selectedCategories: [] });
                                            } else {
                                                // Select all
                                                var allCategoryIds = qaCategories.map(function(cat) { return cat.id; });
                                                setAttributes({ selectedCategories: allCategoryIds });
                                            }
                                        }
                                    }, 
                                    attributes.selectedCategories.length === qaCategories.length ? 
                                        __('Deselect All', 'apc-theme') : 
                                        __('Select All', 'apc-theme')
                                    )
                                )
                            )
                        ),
                        
                        el(RangeControl, {
                            label: __('Items Per Page', 'apc-theme'),
                            value: attributes.itemsPerPage,
                            onChange: function (value) {
                                setAttributes({ itemsPerPage: value });
                            },
                            min: 1,
                            max: 50
                        }),
                        
                        el(ToggleControl, {
                            label: __('Accordion Style', 'apc-theme'),
                            checked: attributes.accordionStyle,
                            onChange: function (value) {
                                setAttributes({ accordionStyle: value });
                            },
                            help: __('Display Q&A items in collapsible accordion format', 'apc-theme')
                        })
                    )
                ),

                // Preview
                el('div', { className: 'qa-display-wrapper' },
                    el('div', { className: 'container' },
                        el('div', { className: 'qa-display-header' },
                            el(RichText, {
                                tagName: 'h2',
                                className: 'qa-display-title',
                                value: attributes.title,
                                onChange: function (value) {
                                    setAttributes({ title: value });
                                },
                                placeholder: __('Enter title...', 'apc-theme')
                            }),
                            el(RichText, {
                                tagName: 'p',
                                className: 'qa-display-description',
                                value: attributes.description,
                                onChange: function (value) {
                                    setAttributes({ description: value });
                                },
                                placeholder: __('Enter description...', 'apc-theme')
                            })
                        ),
                        
                        // Show selected categories info
                        !attributes.showAllCategories && attributes.selectedCategories.length > 0 && qaCategories && el('div', {
                            style: {
                                padding: '12px',
                                backgroundColor: '#e7f3ff',
                                border: '1px solid #b3d9ff',
                                borderRadius: '4px',
                                marginBottom: '20px',
                                fontSize: '14px'
                            }
                        },
                            el('strong', {}, __('Displaying categories: ', 'apc-theme')),
                            qaCategories
                                .filter(function(cat) { return attributes.selectedCategories.includes(cat.id); })
                                .map(function(cat) { return cat.name; })
                                .join(', ')
                        ),
                        
                        el('div', { className: 'qa-display-content' },
                            isLoading ? el(Spinner) :
                            qaPosts.length === 0 ? 
                                el('p', { className: 'no-qa-found' }, __('No Q&A items found for the selected criteria.', 'apc-theme')) :
                                el('div', { className: attributes.accordionStyle ? 'qa-accordion' : 'qa-list' },
                                    qaPosts.map(function (post, index) {
                                        return el('div', {
                                            key: post.id,
                                            className: attributes.accordionStyle ? 'qa-accordion-item' : 'qa-list-item'
                                        },
                                            el('div', { 
                                                className: attributes.accordionStyle ? 'qa-accordion-header' : 'qa-question',
                                                style: { 
                                                    padding: '15px',
                                                    backgroundColor: '#f8f9fa',
                                                    border: '1px solid #dee2e6',
                                                    cursor: attributes.accordionStyle ? 'pointer' : 'default'
                                                }
                                            },
                                                el('h3', { style: { margin: 0, fontSize: '18px' } }, post.title ? post.title.rendered : 'Untitled')
                                            ),
                                            el('div', {
                                                className: attributes.accordionStyle ? 'qa-accordion-content' : 'qa-answer',
                                                style: { 
                                                    padding: '15px',
                                                    border: '1px solid #dee2e6',
                                                    borderTop: 'none',
                                                    backgroundColor: '#fff'
                                                }
                                            },
                                                el('div', {
                                                    dangerouslySetInnerHTML: { __html: post.excerpt ? post.excerpt.rendered : 'No content available' }
                                                })
                                            )
                                        );
                                    })
                                )
                        )
                    )
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;

            return el('div', { className: 'qa-display-wrapper' },
                el('div', { className: 'container' },
                    el('div', { className: 'qa-display-header' },
                        el(RichText.Content, {
                            tagName: 'h2',
                            className: 'qa-display-title',
                            value: attributes.title
                        }),
                        el(RichText.Content, {
                            tagName: 'p',
                            className: 'qa-display-description',
                            value: attributes.description
                        })
                    ),
                    
                    el('div', { 
                        className: 'qa-display-content',
                        'data-show-all': attributes.showAllCategories,
                        'data-categories': JSON.stringify(attributes.selectedCategories),
                        'data-items-per-page': attributes.itemsPerPage,
                        'data-accordion-style': attributes.accordionStyle
                    })
                )
            );
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n,
    window.wp.apiFetch
);