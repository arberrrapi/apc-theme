/**
 * Testimonials Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var ToggleControl = components.ToggleControl;
    var RangeControl = components.RangeControl;
    var __ = i18n.__;
    var useState = element.useState;
    var useEffect = element.useEffect;

    blocks.registerBlockType('apc/testimonials', {
        title: __('Testimonials'),
        icon: 'format-quote',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'What Our Clients Say'
            },
            subtitle: {
                type: 'string',
                default: 'Real feedback from companies we serve'
            },
            statsText: {
                type: 'string',
                default: 'Trusted by 500+ companies worldwide'
            },
            autoSlide: {
                type: 'boolean',
                default: true
            },
            slideInterval: {
                type: 'number',
                default: 20
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // Mock testimonials for preview (since we can't call external API in editor)
            var mockTestimonials = [
                {
                    text: 'APC Integrated has transformed our IT infrastructure. Their proactive support and expertise have been invaluable to our business growth.',
                    author: 'Sarah J.',
                    rating: 5
                },
                {
                    text: 'Outstanding service and reliability. APC\'s team is always responsive and their solutions are exactly what we needed.',
                    author: 'Michael C.',
                    rating: 5
                },
                {
                    text: 'The level of professionalism and technical expertise from APC is unmatched. They\'ve become an essential part of our operations.',
                    author: 'Emma R.',
                    rating: 5
                }
            ];

            return el('div', { className: 'testimonials-block' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Testimonials Settings', 'apc-theme'), initialOpen: true },
                        // API Configuration Notice
                        el('div', { 
                            style: { 
                                padding: '15px', 
                                backgroundColor: '#f0f8ff', 
                                border: '1px solid #0073aa', 
                                borderRadius: '4px', 
                                marginBottom: '15px'
                            }
                        }, 
                            el('p', { style: { margin: '0 0 10px 0', fontWeight: 'bold' } },
                                __('API Configuration', 'apc-theme')
                            ),
                            el('p', { style: { margin: 0 } },
                                __('API credentials are managed in ', 'apc-theme'),
                                el('a', { 
                                    href: '/wp-admin/themes.php?page=smileback-settings',
                                    target: '_blank',
                                    style: { textDecoration: 'none' }
                                }, __('Theme Settings', 'apc-theme'))
                            )
                        ),
                        
                        el(ToggleControl, {
                            label: __('Auto Slide', 'apc-theme'),
                            checked: attributes.autoSlide,
                            onChange: function (value) {
                                setAttributes({ autoSlide: value });
                            }
                        }),
                        
                        attributes.autoSlide && el(RangeControl, {
                            label: __('Slide Interval (seconds)', 'apc-theme'),
                            value: attributes.slideInterval,
                            onChange: function (value) {
                                setAttributes({ slideInterval: value });
                            },
                            min: 5,
                            max: 30,
                            step: 5
                        })
                    )
                ),

                // Preview
                el('div', { className: 'testimonials-wrapper' },
                    el('div', { className: 'testimonials-container' },
                        el('div', { className: 'testimonials-header' },
                            el('div', { className: 'testimonials-header-left' },
                                el(RichText, {
                                    tagName: 'h2',
                                    value: attributes.title,
                                    onChange: function (value) {
                                        setAttributes({ title: value });
                                    },
                                    placeholder: __('Enter title...', 'apc-theme')
                                }),
                                el(RichText, {
                                    tagName: 'p',
                                    value: attributes.subtitle,
                                    onChange: function (value) {
                                        setAttributes({ subtitle: value });
                                    },
                                    placeholder: __('Enter subtitle...', 'apc-theme')
                                })
                            ),
                            el('div', { className: 'testimonials-header-right' },
                                el(RichText, {
                                    tagName: 'p',
                                    value: attributes.statsText,
                                    onChange: function (value) {
                                        setAttributes({ statsText: value });
                                    },
                                    placeholder: __('Enter stats text...', 'apc-theme')
                                })
                            )
                        ),
                        el('div', { className: 'testimonials-slider' },
                            el('div', { className: 'testimonials-track' },
                                mockTestimonials.map(function (testimonial, index) {
                                    return el('div', {
                                        key: index,
                                        className: 'testimonial-card'
                                    },
                                        el('div', { className: 'stars' },
                                            Array(5).fill().map(function (_, i) {
                                                return el('i', {
                                                    key: i,
                                                    className: 'fa-solid fa-star'
                                                });
                                            })
                                        ),
                                        el('p', { className: 'testimonial-text' }, 
                                            '"' + testimonial.text + '"'
                                        ),
                                        el('div', { className: 'testimonial-author' },
                                            el('strong', {}, testimonial.author)
                                        )
                                    );
                                })
                            )
                        ),
                        el('div', { 
                            style: { 
                                padding: '10px', 
                                backgroundColor: '#f0f8ff', 
                                border: '1px solid #ddd', 
                                borderRadius: '4px', 
                                marginTop: '20px',
                                fontSize: '14px'
                            }
                        }, 
                            el('strong', {}, __('Preview Mode: ', 'apc-theme')), 
                            __('Showing sample testimonials. Live data will be fetched from SmileBack API on the frontend.', 'apc-theme')
                        )
                    )
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;

            return el('div', { className: 'testimonials-wrapper' },
                el('div', { className: 'testimonials-container' },
                    el('div', { className: 'testimonials-header' },
                        el('div', { className: 'testimonials-header-left' },
                            el(RichText.Content, {
                                tagName: 'h2',
                                value: attributes.title
                            }),
                            el(RichText.Content, {
                                tagName: 'p',
                                value: attributes.csat
                            })
                        ),
                        el('div', { className: 'testimonials-header-right' },
                            el(RichText.Content, {
                                tagName: 'p',
                                value: attributes.reviews
                            })
                        )
                    ),
                    el('div', { 
                        className: 'testimonials-slider',
                        'data-api-url': attributes.apiUrl,
                        'data-auto-slide': attributes.autoSlide,
                        'data-slide-interval': attributes.slideInterval
                    },
                        el('div', { className: 'testimonials-track' },
                            // Will be populated by JavaScript
                        )
                    )
                )
            );
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);