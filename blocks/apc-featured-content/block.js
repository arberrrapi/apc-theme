/**
 * APC Featured Content Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var MediaUploadCheck = editor.MediaUploadCheck;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var ToggleControl = components.ToggleControl;
    var RadioControl = components.RadioControl;
    var SelectControl = components.SelectControl;
    var Button = components.Button;
    var __ = i18n.__;
    
    // WordPress data for pages
    var useSelect = wp.data ? wp.data.useSelect : null;

    blocks.registerBlockType('apc/featured-content', {
        title: __('APC Featured Content'),
        icon: 'welcome-view-site',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Featured Content Title'
            },
            description: {
                type: 'string',
                default: 'Add your description here. This content will be displayed alongside your featured image.'
            },
            buttonText: {
                type: 'string',
                default: 'Learn More'
            },
            buttonLink: {
                type: 'string',
                default: ''
            },
            buttonPage: {
                type: 'number',
                default: 0
            },
            buttonType: {
                type: 'string',
                default: 'url'
            },
            imageUrl: {
                type: 'string',
                default: ''
            },
            imageAlt: {
                type: 'string',
                default: ''
            },
            reverseColumns: {
                type: 'boolean',
                default: false
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onSelectImage(media) {
                setAttributes({
                    imageUrl: media.url,
                    imageAlt: media.alt || ''
                });
            }

            function removeImage() {
                setAttributes({
                    imageUrl: '',
                    imageAlt: ''
                });
            }

            return [
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Content Settings') },
                        el(TextControl, {
                            label: __('Title'),
                            value: attributes.title,
                            onChange: function (value) {
                                setAttributes({ title: value });
                            }
                        }),
                        el(TextareaControl, {
                            label: __('Description'),
                            value: attributes.description,
                            rows: 4,
                            onChange: function (value) {
                                setAttributes({ description: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Button Text'),
                            value: attributes.buttonText,
                            onChange: function (value) {
                                setAttributes({ buttonText: value });
                            }
                        }),
                        el(RadioControl, {
                            label: __('Button Type'),
                            selected: attributes.buttonType,
                            options: [
                                { label: __('Custom URL'), value: 'url' },
                                { label: __('Select Page'), value: 'page' }
                            ],
                            onChange: function (value) {
                                setAttributes({ buttonType: value });
                            }
                        }),
                        attributes.buttonType === 'url' && el(TextControl, {
                            label: __('Button URL'),
                            value: attributes.buttonLink,
                            onChange: function (value) {
                                setAttributes({ buttonLink: value });
                            }
                        }),
                        attributes.buttonType === 'page' && el('div', {}, 
                            el('label', { 
                                style: { 
                                    display: 'block', 
                                    marginBottom: '8px',
                                    fontSize: '11px',
                                    fontWeight: '500',
                                    textTransform: 'uppercase',
                                    color: '#1e1e1e'
                                } 
                            }, __('Select Page')),
                            el('select', {
                                value: attributes.buttonPage,
                                onChange: function (event) {
                                    setAttributes({ buttonPage: parseInt(event.target.value) });
                                },
                                style: {
                                    width: '100%',
                                    padding: '8px',
                                    border: '1px solid #757575',
                                    borderRadius: '2px'
                                }
                            },
                                el('option', { value: 0 }, __('Select a page...')),
                                // Pages will be loaded dynamically
                                wp.data && wp.data.select('core').getEntityRecords('postType', 'page', { per_page: -1, status: 'publish' }) &&
                                wp.data.select('core').getEntityRecords('postType', 'page', { per_page: -1, status: 'publish' }).map(function(page) {
                                    return el('option', { key: page.id, value: page.id }, page.title.rendered);
                                })
                            )
                        )
                    ),
                    el(PanelBody, { title: __('Layout Settings'), initialOpen: false },
                        el(ToggleControl, {
                            label: __('Reverse Columns (Image on Right)'),
                            checked: attributes.reverseColumns,
                            onChange: function (value) {
                                setAttributes({ reverseColumns: value });
                            }
                        })
                    ),
                    el(PanelBody, { title: __('Image Settings'), initialOpen: false },
                        attributes.imageUrl && el(TextControl, {
                            label: __('Image Alt Text'),
                            value: attributes.imageAlt,
                            onChange: function (value) {
                                setAttributes({ imageAlt: value });
                            }
                        })
                    )
                ),

                el('div', { 
                    className: 'apc-featured-content-preview',
                    style: {
                        padding: '20px',
                        backgroundColor: 'white',
                        borderRadius: '25px',
                        border: '2px solid #2119d4',
                        margin: '20px 0'
                    }
                },
                    el('div', {
                        style: {
                            display: 'grid',
                            gridTemplateColumns: '1fr 1fr',
                            gap: '40px',
                            alignItems: 'stretch',
                            flexDirection: attributes.reverseColumns ? 'row-reverse' : 'row'
                        }
                    },
                        // Content Column
                        el('div', {
                            style: {
                                display: 'flex',
                                flexDirection: 'column',
                                justifyContent: 'space-between',
                                order: attributes.reverseColumns ? 2 : 1
                            }
                        },
                            // Title at top
                            el('div', {},
                                el('h3', {
                                    style: {
                                        color: '#2119d4',
                                        fontSize: '32px',
                                        fontWeight: '700',
                                        marginBottom: '20px',
                                        marginTop: '0'
                                    }
                                }, attributes.title || __('Featured Content Title'))
                            ),
                            // Description and Button at bottom
                            el('div', {},
                                el('p', {
                                    style: {
                                        fontSize: '18px',
                                        color: '#333',
                                        lineHeight: '1.6',
                                        marginBottom: '30px'
                                    }
                                }, attributes.description || __('Add your description here. This content will be displayed alongside your featured image.')),
                                ((attributes.buttonType === 'url' && attributes.buttonLink && attributes.buttonLink !== '') || 
                                 (attributes.buttonType === 'page' && attributes.buttonPage > 0)) && el('a', {
                                    href: '#',
                                    onClick: function(e) { e.preventDefault(); },
                                    style: {
                                        display: 'inline-block',
                                        padding: '15px 30px',
                                        backgroundColor: '#2119d4',
                                        color: 'white',
                                        textDecoration: 'none',
                                        borderRadius: '50px',
                                        fontSize: '16px',
                                        fontWeight: '600',
                                        border: '2px solid transparent',
                                        background: 'linear-gradient(white, white) padding-box, linear-gradient(135deg, #2119d4, #2119d4) border-box'
                                    }
                                }, attributes.buttonText || __('Learn More'))
                            )
                        ),

                        // Image Column
                        el('div', {
                            style: {
                                order: attributes.reverseColumns ? 1 : 2
                            }
                        },
                            !attributes.imageUrl ? 
                                el(MediaUploadCheck, {},
                                    el(MediaUpload, {
                                        onSelect: onSelectImage,
                                        allowedTypes: ['image'],
                                        value: attributes.imageUrl,
                                        render: function (obj) {
                                            return el(Button, {
                                                className: 'button button-large',
                                                onClick: obj.open,
                                                style: {
                                                    width: '100%',
                                                    height: '300px',
                                                    display: 'flex',
                                                    alignItems: 'center',
                                                    justifyContent: 'center',
                                                    backgroundColor: '#f0f0f0',
                                                    border: '2px dashed #ccc',
                                                    borderRadius: '25px'
                                                }
                                            }, __('Select Image'));
                                        }
                                    })
                                ) :
                                el('div', {
                                    style: {
                                        position: 'relative'
                                    }
                                },
                                    el('img', {
                                        src: attributes.imageUrl,
                                        alt: attributes.imageAlt,
                                        style: {
                                            width: '100%',
                                            height: '300px',
                                            objectFit: 'cover',
                                            borderRadius: '25px'
                                        }
                                    }),
                                    el(Button, {
                                        className: 'button',
                                        onClick: removeImage,
                                        style: {
                                            position: 'absolute',
                                            top: '10px',
                                            right: '10px',
                                            backgroundColor: 'rgba(255,255,255,0.9)'
                                        }
                                    }, __('Remove'))
                                )
                        )
                    )
                )
            ];
        },

        save: function () {
            return null; // Server-side rendering
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.i18n
);