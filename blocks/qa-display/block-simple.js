/**
 * Simple Q&A Display Block for Testing
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var __ = i18n.__;

    blocks.registerBlockType('apc/qa-display-simple', {
        title: __('Q&A Display (Simple)'),
        icon: 'editor-help',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Q&A Section'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return el('div', { 
                className: 'qa-display-simple',
                style: { 
                    padding: '20px', 
                    border: '2px dashed #ccc', 
                    textAlign: 'center' 
                }
            },
                el('h3', {}, __('Q&A Display Block (Simple Test)', 'apc-theme')),
                el(RichText, {
                    tagName: 'h2',
                    value: attributes.title,
                    onChange: function (value) {
                        setAttributes({ title: value });
                    },
                    placeholder: __('Enter Q&A title...', 'apc-theme')
                }),
                el('p', {}, __('If you can see this block, the registration is working!', 'apc-theme'))
            );
        },

        save: function (props) {
            var attributes = props.attributes;
            return el('div', { className: 'qa-display-simple' },
                el('h2', {}, attributes.title),
                el('p', {}, __('Q&A content will appear here', 'apc-theme'))
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