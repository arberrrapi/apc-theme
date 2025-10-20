(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var createElement = wp.element.createElement;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var RadioControl = wp.components.RadioControl;
    var SelectControl = wp.components.SelectControl;

    registerBlockType('apc/custom-cta', {
        title: 'Custom CTA',
        icon: 'megaphone',
        category: 'apc-blocks',
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            // Use WordPress data hooks to fetch pages, services, and sectors
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

            // Build options array with grouped items
            var pageOptions = [];
            
            if (pagesData && Array.isArray(pagesData) && pagesData.length > 0) {
                pageOptions.push({ label: '--- Pages ---', value: '', disabled: true });
                pagesData.forEach(function(page) {
                    pageOptions.push({ 
                        label: page.title.rendered || 'Untitled', 
                        value: page.id 
                    });
                });
            }
            
            if (servicesData && Array.isArray(servicesData) && servicesData.length > 0) {
                pageOptions.push({ label: '--- Services ---', value: '', disabled: true });
                servicesData.forEach(function(service) {
                    pageOptions.push({ 
                        label: service.title.rendered || 'Untitled', 
                        value: service.id 
                    });
                });
            }
            
            if (sectorsData && Array.isArray(sectorsData) && sectorsData.length > 0) {
                pageOptions.push({ label: '--- Sectors ---', value: '', disabled: true });
                sectorsData.forEach(function(sector) {
                    pageOptions.push({ 
                        label: sector.title.rendered || 'Untitled', 
                        value: sector.id 
                    });
                });
            }

            return [
                createElement(
                    InspectorControls,
                    { key: 'inspector' },
                    createElement(
                        PanelBody,
                        { title: 'CTA Settings', initialOpen: true },
                        createElement(TextControl, {
                            label: 'Title',
                            value: attributes.title,
                            onChange: function(value) {
                                setAttributes({ title: value });
                            },
                            help: 'The main text displayed on the left side'
                        }),
                        createElement(TextControl, {
                            label: 'Button Text',
                            value: attributes.buttonText,
                            onChange: function(value) {
                                setAttributes({ buttonText: value });
                            }
                        }),
                        createElement(RadioControl, {
                            label: 'Button Link Type',
                            selected: attributes.buttonType,
                            options: [
                                { label: 'Custom URL', value: 'url' },
                                { label: 'Select Page/Service/Sector', value: 'page' }
                            ],
                            onChange: function(value) {
                                setAttributes({ buttonType: value });
                            }
                        }),
                        attributes.buttonType === 'url' && createElement(TextControl, {
                            label: 'Button URL',
                            value: attributes.buttonLink,
                            onChange: function(value) {
                                setAttributes({ buttonLink: value });
                            },
                            placeholder: '#contact'
                        }),
                        attributes.buttonType === 'page' && createElement(SelectControl, {
                            label: 'Select Page/Service/Sector',
                            value: attributes.buttonPage,
                            options: [{ label: 'Select...', value: 0 }].concat(
                                pageOptions.length > 0 ? pageOptions : [{ label: 'No content found', value: 0 }]
                            ),
                            onChange: function(value) {
                                setAttributes({ buttonPage: parseInt(value) });
                            }
                        })
                    )
                ),
                createElement(
                    'div',
                    { 
                        key: 'preview',
                        className: 'wp-block-apc-custom-cta',
                        style: { 
                            padding: '20px',
                            background: 'linear-gradient(135deg, #47267D, #2119d4)',
                            borderRadius: '25px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'space-between',
                            gap: '20px',
                            minHeight: '150px'
                        }
                    },
                    createElement(
                        'h2',
                        { 
                            style: { 
                                color: 'white',
                                fontSize: '32px',
                                margin: '0',
                                flex: '1'
                            }
                        },
                        attributes.title || 'Ready to transform your IT infrastructure?'
                    ),
                    createElement(
                        'div',
                        {
                            style: {
                                padding: '12px 30px',
                                background: 'transparent',
                                border: '2px solid white',
                                borderRadius: '25px',
                                color: 'white',
                                fontSize: '18px',
                                fontWeight: '600',
                                whiteSpace: 'nowrap'
                            }
                        },
                        attributes.buttonText || 'Get Started'
                    )
                )
            ];
        },

        save: function() {
            return null; // Server-side rendering
        }
    });
})(window.wp);
