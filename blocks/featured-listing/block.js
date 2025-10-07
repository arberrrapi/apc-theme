/**
 * Featured Listing Block
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

    blocks.registerBlockType('apc/featured-listing', {
        title: __('Featured Listing'),
        icon: 'grid-view',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Featured Listings'
            },
            description: {
                type: 'string',
                default: 'Showcase our featured projects and solutions across various industries.'
            },
            headerImageUrl: {
                type: 'string',
                default: ''
            },
            headerImageAlt: {
                type: 'string',
                default: 'Featured Listings'
            },
            listings: {
                type: 'array',
                default: [
                    {
                        title: 'Cloud Solutions',
                        description: 'Comprehensive cloud infrastructure and migration services designed to scale with your business needs and enhance operational efficiency.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        iconClass: 'fas fa-cloud'
                    },
                    {
                        title: 'Cybersecurity',
                        description: 'Advanced security solutions to protect your business from evolving cyber threats and ensure compliance with industry standards.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        iconClass: 'fas fa-shield-alt'
                    },
                    {
                        title: 'Managed Services',
                        description: 'Complete IT management solutions that allow you to focus on your core business while we handle your technology infrastructure.',
                        buttonText: 'Learn More',
                        buttonLink: '#contact',
                        iconClass: 'fas fa-cogs'
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
                    title: 'New Listing',
                    description: 'Description for the new listing.',
                    buttonText: 'Learn More',
                    buttonLink: '#contact',
                    iconClass: 'fas fa-star'
                };
                setAttributes({ listings: [...attributes.listings, newListing] });
            };

            var removeListing = function (index) {
                var updatedListings = attributes.listings.filter((_, i) => i !== index);
                setAttributes({ listings: updatedListings });
            };



            return el('div', { className: 'featured-listing-block' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Header Settings', 'apc-theme'), initialOpen: true },
                        el('div', { style: { marginBottom: '16px' } },
                            el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, __('Header Image', 'apc-theme')),
                            attributes.headerImageUrl ? 
                                el('div', {},
                                    el('img', {
                                        src: attributes.headerImageUrl,
                                        alt: attributes.headerImageAlt,
                                        style: { width: '100%', maxWidth: '200px', height: 'auto', display: 'block', marginBottom: '8px' }
                                    }),
                                    el(Button, {
                                        isDestructive: true,
                                        onClick: function () { 
                                            setAttributes({ headerImageUrl: '', headerImageAlt: '' });
                                        }
                                    }, __('Remove Image', 'apc-theme'))
                                ) :
                                el(MediaUpload, {
                                    onSelect: function (media) { 
                                        setAttributes({ 
                                            headerImageUrl: media.url,
                                            headerImageAlt: media.alt || attributes.title
                                        });
                                    },
                                    allowedTypes: ['image'],
                                    render: function (obj) {
                                        return el(Button, {
                                            isPrimary: true,
                                            onClick: obj.open
                                        }, __('Select Header Image', 'apc-theme'));
                                    }
                                })
                        ),
                        el(TextControl, {
                            label: __('Image Alt Text', 'apc-theme'),
                            value: attributes.headerImageAlt,
                            onChange: function (value) {
                                setAttributes({ headerImageAlt: value });
                            }
                        })
                    ),
                    el(PanelBody, { title: __('Listing Settings', 'apc-theme'), initialOpen: false },
                        el(Button, {
                            isPrimary: true,
                            onClick: addListing,
                            style: { marginBottom: '16px' }
                        }, __('Add New Listing', 'apc-theme')),

                        attributes.listings.map(function (listing, index) {
                            return el(PanelBody, {
                                key: index,
                                title: __('Listing ' + (index + 1) + ': ' + listing.title, 'apc-theme'),
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
                                    label: __('FontAwesome Icon Class', 'apc-theme'),
                                    value: listing.iconClass || '',
                                    onChange: function (value) {
                                        updateListing(index, 'iconClass', value);
                                    },
                                    help: __('Example: fas fa-cloud, far fa-user, fab fa-facebook', 'apc-theme')
                                }),
                                el(Button, {
                                    isDestructive: true,
                                    onClick: function () { removeListing(index); },
                                    style: { marginTop: '16px' }
                                }, __('Remove Listing', 'apc-theme'))
                            );
                        })
                    )
                ),

                // Preview
                el('div', { className: 'featured-listing-wrapper' },
                    el('div', { className: 'container' },
                        el('div', { className: 'featured-listing-header' },
                            el(RichText, {
                                tagName: 'h2',
                                className: 'featured-listing-title',
                                value: attributes.title,
                                onChange: function (value) {
                                    setAttributes({ title: value });
                                },
                                placeholder: __('Enter title...', 'apc-theme')
                            }),
                            el(RichText, {
                                tagName: 'p',
                                className: 'featured-listing-description',
                                value: attributes.description,
                                onChange: function (value) {
                                    setAttributes({ description: value });
                                },
                                placeholder: __('Enter description...', 'apc-theme')
                            }),
                            attributes.headerImageUrl && el('div', { className: 'header-image' },
                                el('img', {
                                    src: attributes.headerImageUrl,
                                    alt: attributes.headerImageAlt,
                                    style: { width: '100%', height: 'auto', borderRadius: '8px', marginTop: '20px' }
                                })
                            )
                        ),
                        el('div', { className: 'listings-grid' },
                            attributes.listings.map(function (listing, index) {
                                return el('div', { 
                                    key: index,
                                    className: 'listing-card' 
                                },
                                        listing.iconClass && el('div', { className: 'listing-icon' },
                                            el('i', {
                                                className: listing.iconClass
                                            })
                                        ),
                                        el('h3', { className: 'listing-title' }, listing.title),
                                        el(RichText, {
                                            tagName: 'div',
                                            className: 'listing-description',
                                            value: listing.description,
                                            onChange: function (value) {
                                                updateListing(index, 'description', value);
                                            },
                                            placeholder: __('Enter description...', 'apc-theme')
                                        }),
                                        el('a', {
                                            href: listing.buttonLink,
                                            className: 'listing-button'
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

            return el('div', { className: 'featured-listing-wrapper' },
                el('div', { className: 'container' },
                    el('div', { className: 'featured-listing-header' },
                        el(RichText.Content, {
                            tagName: 'h2',
                            className: 'featured-listing-title',
                            value: attributes.title
                        }),
                        el(RichText.Content, {
                            tagName: 'p',
                            className: 'featured-listing-description',
                            value: attributes.description
                        }),
                        attributes.headerImageUrl && el('div', { className: 'header-image' },
                            el('img', {
                                src: attributes.headerImageUrl,
                                alt: attributes.headerImageAlt
                            })
                        )
                    ),
                    el('div', { className: 'listings-grid' },
                        attributes.listings.map(function (listing, index) {
                            return el('div', { 
                                key: index,
                                className: 'listing-card' 
                            },
                                listing.iconClass && el('div', { className: 'listing-icon' },
                                    el('i', {
                                        className: listing.iconClass
                                    })
                                ),
                                el('h3', { className: 'listing-title' }, listing.title),
                                el(RichText.Content, {
                                    tagName: 'div',
                                    className: 'listing-description',
                                    value: listing.description
                                }),
                                el('a', {
                                    href: listing.buttonLink,
                                    className: 'listing-button'
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