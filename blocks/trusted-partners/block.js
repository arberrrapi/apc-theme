/**
 * Trusted Partners Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var Button = components.Button;
    var __ = i18n.__;

    blocks.registerBlockType('apc/trusted-partners', {
        title: __('Trusted Partners'),
        icon: 'admin-users',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Trusted partners'
            },
            subtitle: {
                type: 'string',
                default: 'Working with the best'
            },
            backgroundImage: {
                type: 'string',
                default: ''
            },
            partners: {
                type: 'array',
                default: [
                    {
                        name: 'Microsoft',
                        logo: 'microsoft.png',
                        url: ''
                    },
                    {
                        name: 'Cisco',
                        logo: 'cisco.png',
                        url: ''
                    },
                    {
                        name: 'SonicWall',
                        logo: 'sonicwal.png',
                        url: ''
                    },
                    {
                        name: 'Fortinet',
                        logo: 'fortinet.png',
                        url: ''
                    },
                    {
                        name: 'Azure',
                        logo: 'azure.png',
                        url: ''
                    },
                    {
                        name: 'dell',
                        logo: 'dell.png',
                        url: ''
                    },
                    {
                        name: 'lenovo',
                        logo: 'lenovo.png',
                        url: ''
                    },
                    {
                        name: 'Sentinel',
                        logo: 'sentinel.png',
                        url: ''
                    },
                    {
                        name: 'n-able',
                        logo: 'n-able.png',
                        url: ''
                    },
                    {
                        name: '1password',
                        logo: '1password.png',
                        url: ''
                    },
                    {
                        name: 'knowbe4',
                        logo: 'knowbe4.png',
                        url: ''
                    }
                ]
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function updatePartner(index, field, value) {
                var newPartners = [...attributes.partners];
                newPartners[index] = { ...newPartners[index], [field]: value };
                setAttributes({ partners: newPartners });
            }

            function addPartner() {
                var newPartners = [...attributes.partners];
                newPartners.push({
                    name: 'New Partner',
                    logo: '',
                    url: ''
                });
                setAttributes({ partners: newPartners });
            }

            function removePartner(index) {
                var newPartners = [...attributes.partners];
                newPartners.splice(index, 1);
                setAttributes({ partners: newPartners });
            }

            return [
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Settings') },
                        el(TextControl, {
                            label: __('Title'),
                            value: attributes.title,
                            onChange: function (value) {
                                setAttributes({ title: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Subtitle'),
                            value: attributes.subtitle,
                            onChange: function (value) {
                                setAttributes({ subtitle: value });
                            }
                        }),
                        el('div', {
                            style: { marginBottom: '15px' }
                        },
                            el('label', {
                                style: {
                                    display: 'block',
                                    marginBottom: '8px',
                                    fontWeight: '600'
                                }
                            }, __('Background Image')),
                            el(MediaUpload, {
                                onSelect: function (media) {
                                    setAttributes({ backgroundImage: media.url });
                                },
                                allowedTypes: ['image'],
                                value: attributes.backgroundImage,
                                render: function (obj) {
                                    return el(Button, {
                                        className: attributes.backgroundImage ? 'editor-post-featured-image__preview' : 'editor-post-featured-image__toggle',
                                        onClick: obj.open
                                    }, attributes.backgroundImage ? 
                                        el('img', { 
                                            src: attributes.backgroundImage,
                                            style: { maxWidth: '100%', height: 'auto' }
                                        }) : 
                                        __('Set Background Image')
                                    );
                                }
                            }),
                            attributes.backgroundImage && el(Button, {
                                onClick: function () {
                                    setAttributes({ backgroundImage: '' });
                                },
                                isDestructive: true,
                                isSmall: true,
                                style: { marginTop: '8px' }
                            }, __('Remove Background'))
                        )
                    ),
                    el(PanelBody, { title: __('Partners'), initialOpen: false },
                        attributes.partners.map(function (partner, index) {
                            return el('div', {
                                key: index,
                                style: {
                                    marginBottom: '20px',
                                    padding: '15px',
                                    border: '1px solid #ddd',
                                    borderRadius: '5px'
                                }
                            },
                                el(TextControl, {
                                    label: __('Partner Name'),
                                    value: partner.name,
                                    onChange: function (value) {
                                        updatePartner(index, 'name', value);
                                    }
                                }),
                                el(TextControl, {
                                    label: __('Logo Filename'),
                                    help: __('Enter the filename of the logo (e.g., microsoft.png)'),
                                    value: partner.logo,
                                    onChange: function (value) {
                                        updatePartner(index, 'logo', value);
                                    }
                                }),
                                el(TextControl, {
                                    label: __('Partner URL (optional)'),
                                    value: partner.url,
                                    onChange: function (value) {
                                        updatePartner(index, 'url', value);
                                    }
                                }),
                                el(Button, {
                                    isDestructive: true,
                                    onClick: function () {
                                        removePartner(index);
                                    },
                                    style: { marginTop: '10px' }
                                }, __('Remove Partner'))
                            );
                        }),
                        el(Button, {
                            isPrimary: true,
                            onClick: addPartner,
                            style: { marginTop: '15px' }
                        }, __('Add Partner'))
                    )
                ),
                el('div', {
                    className: 'apc-trusted-partners-preview',
                    style: {
                        padding: '20px',
                        backgroundColor: '#f8f9fa',
                        borderRadius: '10px',
                        border: '2px dashed #2119d4',
                        backgroundImage: attributes.backgroundImage ? 'url(' + attributes.backgroundImage + ')' : 'none',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center'
                    }
                },
                    el('h3', {
                        style: {
                            color: '#2119d4',
                            fontSize: '24px',
                            marginBottom: '10px',
                            textAlign: 'center'
                        }
                    }, attributes.title || __('Trusted partners')),
                    el('p', {
                        style: {
                            fontSize: '16px',
                            marginBottom: '20px',
                            textAlign: 'center',
                            fontWeight: '600'
                        }
                    }, attributes.subtitle || __('Working with the best')),
                    el('div', {
                        style: {
                            display: 'grid',
                            gridTemplateColumns: 'repeat(auto-fit, minmax(100px, 1fr))',
                            gap: '15px',
                            marginTop: '20px'
                        }
                    },
                        attributes.partners.map(function (partner, index) {
                            return el('div', {
                                key: index,
                                style: {
                                    padding: '10px',
                                    backgroundColor: 'rgba(255,255,255,0.9)',
                                    borderRadius: '8px',
                                    textAlign: 'center',
                                    fontSize: '12px'
                                }
                            },
                                el('div', {
                                    style: {
                                        width: '60px',
                                        height: '40px',
                                        backgroundColor: '#ddd',
                                        margin: '0 auto 5px auto',
                                        borderRadius: '4px',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        fontSize: '10px'
                                    }
                                }, 'IMG'),
                                partner.name
                            );
                        })
                    )
                )
            ];
        },
        save: function () {
            // Return null since this is a dynamic block
            return null;
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.i18n
);