(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var createElement = wp.element.createElement;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var MediaUpload = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;
    var Button = wp.components.Button;

    registerBlockType('apc/what-we-do', {
        title: 'What We Do',
        icon: 'lightbulb',
        category: 'apc-blocks',
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onImageSelect(media) {
                setAttributes({ imageUrl: media.url });
            }

            function createImageUpload(imageUrl, onSelect) {
                return createElement(
                    MediaUploadCheck,
                    {},
                    createElement(
                        MediaUpload,
                        {
                            onSelect: onSelect,
                            allowedTypes: ['image'],
                            value: imageUrl,
                            render: function(obj) {
                                return createElement(
                                    'div',
                                    { className: 'editor-image-upload' },
                                    imageUrl ? [
                                        createElement('img', {
                                            key: 'image',
                                            src: imageUrl,
                                            alt: 'What We Do'
                                        }),
                                        createElement(
                                            Button,
                                            {
                                                key: 'button',
                                                onClick: obj.open,
                                                isSecondary: true
                                            },
                                            'Replace Image'
                                        )
                                    ] : createElement(
                                        Button,
                                        {
                                            onClick: obj.open,
                                            isPrimary: true
                                        },
                                        'Upload Image'
                                    )
                                );
                            }
                        }
                    )
                );
            }

            return [
                createElement(
                    InspectorControls,
                    { key: 'inspector' },
                    createElement(
                        PanelBody,
                        { title: 'Main Section Settings', initialOpen: true },
                        createElement(TextControl, {
                            label: 'Section Label',
                            value: attributes.label,
                            onChange: function(value) {
                                setAttributes({ label: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Section Title',
                            value: attributes.title,
                            onChange: function(value) {
                                setAttributes({ title: value });
                            }
                        }),
                        createImageUpload(attributes.imageUrl, onImageSelect)
                    ),
                    createElement(
                        PanelBody,
                        { title: 'Card 1 Settings', initialOpen: false },
                        createElement(TextControl, {
                            label: 'Icon Class (e.g., fa-solid fa-users)',
                            value: attributes.card1Icon,
                            onChange: function(value) {
                                setAttributes({ card1Icon: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Title',
                            value: attributes.card1Title,
                            onChange: function(value) {
                                setAttributes({ card1Title: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Text',
                            value: attributes.card1Text,
                            onChange: function(value) {
                                setAttributes({ card1Text: value });
                            }
                        })
                    ),
                    createElement(
                        PanelBody,
                        { title: 'Card 2 Settings', initialOpen: false },
                        createElement(TextControl, {
                            label: 'Icon Class (e.g., fa-solid fa-shield-halved)',
                            value: attributes.card2Icon,
                            onChange: function(value) {
                                setAttributes({ card2Icon: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Title',
                            value: attributes.card2Title,
                            onChange: function(value) {
                                setAttributes({ card2Title: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Text',
                            value: attributes.card2Text,
                            onChange: function(value) {
                                setAttributes({ card2Text: value });
                            }
                        })
                    ),
                    createElement(
                        PanelBody,
                        { title: 'Card 3 Settings', initialOpen: false },
                        createElement(TextControl, {
                            label: 'Icon Class (e.g., fa-solid fa-rocket)',
                            value: attributes.card3Icon,
                            onChange: function(value) {
                                setAttributes({ card3Icon: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Title',
                            value: attributes.card3Title,
                            onChange: function(value) {
                                setAttributes({ card3Title: value });
                            }
                        }),
                        createElement(TextControl, {
                            label: 'Card Text',
                            value: attributes.card3Text,
                            onChange: function(value) {
                                setAttributes({ card3Text: value });
                            }
                        })
                    )
                ),
                createElement(
                    'div',
                    { 
                        key: 'preview',
                        className: 'wp-block-apc-what-we-do',
                        style: { 
                            padding: '20px', 
                            background: '#f0f0f0',
                            borderRadius: '8px'
                        }
                    },
                    createElement('h3', {}, 'What We Do Block'),
                    createElement('p', { style: { marginBottom: '10px' } }, 
                        createElement('strong', {}, 'Label: '), attributes.label
                    ),
                    createElement('p', { style: { marginBottom: '10px' } }, 
                        createElement('strong', {}, 'Title: '), attributes.title
                    ),
                    createElement('p', { style: { marginBottom: '15px', fontSize: '12px', color: '#666' } }, 
                        'Configure cards in the block settings panel →'
                    ),
                    attributes.imageUrl && createElement('img', {
                        src: attributes.imageUrl,
                        alt: 'Preview',
                        style: { maxWidth: '200px', display: 'block', marginTop: '10px' }
                    })
                )
            ];
        },

        save: function() {
            return null; // Server-side rendering
        }
    });
})(window.wp);
