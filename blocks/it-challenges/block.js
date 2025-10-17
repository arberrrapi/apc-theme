/**
 * IT Challenges Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var RadioControl = components.RadioControl;
    var SelectControl = components.SelectControl;
    var Button = components.Button;
    var __ = i18n.__;
    
    // Get pages using WordPress data
    var useSelect = wp.data ? wp.data.useSelect : null;

    blocks.registerBlockType('apc/it-challenges', {
        title: __('IT Challenges'),
        icon: 'admin-tools',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Solving IT Challenges in every industry, every day.'
            },
            description: {
                type: 'string',
                default: 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'
            },
            mainButtonText: {
                type: 'string',
                default: 'Get Started'
            },
            mainButtonLink: {
                type: 'string',
                default: '#contact'
            },
            mainButtonPage: {
                type: 'number',
                default: 0
            },
            mainButtonType: {
                type: 'string',
                default: 'url'
            },
            challenges: {
                type: 'array',
                default: [
                    {
                        title: 'Accounting',
                        description: 'With accounting and finance practices having moved fully online, there is a growing need for technology support and management through a Managed Service Provider (MSP) with extensive experience. APC is here to meet that need.',
                        buttonText: 'Talk to an expert',
                        buttonLink: '#contact',
                        buttonType: 'url',
                        buttonPage: 0,
                        iconUrl: '',
                        iconAlt: 'Accounting'
                    },
                    {
                        title: 'Healthcare',
                        description: 'Healthcare organizations require robust, secure, and compliant IT infrastructure. Our specialized solutions ensure patient data protection while maintaining operational efficiency and regulatory compliance.',
                        buttonText: 'Talk to an expert',
                        buttonLink: '#contact',
                        buttonType: 'url',
                        buttonPage: 0,
                        iconUrl: '',
                        iconAlt: 'Healthcare'
                    },
                    {
                        title: 'Legal',
                        description: 'Law firms need secure document management, reliable communication systems, and robust backup solutions. We provide tailored IT services that protect sensitive client information.',
                        buttonText: 'Talk to an expert',
                        buttonLink: '#contact',
                        buttonType: 'url',
                        buttonPage: 0,
                        iconUrl: '',
                        iconAlt: 'Legal'
                    }
                ]
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            // Use WordPress data hooks properly
            var useSelect = wp.data.useSelect;
            
            // Fetch Pages
            var pagesData = useSelect(function(select) {
                var coreSelect = select('core');
                if (!coreSelect) return null;
                return coreSelect.getEntityRecords('postType', 'page', { 
                    per_page: -1, 
                    status: 'publish',
                    orderby: 'title',
                    order: 'asc'
                });
            }, []);
            
            // Fetch Services
            var servicesData = useSelect(function(select) {
                var coreSelect = select('core');
                if (!coreSelect) return null;
                return coreSelect.getEntityRecords('postType', 'service', { 
                    per_page: -1, 
                    status: 'publish',
                    orderby: 'title',
                    order: 'asc'
                });
            }, []);
            
            // Fetch Sectors
            var sectorsData = useSelect(function(select) {
                var coreSelect = select('core');
                if (!coreSelect) return null;
                return coreSelect.getEntityRecords('postType', 'sector', { 
                    per_page: -1, 
                    status: 'publish',
                    orderby: 'title',
                    order: 'asc'
                });
            }, []);

            // Build pages array with grouped options
            var pages = [];
            
            // Debug logging
            console.log('IT Challenges Debug:');
            console.log('Pages Data:', pagesData);
            console.log('Services Data:', servicesData);
            console.log('Sectors Data:', sectorsData);
            
            // Add pages group
            if (pagesData && Array.isArray(pagesData) && pagesData.length > 0) {
                pages.push({ label: '--- Pages ---', value: '', disabled: true });
                pagesData.forEach(function(page) {
                    pages.push({ 
                        label: page.title.rendered || 'Untitled', 
                        value: page.id 
                    });
                });
                console.log('Added ' + pagesData.length + ' pages');
            }
            
            // Add services group
            if (servicesData && Array.isArray(servicesData) && servicesData.length > 0) {
                pages.push({ label: '--- Services ---', value: '', disabled: true });
                servicesData.forEach(function(service) {
                    pages.push({ 
                        label: service.title.rendered || 'Untitled', 
                        value: service.id 
                    });
                });
                console.log('Added ' + servicesData.length + ' services');
            } else {
                console.log('No services found or services data not ready');
            }
            
            // Add sectors group
            if (sectorsData && Array.isArray(sectorsData) && sectorsData.length > 0) {
                pages.push({ label: '--- Sectors ---', value: '', disabled: true });
                sectorsData.forEach(function(sector) {
                    pages.push({ 
                        label: sector.title.rendered || 'Untitled', 
                        value: sector.id 
                    });
                });
                console.log('Added ' + sectorsData.length + ' sectors');
            } else {
                console.log('No sectors found or sectors data not ready');
            }
            
            console.log('Total options in dropdown:', pages.length);

            function updateChallenge(index, field, value) {
                var newChallenges = [...attributes.challenges];
                newChallenges[index] = { ...newChallenges[index], [field]: value };
                setAttributes({ challenges: newChallenges });
            }

            function addChallenge() {
                var newChallenges = [...attributes.challenges];
                newChallenges.push({
                    title: 'New Industry',
                    description: 'Describe the IT challenges for this industry...',
                    buttonText: 'Talk to an expert',
                    buttonLink: '#contact',
                    buttonType: 'url',
                    buttonPage: 0,
                    iconUrl: '',
                    iconAlt: 'New Industry'
                });
                setAttributes({ challenges: newChallenges });
            }

            function removeChallenge(index) {
                var newChallenges = [...attributes.challenges];
                newChallenges.splice(index, 1);
                setAttributes({ challenges: newChallenges });
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
                        el(TextareaControl, {
                            label: __('Description'),
                            value: attributes.description,
                            onChange: function (value) {
                                setAttributes({ description: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Main Button Text'),
                            value: attributes.mainButtonText,
                            onChange: function (value) {
                                setAttributes({ mainButtonText: value });
                            }
                        }),
                        el(RadioControl, {
                            label: __('Main Button Type'),
                            selected: attributes.mainButtonType,
                            options: [
                                { label: __('Custom URL'), value: 'url' },
                                { label: __('Select Page/Service/Sector'), value: 'page' }
                            ],
                            onChange: function (value) {
                                setAttributes({ mainButtonType: value });
                            }
                        }),
                        attributes.mainButtonType === 'url' && el(TextControl, {
                            label: __('Main Button URL'),
                            value: attributes.mainButtonLink,
                            onChange: function (value) {
                                setAttributes({ mainButtonLink: value });
                            }
                        }),
                        attributes.mainButtonType === 'page' && el(SelectControl, {
                            label: __('Select Page/Service/Sector for Main Button'),
                            value: attributes.mainButtonPage,
                            options: [{ label: __('Select...'), value: 0 }].concat(
                                pages.length > 0 ? pages : [{ label: __('No content found'), value: 0 }]
                            ),
                            onChange: function (value) {
                                setAttributes({ mainButtonPage: parseInt(value) });
                            }
                        })
                    ),
                    el(PanelBody, { title: __('Industry Challenges'), initialOpen: false },
                        attributes.challenges.map(function (challenge, index) {
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
                                    label: __('Industry Name'),
                                    value: challenge.title,
                                    onChange: function (value) {
                                        updateChallenge(index, 'title', value);
                                    }
                                }),
                                el(TextareaControl, {
                                    label: __('Description'),
                                    value: challenge.description,
                                    rows: 4,
                                    onChange: function (value) {
                                        updateChallenge(index, 'description', value);
                                    }
                                }),
                                el(TextControl, {
                                    label: __('Button Text'),
                                    value: challenge.buttonText,
                                    onChange: function (value) {
                                        updateChallenge(index, 'buttonText', value);
                                    }
                                }),
                                el(RadioControl, {
                                    label: __('Button Type'),
                                    selected: challenge.buttonType || 'url',
                                    options: [
                                        { label: __('Custom URL'), value: 'url' },
                                        { label: __('Select Page/Service/Sector'), value: 'page' }
                                    ],
                                    onChange: function (value) {
                                        updateChallenge(index, 'buttonType', value);
                                    }
                                }),
                                (challenge.buttonType === 'url' || !challenge.buttonType) && el(TextControl, {
                                    label: __('Button URL'),
                                    value: challenge.buttonLink,
                                    onChange: function (value) {
                                        updateChallenge(index, 'buttonLink', value);
                                    }
                                }),
                                challenge.buttonType === 'page' && el(SelectControl, {
                                    label: __('Select Page/Service/Sector'),
                                    value: challenge.buttonPage || 0,
                                    options: [{ label: __('Select...'), value: 0 }].concat(
                                        pages.length > 0 ? pages : [{ label: __('No content found'), value: 0 }]
                                    ),
                                    onChange: function (value) {
                                        updateChallenge(index, 'buttonPage', parseInt(value));
                                    }
                                }),
                                el('div', { style: { marginTop: '15px', marginBottom: '15px' } },
                                    el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, __('Icon', 'apc-theme')),
                                    challenge.iconUrl ? 
                                        el('div', {},
                                            el('img', {
                                                src: challenge.iconUrl,
                                                alt: challenge.iconAlt,
                                                style: { width: '50px', height: '50px', objectFit: 'contain', display: 'block', marginBottom: '8px' }
                                            }),
                                            el(Button, {
                                                isDestructive: true,
                                                onClick: function () { 
                                                    updateChallenge(index, 'iconUrl', '');
                                                    updateChallenge(index, 'iconAlt', '');
                                                }
                                            }, __('Remove Icon', 'apc-theme'))
                                        ) :
                                        el(MediaUpload, {
                                            onSelect: function (media) { 
                                                updateChallenge(index, 'iconUrl', media.url);
                                                updateChallenge(index, 'iconAlt', media.alt || challenge.title);
                                            },
                                            allowedTypes: ['image'],
                                            render: function (obj) {
                                                return el(Button, {
                                                    isPrimary: true,
                                                    onClick: obj.open
                                                }, __('Select Icon', 'apc-theme'));
                                            }
                                        })
                                ),
                                el(TextControl, {
                                    label: __('Icon Alt Text'),
                                    value: challenge.iconAlt || challenge.title,
                                    onChange: function (value) {
                                        updateChallenge(index, 'iconAlt', value);
                                    }
                                }),
                                el(Button, {
                                    isDestructive: true,
                                    onClick: function () {
                                        removeChallenge(index);
                                    },
                                    style: { marginTop: '10px' }
                                }, __('Remove Challenge'))
                            );
                        }),
                        el(Button, {
                            isPrimary: true,
                            onClick: addChallenge,
                            style: { marginTop: '15px' }
                        }, __('Add Challenge'))
                    )
                ),
                el('div', { 
                    className: 'apc-it-challenges-preview',
                    style: {
                        padding: '20px',
                        backgroundColor: '#f8f9fa',
                        borderRadius: '10px',
                        border: '2px dashed #7055EE'
                    }
                },
                    el('h3', { 
                        style: { 
                            color: '#7055EE', 
                            fontSize: '24px',
                            marginBottom: '10px'
                        } 
                    }, attributes.title || __('Solving IT Challenges in every industry, every day.')),
                    el('p', { 
                        style: { 
                            fontSize: '16px', 
                            marginBottom: '15px' 
                        } 
                    }, attributes.description || __('From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.')),
                    ((attributes.mainButtonType === 'url' && attributes.mainButtonLink && attributes.mainButtonLink !== '#') || 
                     (attributes.mainButtonType === 'page' && attributes.mainButtonPage > 0) ||
                     (!attributes.mainButtonType && attributes.mainButtonLink && attributes.mainButtonLink !== '#')) && 
                    el('a', {
                        href: '#',
                        onClick: function(e) { e.preventDefault(); },
                        className: 'challenge-btn main-btn',
                        style: {
                            display: 'inline-block',
                            padding: '10px 20px',
                            backgroundColor: '#7055EE',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '25px',
                            fontSize: '14px',
                            marginBottom: '20px'
                        }
                    }, attributes.mainButtonText || __('Get Started')),
                    el('div', { 
                        style: { 
                            display: 'grid',
                            gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
                            gap: '15px',
                            marginTop: '20px'
                        }
                    },
                        attributes.challenges.map(function (challenge, index) {
                            return el('div', {
                                key: index,
                                style: {
                                    padding: '15px',
                                    backgroundColor: 'white',
                                    borderRadius: '8px',
                                    border: '1px solid #ddd'
                                }
                            },
                                challenge.iconUrl && el('div', {
                                    style: {
                                        textAlign: 'center',
                                        marginBottom: '10px'
                                    }
                                },
                                    el('img', {
                                        src: challenge.iconUrl,
                                        alt: challenge.iconAlt || challenge.title,
                                        style: {
                                            width: '40px',
                                            height: '40px',
                                            objectFit: 'contain'
                                        }
                                    })
                                ),
                                el('h5', {
                                    style: {
                                        margin: '0 0 8px 0',
                                        fontSize: '16px',
                                        fontWeight: '600'
                                    }
                                }, challenge.title),
                                el('p', {
                                    style: {
                                        fontSize: '12px',
                                        color: '#666',
                                        margin: '0 0 8px 0',
                                        lineHeight: '1.4'
                                    }
                                }, challenge.description.substring(0, 80) + '...'),
                                ((challenge.buttonType === 'url' && challenge.buttonLink && challenge.buttonLink !== '#') || 
                                 (challenge.buttonType === 'page' && challenge.buttonPage > 0) ||
                                 (!challenge.buttonType && challenge.buttonLink && challenge.buttonLink !== '#')) && 
                                el('span', {
                                    style: {
                                        fontSize: '11px',
                                        backgroundColor: '#7055EE',
                                        color: 'white',
                                        padding: '4px 8px',
                                        borderRadius: '12px'
                                    }
                                }, challenge.buttonText)
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