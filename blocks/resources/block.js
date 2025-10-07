/**
 * Resources Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var ToggleControl = components.ToggleControl;
    var RangeControl = components.RangeControl;
    var SelectControl = components.SelectControl;
    var __ = i18n.__;

    blocks.registerBlockType('apc/resources', {
        title: __('Resources'),
        icon: 'book',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Latest Resources'
            },
            postsPerPage: {
                type: 'number',
                default: 4
            },
            showControls: {
                type: 'boolean',
                default: true
            },
            postType: {
                type: 'string',
                default: 'post'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // Mock resources for preview
            var mockResources = [
                {
                    title: 'Essential Cloud Security Strategies for Modern Businesses',
                    image: '/wp-content/themes/apc_theme/assets/img/site/resource.jpg',
                    tags: ['Cloud Security', 'Best Practices'],
                    link: '#'
                },
                {
                    title: 'How to Choose the Right IT Support Partner for Your Business',
                    image: '/wp-content/themes/apc_theme/assets/img/site/resource.jpg',
                    tags: ['IT Support', 'Guide'],
                    link: '#'
                },
                {
                    title: '2024 Cybersecurity Trends Every Business Should Know',
                    image: '/wp-content/themes/apc_theme/assets/img/site/resource.jpg',
                    tags: ['Cybersecurity', 'Trends'],
                    link: '#'
                },
                {
                    title: 'Complete Guide to Digital Transformation for SMBs',
                    image: '/wp-content/themes/apc_theme/assets/img/site/resource.jpg',
                    tags: ['Digital Transformation'],
                    link: '#'
                }
            ];

            return el('div', { className: 'resources-block-editor' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Resources Settings', 'apc-theme'), initialOpen: true },
                        el(RangeControl, {
                            label: __('Number of Posts', 'apc-theme'),
                            value: attributes.postsPerPage,
                            onChange: function (value) {
                                setAttributes({ postsPerPage: value });
                            },
                            min: 1,
                            max: 12,
                            step: 1
                        }),
                        
                        el(ToggleControl, {
                            label: __('Show Navigation Controls', 'apc-theme'),
                            checked: attributes.showControls,
                            onChange: function (value) {
                                setAttributes({ showControls: value });
                            }
                        }),
                        
                        el(SelectControl, {
                            label: __('Post Type', 'apc-theme'),
                            value: attributes.postType,
                            onChange: function (value) {
                                setAttributes({ postType: value });
                            },
                            options: [
                                { label: 'Blog Posts', value: 'post' },
                                { label: 'Pages', value: 'page' },
                                { label: 'Q&A', value: 'qa' }
                            ]
                        })
                    )
                ),

                // Preview
                el('div', { className: 'resources-wrapper' },
                    el('div', { className: 'resources-container' },
                        el('div', { className: 'resources-header' },
                            el(RichText, {
                                tagName: 'h2',
                                value: attributes.title,
                                onChange: function (value) {
                                    setAttributes({ title: value });
                                },
                                placeholder: __('Enter title...', 'apc-theme')
                            }),
                            attributes.showControls && el('div', { className: 'resources-controls' },
                                el('button', { className: 'resource-arrow resource-prev' },
                                    el('i', { className: 'fa-solid fa-arrow-left' })
                                ),
                                el('button', { className: 'resource-arrow resource-next' },
                                    el('i', { className: 'fa-solid fa-arrow-right' })
                                )
                            )
                        ),
                        
                        el('div', { className: 'resources-slider' },
                            el('div', { className: 'resources-track' },
                                mockResources.slice(0, attributes.postsPerPage).map(function (resource, index) {
                                    return el('div', { 
                                        key: index,
                                        className: 'resource-card'
                                    },
                                        el('div', { className: 'resource-image' },
                                            el('img', {
                                                src: resource.image,
                                                alt: resource.title
                                            })
                                        ),
                                        el('div', { className: 'resource-tags' },
                                            resource.tags.map(function (tag, tagIndex) {
                                                return el('span', {
                                                    key: tagIndex,
                                                    className: 'resource-tag'
                                                }, tag);
                                            })
                                        ),
                                        el('h4', {}, resource.title)
                                    );
                                })
                            )
                        )
                    )
                )
            );
        },

        save: function () {
            return null; // Rendered in PHP
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);