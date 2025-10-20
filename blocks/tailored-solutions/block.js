/**
 * Tailored Solutions Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var RangeControl = components.RangeControl;
    var __ = i18n.__;

    blocks.registerBlockType('apc/tailored-solutions', {
        title: __('Tailored Solutions'),
        icon: 'admin-tools',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Tailored solutions, for every problem'
            },
            description: {
                type: 'string',
                default: 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'
            },
            maxServices: {
                type: 'number',
                default: 8
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

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
                        el(RangeControl, {
                            label: __('Maximum Services'),
                            value: attributes.maxServices,
                            onChange: function (value) {
                                setAttributes({ maxServices: value });
                            },
                            min: 1,
                            max: 20
                        })
                    )
                ),
                el('div', { 
                    className: 'apc-tailored-solutions-preview',
                    style: {
                        padding: '20px',
                        backgroundColor: '#f8f9fa',
                        borderRadius: '10px',
                        border: '2px dashed #2119d4'
                    }
                },
                    el('h3', { 
                        style: { 
                            color: '#2119d4', 
                            fontSize: '24px',
                            marginBottom: '10px'
                        } 
                    }, attributes.title || __('Tailored solutions, for every problem')),
                    el('p', { 
                        style: { 
                            fontSize: '16px', 
                            marginBottom: '15px' 
                        } 
                    }, attributes.description || __('From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.')),
                    el('div', { 
                        style: { 
                            padding: '10px', 
                            backgroundColor: 'white', 
                            borderRadius: '5px',
                            fontSize: '14px',
                            color: '#666'
                        } 
                    }, 
                        el('i', { className: 'dashicons dashicons-admin-tools' }),
                        ' Dynamic services will be loaded from the Services custom post type (' + attributes.maxServices + ' max)'
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