/**
 * Featured About Hero Block
 */
(function (blocks, element, blockEditor, components, i18n) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var MediaUpload = blockEditor.MediaUpload;
    var MediaUploadCheck = blockEditor.MediaUploadCheck;
    var Button = components.Button;
    var __ = i18n.__;

    blocks.registerBlockType('apc-theme/featured-about-hero', {
        title: __('Featured About Hero'),
        icon: 'star-filled',
        category: 'apc-blocks',
        attributes: {
            chips: {
                type: 'array',
                default: [
                    { type: 'image', url: '', alt: '' },
                    { type: 'text', text: 'Solving' },
                    { type: 'image', url: '', alt: '' },
                    { type: 'text', text: 'business' },
                    { type: 'text', text: 'challenges' },
                    { type: 'text', text: 'using' },
                    { type: 'text', text: 'Microsoft' },
                    { type: 'image', url: '', alt: '' },
                    { type: 'text', text: 'technology' },
                    { type: 'text', text: 'for over 25 years' }
                ]
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var chips = attributes.chips || [];

            function updateChip(index, newChip) {
                var newChips = chips.slice();
                newChips[index] = Object.assign({}, newChips[index], newChip);
                setAttributes({ chips: newChips });
            }

            function createImageUpload(index, chip) {
                return el(MediaUploadCheck, {},
                    el(MediaUpload, {
                        onSelect: function(media) { 
                            updateChip(index, { url: media.url, alt: media.alt || '' }); 
                        },
                        allowedTypes: ['image'],
                        value: chip.id,
                        render: function(obj) {
                            return el('div', { className: 'chip-image-wrapper' },
                                chip.url ?
                                    el('div', { 
                                        className: 'chip-image-preview',
                                        onClick: obj.open,
                                        style: { cursor: 'pointer' }
                                    },
                                        el('img', { 
                                            src: chip.url, 
                                            alt: chip.alt || '',
                                            className: 'chip-image'
                                        }),
                                        el(Button, {
                                            onClick: obj.open,
                                            isSecondary: true,
                                            isSmall: true,
                                            className: 'chip-image-replace'
                                        }, __('Replace'))
                                    ) :
                                    el(Button, {
                                        onClick: obj.open,
                                        isPrimary: true,
                                        className: 'chip-image-upload'
                                    }, __('+ Select Image'))
                            );
                        }
                    })
                );
            }

            return el('div', { className: 'featured-about-hero-block' },
                // Row 1: 4 columns
                el('div', { className: 'hero-row row1' },
                    el('div', { className: 'hero-col col-10' },
                        chips[0] && chips[0].type === 'image' ? createImageUpload(0, chips[0]) : null
                    ),
                    el('div', { className: 'hero-col col-40' },
                        chips[1] && chips[1].type === 'text' ?
                            el(RichText, {
                                tagName: 'h2',
                                value: chips[1].text,
                                onChange: function(text) { updateChip(1, { text: text }); },
                                placeholder: __('Solving'),
                                allowedFormats: []
                            }) : null
                    ),
                    el('div', { className: 'hero-col col-10' },
                        chips[2] && chips[2].type === 'image' ? createImageUpload(2, chips[2]) : null
                    ),
                    el('div', { className: 'hero-col col-40' },
                        chips[3] && chips[3].type === 'text' ?
                            el(RichText, {
                                tagName: 'h2',
                                value: chips[3].text,
                                onChange: function(text) { updateChip(3, { text: text }); },
                                placeholder: __('business'),
                                allowedFormats: []
                            }) : null
                    )
                ),
                // Row 2: 3 columns
                el('div', { className: 'hero-row row2' },
                    el('div', { className: 'hero-col col-30' },
                        chips[4] && chips[4].type === 'text' ?
                            el(RichText, {
                                tagName: 'span',
                                value: chips[4].text,
                                onChange: function(text) { updateChip(4, { text: text }); },
                                placeholder: __('challenges'),
                                allowedFormats: []
                            }) : null
                    ),
                    el('div', { className: 'hero-col col-30' },
                        chips[5] && chips[5].type === 'text' ?
                            el(RichText, {
                                tagName: 'span',
                                value: chips[5].text,
                                onChange: function(text) { updateChip(5, { text: text }); },
                                placeholder: __('using'),
                                allowedFormats: []
                            }) : null
                    ),
                    el('div', { className: 'hero-col col-40' },
                        chips[6] && chips[6].type === 'text' ?
                            el(RichText, {
                                tagName: 'span',
                                value: chips[6].text,
                                onChange: function(text) { updateChip(6, { text: text }); },
                                placeholder: __('Microsoft'),
                                allowedFormats: []
                            }) : null
                    )
                ),
                // Row 3: 3 columns
                el('div', { className: 'hero-row row3' },
                    el('div', { className: 'hero-col col-30' },
                        chips[7] && chips[7].type === 'image' ? createImageUpload(7, chips[7]) : null
                    ),
                    el('div', { className: 'hero-col col-10' },
                        chips[8] && chips[8].type === 'text' ?
                            el(RichText, {
                                tagName: 'span',
                                value: chips[8].text,
                                onChange: function(text) { updateChip(8, { text: text }); },
                                placeholder: __('technology'),
                                allowedFormats: []
                            }) : null
                    ),
                    el('div', { className: 'hero-col col-60' },
                        chips[9] && chips[9].type === 'text' ?
                            el(RichText, {
                                tagName: 'span',
                                value: chips[9].text,
                                onChange: function(text) { updateChip(9, { text: text }); },
                                placeholder: __('for over 25 years'),
                                allowedFormats: []
                            }) : null
                    )
                )
            );
        },

        save: function () {
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
