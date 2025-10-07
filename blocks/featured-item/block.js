/**
 * Featured Item Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var useState = element.useState;
    var __ = i18n.__;

    blocks.registerBlockType('apc/featured-item', {
        title: __('Featured Item', 'apc-theme'),
        icon: 'star-filled',
        category: 'apc-blocks',
        description: __('Display a featured item with icon, title, and description.', 'apc-theme'),
        keywords: [__('featured', 'apc-theme'), __('item', 'apc-theme'), __('icon', 'apc-theme')],

        attributes: {
            name: {
                type: 'string',
                default: 'Featured Item'
            },
            icon: {
                type: 'string',
                default: 'fa-solid fa-star'
            },
            description: {
                type: 'string',
                default: 'Short description of this featured item.'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var name = attributes.name;
            var icon = attributes.icon;
            var description = attributes.description;
            
            // Use local state to avoid cursor jumping
            var localName = useState(name);
            var localDescription = useState(description);
            
            var currentName = localName[0];
            var setCurrentName = localName[1];
            var currentDescription = localDescription[0];
            var setCurrentDescription = localDescription[1];

            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Featured Item Settings', 'apc-theme') },
                        el(TextControl, {
                            label: __('Icon Class', 'apc-theme'),
                            value: icon,
                            onChange: function (newIcon) {
                                setAttributes({ icon: newIcon });
                            },
                            placeholder: __('e.g., fa-solid fa-star', 'apc-theme'),
                            help: __('FontAwesome icon class. Visit fontawesome.com for icons.', 'apc-theme')
                        })
                    )
                ),
                el('div', { className: 'featured-item-wrapper' },
                    el('div', { className: 'featured-item-header' },
                        el('i', { className: icon, style: { marginRight: '10px', fontSize: '20px' } }),
                        el('div', { style: { flex: 1 } },
                            el('input', {
                                type: 'text',
                                className: 'featured-item-title-input',
                                value: currentName,
                                onChange: function (event) {
                                    setCurrentName(event.target.value);
                                },
                                onBlur: function (event) {
                                    setAttributes({ name: event.target.value });
                                },
                                placeholder: __('Featured Item Title...', 'apc-theme'),
                                style: { 
                                    fontSize: '18px',
                                    fontWeight: '600',
                                    border: '1px dashed #ddd',
                                    padding: '5px',
                                    width: '100%'
                                }
                            })
                        )
                    ),
                    el('textarea', {
                        className: 'featured-item-description-input',
                        value: currentDescription,
                        onChange: function (event) {
                            setCurrentDescription(event.target.value);
                        },
                        onBlur: function (event) {
                            setAttributes({ description: event.target.value });
                        },
                        placeholder: __('Short description...', 'apc-theme'),
                        rows: 2,
                        style: { 
                            marginTop: '10px',
                            fontSize: '14px',
                            border: '1px dashed #ddd',
                            padding: '5px',
                            width: '100%',
                            resize: 'vertical'
                        }
                    })
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;
            var name = attributes.name;
            var icon = attributes.icon;
            var description = attributes.description;

            return el('div', { className: 'featured-item-wrapper' },
                el('div', { className: 'featured-item-header' },
                    el('i', { className: icon }),
                    el(RichText.Content, {
                        tagName: 'h3',
                        className: 'featured-item-title',
                        value: name
                    })
                ),
                el(RichText.Content, {
                    tagName: 'p',
                    className: 'featured-item-description',
                    value: description
                })
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