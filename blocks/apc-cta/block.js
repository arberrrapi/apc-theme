/**
 * APC CTA Block
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

    blocks.registerBlockType('apc/cta', {
        title: __('APC CTA'),
        icon: 'megaphone',
        category: 'apc-blocks',
        attributes: {
            contactLabel: {
                type: 'string',
                default: 'Contact Us'
            },
            title: {
                type: 'string',
                default: 'Partner with us for comprehensive IT'
            },
            description: {
                type: 'string',
                default: 'We\'re happy to answer any questions you may have and help you determine which of our services best fit your needs.'
            },
            benefitsTitle: {
                type: 'string',
                default: 'Your Benefits'
            },
            nextStepsTitle: {
                type: 'string',
                default: 'What happens next?'
            },
            formTitle: {
                type: 'string',
                default: 'Partner with APC today'
            },
            submitButtonText: {
                type: 'string',
                default: 'Submit'
            },
            gravityFormId: {
                type: 'string',
                default: '4'
            },
            useGravityForm: {
                type: 'boolean',
                default: true
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return el('div', { className: 'apc-cta-block-editor' },
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Form Settings', 'apc-theme'), initialOpen: true },
                        el(ToggleControl, {
                            label: __('Use Gravity Forms', 'apc-theme'),
                            checked: attributes.useGravityForm,
                            onChange: function (value) {
                                setAttributes({ useGravityForm: value });
                            }
                        }),
                        attributes.useGravityForm && el(SelectControl, {
                            label: __('Select Gravity Form', 'apc-theme'),
                            value: attributes.gravityFormId,
                            options: window.apcGravityForms || [
                                { label: __('No forms found', 'apc-theme'), value: '' }
                            ],
                            onChange: function (value) {
                                setAttributes({ gravityFormId: value });
                            }
                        })
                    ),
                    el(PanelBody, { title: __('CTA Settings', 'apc-theme'), initialOpen: false },
                        el(TextControl, {
                            label: __('Submit Button Text', 'apc-theme'),
                            value: attributes.submitButtonText,
                            onChange: function (value) {
                                setAttributes({ submitButtonText: value });
                            }
                        })
                    )
                ),

                // Preview
                el('div', { className: 'apc-cta-wrapper' },
                    el('div', { className: 'apc-cta-container' },
                        // Row 1
                        el('div', { className: 'apc-cta-row-1' },
                            el('div', { className: 'apc-cta-col-1' },
                                el(RichText, {
                                    tagName: 'p',
                                    className: 'apc-cta-contact',
                                    value: attributes.contactLabel,
                                    onChange: function (value) {
                                        setAttributes({ contactLabel: value });
                                    },
                                    placeholder: __('Contact label...', 'apc-theme')
                                }),
                                el(RichText, {
                                    tagName: 'h2',
                                    className: 'apc-cta-title',
                                    value: attributes.title,
                                    onChange: function (value) {
                                        setAttributes({ title: value });
                                    },
                                    placeholder: __('Enter CTA title...', 'apc-theme')
                                })
                            ),
                            el('div', { className: 'apc-cta-col-2' },
                                el('p', { style: { color: '#666', fontStyle: 'italic' } }, __('Empty column for future content', 'apc-theme'))
                            )
                        ),
                        
                        // Row 2
                        el('div', { className: 'apc-cta-row-2' },
                            el('div', { className: 'apc-cta-col-1' },
                                el(RichText, {
                                    tagName: 'p',
                                    className: 'apc-cta-content',
                                    value: attributes.description,
                                    onChange: function (value) {
                                        setAttributes({ description: value });
                                    },
                                    placeholder: __('Enter description...', 'apc-theme')
                                }),
                                
                                el(RichText, {
                                    tagName: 'p',
                                    className: 'apc-cta-benefit',
                                    value: attributes.benefitsTitle,
                                    onChange: function (value) {
                                        setAttributes({ benefitsTitle: value });
                                    },
                                    placeholder: __('Benefits title...', 'apc-theme')
                                }),
                                
                                // Benefits Lists (static for preview)
                                el('div', { className: 'benefits-lists' },
                                    el('ul', {},
                                        el('li', {}, 'Client-oriented'),
                                        el('li', {}, 'Independent'),
                                        el('li', {}, 'Competent')
                                    ),
                                    el('ul', {},
                                        el('li', {}, 'Results-driven'),
                                        el('li', {}, 'Problem-solving'),
                                        el('li', {}, 'Transparent')
                                    )
                                ),
                                
                                // Next Steps
                                el('div', { className: 'next-step' },
                                    el(RichText, {
                                        tagName: 'p',
                                        className: 'next-step-title',
                                        value: attributes.nextStepsTitle,
                                        onChange: function (value) {
                                            setAttributes({ nextStepsTitle: value });
                                        },
                                        placeholder: __('Next steps title...', 'apc-theme')
                                    }),
                                    
                                    // Next Step Items (static for preview)
                                    el('div', { className: 'next-step-columns' },
                                        el('div', { className: 'next-step-item' },
                                            el('p', { className: 'step-number' }, '1'),
                                            el('p', { className: 'step-description' }, 'We Schedule a call at your convenience')
                                        ),
                                        el('div', { className: 'step-arrow' },
                                            el('i', { className: 'fa-solid fa-arrow-right' })
                                        ),
                                        el('div', { className: 'next-step-item' },
                                            el('p', { className: 'step-number' }, '2'),
                                            el('p', { className: 'step-description' }, 'We understand what you need in a consulting meeting')
                                        ),
                                        el('div', { className: 'step-arrow' },
                                            el('i', { className: 'fa-solid fa-arrow-right' })
                                        ),
                                        el('div', { className: 'next-step-item' },
                                            el('p', { className: 'step-number' }, '3'),
                                            el('p', { className: 'step-description' }, 'We prepare a proposal')
                                        )
                                    )
                                )
                            ),
                            
                            // Form Column
                            el('div', { className: 'apc-cta-col-2' },
                                el('div', { className: 'cta-form' },
                                    el(RichText, {
                                        tagName: 'h4',
                                        style: { textAlign: 'center' },
                                        value: attributes.formTitle,
                                        onChange: function (value) {
                                            setAttributes({ formTitle: value });
                                        },
                                        placeholder: __('Form title...', 'apc-theme')
                                    }),
                                    
                                    // Form Preview 
                                    attributes.useGravityForm ? 
                                        el('div', { 
                                            className: 'gravity-form-preview',
                                            style: { 
                                                padding: '20px',
                                                textAlign: 'center',
                                                border: '2px dashed #ddd',
                                                borderRadius: '8px',
                                                background: '#f9f9f9'
                                            }
                                        },
                                            attributes.gravityFormId ?
                                                el('p', {}, __('Gravity Form ID: ', 'apc-theme') + attributes.gravityFormId) :
                                                el('p', {}, __('Please select a Gravity Form', 'apc-theme'))
                                        )
                                    :
                                        el('div', { className: 'form-preview', style: { opacity: '0.7' } },
                                            el('input', { type: 'text', placeholder: 'Full Name', disabled: true }),
                                            el('input', { type: 'email', placeholder: 'Email Address', disabled: true }),
                                            el('input', { type: 'tel', placeholder: 'Phone Number', disabled: true }),
                                            el('input', { type: 'text', placeholder: 'Company Name', disabled: true }),
                                            el('select', { disabled: true },
                                                el('option', {}, 'Select a Service')
                                            ),
                                            el('textarea', { placeholder: 'Tell us about your IT needs...', disabled: true }),
                                            el('button', { 
                                                type: 'button', 
                                                className: 'cta-submit-btn',
                                                disabled: true
                                            }, attributes.submitButtonText)
                                        )
                                )
                            )
                        )
                    )
                )
            );
        },

        save: function () {
            return null; // Rendered in PHP
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.i18n
);