/**
 * APC Button Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var ToggleControl = components.ToggleControl;
    var __ = i18n.__;

    blocks.registerBlockType('apc/button', {
        title: __('APC Button', 'apc-theme'),
        icon: 'button',
        category: 'apc-blocks',
        description: __('A customizable APC-branded button with consistent styling.', 'apc-theme'),
        keywords: [__('button', 'apc-theme'), __('link', 'apc-theme'), __('cta', 'apc-theme')],

        attributes: {
            text: {
                type: 'string',
                default: 'Click Here'
            },
            url: {
                type: 'string',
                default: ''
            },
            linkTarget: {
                type: 'string',
                default: '_self'
            },
            alignment: {
                type: 'string',
                default: 'left'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var text = attributes.text;
            var url = attributes.url;
            var linkTarget = attributes.linkTarget;
            var alignment = attributes.alignment;

            var buttonClasses = 'apc-button';

            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Button Settings', 'apc-theme') },
                        el(TextControl, {
                            label: __('Button URL', 'apc-theme'),
                            value: url,
                            onChange: function (newUrl) {
                                setAttributes({ url: newUrl });
                            },
                            placeholder: __('Enter URL...', 'apc-theme')
                        }),
                        el(ToggleControl, {
                            label: __('Open in new tab', 'apc-theme'),
                            checked: linkTarget === '_blank',
                            onChange: function (newTarget) {
                                setAttributes({ linkTarget: newTarget ? '_blank' : '_self' });
                            }
                        }),
                        el(SelectControl, {
                            label: __('Alignment', 'apc-theme'),
                            value: alignment,
                            options: [
                                { label: __('Left', 'apc-theme'), value: 'left' },
                                { label: __('Center', 'apc-theme'), value: 'center' },
                                { label: __('Right', 'apc-theme'), value: 'right' }
                            ],
                            onChange: function (newAlignment) {
                                setAttributes({ alignment: newAlignment });
                            }
                        })
                    )
                ),
                el('div', { className: 'apc-button-wrapper text-' + alignment },
                    el(RichText, {
                        tagName: 'a',
                        className: buttonClasses,
                        value: text,
                        onChange: function (newText) {
                            setAttributes({ text: newText });
                        },
                        placeholder: __('Button text...', 'apc-theme'),
                        allowedFormats: [],
                        style: {
                            textDecoration: 'none',
                            display: 'inline-block'
                        }
                    })
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;
            var text = attributes.text;
            var url = attributes.url;
            var linkTarget = attributes.linkTarget;
            var alignment = attributes.alignment;

            var buttonClasses = 'apc-button';
            var relAttr = linkTarget === '_blank' ? 'noopener noreferrer' : undefined;

            return el('div', { className: 'apc-button-wrapper text-' + alignment },
                el(RichText.Content, {
                    tagName: 'a',
                    className: buttonClasses,
                    value: text,
                    href: url,
                    target: linkTarget,
                    rel: relAttr
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