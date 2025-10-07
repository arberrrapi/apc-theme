/**
 * APC Feature Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var BlockControls = editor.BlockControls;
    var AlignmentToolbar = editor.AlignmentToolbar;
    var MediaUpload = editor.MediaUpload;
    var MediaUploadCheck = editor.MediaUploadCheck;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var Button = components.Button;
    var __ = i18n.__;

    blocks.registerBlockType('apc/feature-block', {
        title: __('APC Feature Block'),
        icon: 'star-filled',
        category: 'apc-blocks',
        attributes: {
            iconUrl: {
                type: 'string',
                default: ''
            },
            iconAlt: {
                type: 'string',
                default: ''
            },
            content: {
                type: 'string',
                source: 'html',
                selector: '.feature-content',
                default: '<p>Add your feature description here. You can include <strong>bold text</strong>, <em>italic text</em>, and <a href="#">links</a>.</p>'
            },
            alignment: {
                type: 'string',
                default: 'center'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onSelectImage(media) {
                setAttributes({
                    iconUrl: media.url,
                    iconAlt: media.alt || ''
                });
            }

            function removeImage() {
                setAttributes({
                    iconUrl: '',
                    iconAlt: ''
                });
            }

            function onChangeContent(content) {
                setAttributes({ content: content });
            }

            return [
                el(BlockControls, {},
                    el(AlignmentToolbar, {
                        value: attributes.alignment,
                        onChange: function (alignment) {
                            setAttributes({ alignment: alignment });
                        }
                    })
                ),

                el(InspectorControls, {},
                    el(PanelBody, { title: __('Icon Settings') },
                        attributes.iconUrl && el(TextControl, {
                            label: __('Icon Alt Text'),
                            value: attributes.iconAlt,
                            onChange: function (value) {
                                setAttributes({ iconAlt: value });
                            }
                        })
                    )
                ),

                el('div', { 
                    className: 'apc-feature-block-preview',
                    style: {
                        padding: '30px',
                        backgroundColor: '#f8f9fa',
                        borderRadius: '10px',
                        border: '2px dashed #7055EE',
                        textAlign: attributes.alignment || 'center',
                        maxWidth: '400px',
                        margin: '20px auto'
                    }
                },
                    // Icon Section
                    el('div', {
                        style: {
                            marginBottom: '30px'
                        }
                    },
                        !attributes.iconUrl ? 
                            el(MediaUploadCheck, {},
                                el(MediaUpload, {
                                    onSelect: onSelectImage,
                                    allowedTypes: ['image'],
                                    value: attributes.iconUrl,
                                    render: function (obj) {
                                        return el(Button, {
                                            className: 'button button-large',
                                            onClick: obj.open,
                                            style: {
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                width: '100px',
                                                height: '100px',
                                                backgroundColor: '#f0f0f0',
                                                border: '2px dashed #ccc',
                                                borderRadius: '10px',
                                                margin: '0 auto',
                                                flexDirection: 'column',
                                                fontSize: '12px'
                                            }
                                        }, 
                                            el('span', { style: { fontSize: '24px', marginBottom: '8px' } }, '📎'),
                                            __('Select Icon')
                                        );
                                    }
                                })
                            ) :
                            el('div', {
                                style: {
                                    position: 'relative',
                                    display: 'inline-block'
                                }
                            },
                                el('img', {
                                    src: attributes.iconUrl,
                                    alt: attributes.iconAlt,
                                    style: {
                                        width: '80px',
                                        height: '80px',
                                        objectFit: 'contain',
                                        borderRadius: '10px'
                                    }
                                }),
                                el(Button, {
                                    className: 'button',
                                    onClick: removeImage,
                                    style: {
                                        position: 'absolute',
                                        top: '-10px',
                                        right: '-10px',
                                        backgroundColor: '#dc3545',
                                        color: 'white',
                                        border: 'none',
                                        borderRadius: '50%',
                                        width: '25px',
                                        height: '25px',
                                        fontSize: '12px',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center'
                                    }
                                }, '×')
                            )
                    ),

                    // Content Section
                    el('div', {
                        className: 'feature-content-editor',
                        style: {
                            textAlign: attributes.alignment || 'center'
                        }
                    },
                        el(RichText, {
                            tagName: 'div',
                            className: 'feature-content',
                            value: attributes.content,
                            onChange: onChangeContent,
                            placeholder: __('Add your feature description here...'),
                            multiline: 'p',
                            style: {
                                minHeight: '100px',
                                padding: '15px',
                                backgroundColor: 'white',
                                border: '1px solid #ddd',
                                borderRadius: '8px',
                                fontSize: '16px',
                                lineHeight: '1.6'
                            }
                        })
                    ),

                    // Helper Text
                    el('p', {
                        style: {
                            fontSize: '12px',
                            color: '#666',
                            marginTop: '15px',
                            fontStyle: 'italic'
                        }
                    }, __('Use the toolbar above to format text and add links'))
                )
            ];
        },

        save: function (props) {
            var attributes = props.attributes;
            
            return el('div', { 
                className: 'apc-feature-block',
                style: {
                    textAlign: attributes.alignment || 'center'
                }
            },
                // Icon
                attributes.iconUrl && el('div', { className: 'feature-icon' },
                    el('img', {
                        src: attributes.iconUrl,
                        alt: attributes.iconAlt
                    })
                ),
                // Content
                el(RichText.Content, {
                    tagName: 'div',
                    className: 'feature-content',
                    value: attributes.content
                })
            );
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.i18n
);