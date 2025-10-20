/**
 * APC Image Block
 */
(function (blocks, element, editor, components, i18n, data) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var MediaUpload = editor.MediaUpload;
    var MediaUploadCheck = editor.MediaUploadCheck;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var Button = components.Button;
    var TextControl = components.TextControl;
    var __ = i18n.__;
    var select = data.select;

    blocks.registerBlockType('apc/image', {
        title: __('APC Image'),
        icon: 'format-image',
        category: 'apc-blocks',
        attributes: {
            imageId: {
                type: 'number',
                default: 0
            },
            imageUrl: {
                type: 'string',
                default: ''
            },
            imageAlt: {
                type: 'string',
                default: ''
            },
            imageCaption: {
                type: 'string',
                default: ''
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onSelectImage(media) {
                setAttributes({
                    imageId: media.id,
                    imageUrl: media.url,
                    imageAlt: media.alt || ''
                });
            }

            function onRemoveImage() {
                setAttributes({
                    imageId: 0,
                    imageUrl: '',
                    imageAlt: ''
                });
            }

            return el('div', { className: 'apc-image-block-editor' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Image Settings', 'apc-theme'), initialOpen: true },
                        el(TextControl, {
                            label: __('Alt Text', 'apc-theme'),
                            value: attributes.imageAlt,
                            onChange: function (value) {
                                setAttributes({ imageAlt: value });
                            },
                            help: __('Describe the image for screen readers', 'apc-theme')
                        })
                    )
                ),

                // Image Upload/Display
                el('div', { className: 'apc-image-container' },
                    !attributes.imageUrl ?
                        // Upload button when no image
                        el(MediaUploadCheck, {},
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                value: attributes.imageId,
                                render: function (obj) {
                                    return el('div', { className: 'apc-image-placeholder' },
                                        el('div', { className: 'placeholder-content' },
                                            el('i', { className: 'dashicons dashicons-format-image', style: { fontSize: '48px', marginBottom: '10px' } }),
                                            el('h3', {}, __('APC Image Block', 'apc-theme')),
                                            el('p', {}, __('Upload an image that will be displayed with custom APC styling', 'apc-theme')),
                                            el(Button, {
                                                onClick: obj.open,
                                                className: 'button button-large',
                                                style: { 
                                                    background: '#2119d4',
                                                    color: 'white',
                                                    border: 'none',
                                                    borderRadius: '8px',
                                                    padding: '12px 24px'
                                                }
                                            }, __('Select Image', 'apc-theme'))
                                        )
                                    );
                                }
                            })
                        )
                        :
                        // Image preview when image is selected
                        el('div', { className: 'apc-image-preview' },
                            el('div', { className: 'apc-image-wrapper' },
                                el('img', {
                                    src: attributes.imageUrl,
                                    alt: attributes.imageAlt,
                                    style: {
                                        width: '100%',
                                        maxHeight: '600px',
                                        objectFit: 'cover',
                                        borderRadius: '25px',
                                        display: 'block'
                                    }
                                }),
                                
                                // Image controls overlay
                                el('div', { className: 'image-controls-overlay' },
                                    el('div', { className: 'image-controls' },
                                        el(MediaUploadCheck, {},
                                            el(MediaUpload, {
                                                onSelect: onSelectImage,
                                                allowedTypes: ['image'],
                                                value: attributes.imageId,
                                                render: function (obj) {
                                                    return el(Button, {
                                                        onClick: obj.open,
                                                        className: 'button button-secondary',
                                                        style: { marginRight: '10px' }
                                                    }, __('Replace', 'apc-theme'));
                                                }
                                            })
                                        ),
                                        el(Button, {
                                            onClick: onRemoveImage,
                                            className: 'button button-secondary',
                                            isDestructive: true
                                        }, __('Remove', 'apc-theme'))
                                    )
                                )
                            ),
                            
                            // Caption input
                            el('div', { className: 'apc-image-caption-input' },
                                el(RichText, {
                                    tagName: 'figcaption',
                                    placeholder: __('Add image caption...', 'apc-theme'),
                                    value: attributes.imageCaption,
                                    onChange: function (value) {
                                        setAttributes({ imageCaption: value });
                                    },
                                    style: {
                                        textAlign: 'center',
                                        marginTop: '15px',
                                        fontStyle: 'italic',
                                        color: '#666'
                                    }
                                })
                            )
                        )
                )
            );
        },

        save: function (props) {
            // Return null because we're using PHP render
            return null;
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.i18n,
    window.wp.data
);