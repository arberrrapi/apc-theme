/**
 * Hero Block Registration
 */
(function(blocks, element, blockEditor, components, i18n) {
    var el = element.createElement;
    var __ = i18n.__;
    var TextControl = components.TextControl;
    var InspectorControls = blockEditor.InspectorControls;
    var useBlockProps = blockEditor.useBlockProps;

    blocks.registerBlockType('apc/hero', {
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'hero-block-editor'
            });

            return el('div', blockProps,
                el(InspectorControls, {},
                    el('div', { style: { padding: '16px' } },
                        el('h3', {}, __('Hero Text Settings', 'apc-theme')),
                        el(TextControl, {
                            label: __('Hero Line 1', 'apc-theme'),
                            value: attributes.heroLine1,
                            onChange: function(value) {
                                setAttributes({ heroLine1: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Hero Line 2', 'apc-theme'),
                            value: attributes.heroLine2,
                            onChange: function(value) {
                                setAttributes({ heroLine2: value });
                            }
                        }),
                        el('h4', {}, __('Cube Text Options', 'apc-theme')),
                        el(TextControl, {
                            label: __('Cube Text 1', 'apc-theme'),
                            value: attributes.cubeText1,
                            onChange: function(value) {
                                setAttributes({ cubeText1: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Cube Text 2', 'apc-theme'),
                            value: attributes.cubeText2,
                            onChange: function(value) {
                                setAttributes({ cubeText2: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Cube Text 3', 'apc-theme'),
                            value: attributes.cubeText3,
                            onChange: function(value) {
                                setAttributes({ cubeText3: value });
                            }
                        }),
                        el(TextControl, {
                            label: __('Cube Text 4', 'apc-theme'),
                            value: attributes.cubeText4,
                            onChange: function(value) {
                                setAttributes({ cubeText4: value });
                            }
                        })
                    )
                ),
                el('div', { className: 'hero-preview' },
                    el('div', { className: 'hero-container' },
                        el('div', { className: 'hero-text' },
                            el('div', { className: 'hero-line' }, attributes.heroLine1),
                            el('div', { className: 'hero-highlight' },
                                el('div', { className: 'cube-container' },
                                    el('div', { className: 'cube' },
                                        el('div', { className: 'cube-face active' }, attributes.cubeText1),
                                        el('div', { className: 'cube-face next' }, attributes.cubeText2),
                                        el('div', { className: 'cube-face next' }, attributes.cubeText3),
                                        el('div', { className: 'cube-face next' }, attributes.cubeText4)
                                    )
                                )
                            ),
                            el('div', { className: 'hero-line' }, attributes.heroLine2)
                        )
                    ),
                    el('div', { className: 'editor-note' },
                        el('p', {},
                            el('strong', {}, 'Note: '),
                            'The animated icons and cube rotation will be active on the frontend.'
                        )
                    )
                )
            );
        },

        save: function() {
            return null; // Server-side rendering
        }
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);
