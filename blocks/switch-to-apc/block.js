/**
 * Switch to APC Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var Button = components.Button;
    var __ = i18n.__;

    blocks.registerBlockType('apc/switch-to-apc', {
        title: __('Switch to APC'),
        icon: 'migrate',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: '<h2>Why <span style="color: #7055EE;">Switch to APC</span>?</h2>'
            },
            listings: {
                type: 'array',
                default: [
                    {
                        title: 'Expert Support',
                        description: 'Get 24/7 technical support from certified professionals who understand your business needs.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        labelText: '24/7'
                    },
                    {
                        title: 'Cost Effective',
                        description: 'Reduce your IT costs while improving performance and reliability with our managed services.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        labelText: 'Save $$$'
                    },
                    {
                        title: 'Proven Results',
                        description: 'Join hundreds of satisfied clients who have transformed their business with APC solutions.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        labelText: 'Trusted'
                    }
                ]
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var updateListing = function (index, field, value) {
                var updatedListings = [...attributes.listings];
                updatedListings[index] = { ...updatedListings[index], [field]: value };
                setAttributes({ listings: updatedListings });
            };

            var addListing = function () {
                var newListing = {
                    title: 'New Reason',
                    description: 'Description for switching to APC.',
                    buttonText: 'Learn More',
                    buttonLink: '#contact',
                    labelText: 'New'
                };
                setAttributes({ listings: [...attributes.listings, newListing] });
            };

            var removeListing = function (index) {
                var updatedListings = attributes.listings.filter((_, i) => i !== index);
                setAttributes({ listings: updatedListings });
            };

            return el('div', { className: 'switch-to-apc-block' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Header Settings', 'apc-theme'), initialOpen: true },
                        el(TextareaControl, {
                            label: __('Title (HTML Supported)', 'apc-theme'),
                            value: attributes.title,
                            onChange: function (value) {
                                setAttributes({ title: value });
                            },
                            help: __('You can use HTML tags like <h2>, <span>, <strong>, etc.', 'apc-theme'),
                            rows: 4
                        })
                    ),
                    el(PanelBody, { title: __('Reasons Settings', 'apc-theme'), initialOpen: false },
                        el(Button, {
                            isPrimary: true,
                            onClick: addListing,
                            style: { marginBottom: '16px' }
                        }, __('Add New Reason', 'apc-theme')),

                        attributes.listings.map(function (listing, index) {
                            return el(PanelBody, {
                                key: index,
                                title: __('Reason ' + (index + 1) + ': ' + listing.title, 'apc-theme'),
                                initialOpen: false
                            },
                                el(TextControl, {
                                    label: __('Title', 'apc-theme'),
                                    value: listing.title,
                                    onChange: function (value) {
                                        updateListing(index, 'title', value);
                                    }
                                }),
                                el('div', { style: { marginBottom: '16px' } },
                                    el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, __('Description (HTML allowed)', 'apc-theme')),
                                    el(RichText, {
                                        value: listing.description,
                                        onChange: function (value) {
                                            updateListing(index, 'description', value);
                                        },
                                        placeholder: __('Enter description...', 'apc-theme'),
                                        style: { 
                                            border: '1px solid #ddd', 
                                            padding: '10px', 
                                            borderRadius: '4px',
                                            minHeight: '80px'
                                        }
                                    })
                                ),
                                el(TextControl, {
                                    label: __('Button Text', 'apc-theme'),
                                    value: listing.buttonText,
                                    onChange: function (value) {
                                        updateListing(index, 'buttonText', value);
                                    }
                                }),
                                el(TextControl, {
                                    label: __('Button Link', 'apc-theme'),
                                    value: listing.buttonLink,
                                    onChange: function (value) {
                                        updateListing(index, 'buttonLink', value);
                                    }
                                }),
                                el(TextControl, {
                                    label: __('Label Text', 'apc-theme'),
                                    value: listing.labelText || '',
                                    onChange: function (value) {
                                        updateListing(index, 'labelText', value);
                                    },
                                    help: __('Short text with gradient styling (e.g., "24/7", "New", "Pro")', 'apc-theme')
                                }),
                                el(Button, {
                                    isDestructive: true,
                                    onClick: function () { removeListing(index); },
                                    style: { marginTop: '16px' }
                                }, __('Remove Reason', 'apc-theme'))
                            );
                        })
                    )
                ),

                // Preview
                el('div', { className: 'switch-to-apc-wrapper' },
                    el('div', { className: 'container' },
                        el('div', { className: 'switch-to-apc-header' },
                            el('div', {
                                className: 'switch-to-apc-title',
                                dangerouslySetInnerHTML: { __html: attributes.title },
                                style: { 
                                    border: '1px dashed #ccc', 
                                    padding: '10px', 
                                    minHeight: '50px',
                                    backgroundColor: '#f9f9f9'
                                }
                            })
                        ),
                        el('div', { className: 'reasons-grid' },
                            attributes.listings.map(function (listing, index) {
                                return el('div', { 
                                    key: index,
                                    className: 'reason-card' 
                                },
                                        listing.labelText && el('div', { className: 'reason-label' },
                                            el('span', {
                                                className: 'label-text'
                                            }, listing.labelText)
                                        ),
                                        el('h3', { className: 'reason-title' }, listing.title),
                                        el(RichText, {
                                            tagName: 'div',
                                            className: 'reason-description',
                                            value: listing.description,
                                            onChange: function (value) {
                                                updateListing(index, 'description', value);
                                            },
                                            placeholder: __('Enter description...', 'apc-theme')
                                        }),
                                        el('a', {
                                            href: listing.buttonLink,
                                            className: 'reason-button'
                                        }, listing.buttonText)
                                );
                            })
                        )
                    )
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;

            return el('div', { className: 'switch-to-apc-wrapper' },
                el('div', { className: 'container' },
                    el('div', { className: 'switch-to-apc-header' },
                        el('div', {
                            className: 'switch-to-apc-title',
                            dangerouslySetInnerHTML: { __html: attributes.title }
                        })
                    ),
                    el('div', { className: 'reasons-grid' },
                        attributes.listings.map(function (listing, index) {
                            return el('div', { 
                                key: index,
                                className: 'reason-card' 
                            },
                                listing.labelText && el('div', { className: 'reason-label' },
                                    el('span', {
                                        className: 'label-text'
                                    }, listing.labelText)
                                ),
                                el('h3', { className: 'reason-title' }, listing.title),
                                el(RichText.Content, {
                                    tagName: 'div',
                                    className: 'reason-description',
                                    value: listing.description
                                }),
                                el('a', {
                                    href: listing.buttonLink,
                                    className: 'reason-button'
                                }, listing.buttonText)
                            );
                        })
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