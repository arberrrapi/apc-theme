/**
 * Counters Block
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var RangeControl = components.RangeControl;
    var useState = element.useState;
    var __ = i18n.__;

    blocks.registerBlockType('apc/counters', {
        title: __('Counters', 'apc-theme'),
        icon: 'chart-bar',
        category: 'apc-blocks',
        description: __('Display up to four counter columns with numbers and subtitles.', 'apc-theme'),
        keywords: [__('counters', 'apc-theme'), __('stats', 'apc-theme'), __('numbers', 'apc-theme')],

        attributes: {
            counter1Number: {
                type: 'string',
                default: '100'
            },
            counter1Subtitle: {
                type: 'string',
                default: 'Projects Completed'
            },
            counter2Number: {
                type: 'string',
                default: '50'
            },
            counter2Subtitle: {
                type: 'string',
                default: 'Happy Clients'
            },
            counter3Number: {
                type: 'string',
                default: '25'
            },
            counter3Subtitle: {
                type: 'string',
                default: 'Years Experience'
            },
            counter4Number: {
                type: 'string',
                default: '10'
            },
            counter4Subtitle: {
                type: 'string',
                default: 'Team Members'
            },
            columnsCount: {
                type: 'number',
                default: 4
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            // Local state for all counters
            var localCounter1Number = useState(attributes.counter1Number);
            var localCounter1Subtitle = useState(attributes.counter1Subtitle);
            var localCounter2Number = useState(attributes.counter2Number);
            var localCounter2Subtitle = useState(attributes.counter2Subtitle);
            var localCounter3Number = useState(attributes.counter3Number);
            var localCounter3Subtitle = useState(attributes.counter3Subtitle);
            var localCounter4Number = useState(attributes.counter4Number);
            var localCounter4Subtitle = useState(attributes.counter4Subtitle);

            var renderCounter = function(index) {
                var counterNumber, counterSubtitle, setCounterNumber, setCounterSubtitle;
                
                switch(index) {
                    case 1:
                        counterNumber = localCounter1Number[0];
                        counterSubtitle = localCounter1Subtitle[0];
                        setCounterNumber = localCounter1Number[1];
                        setCounterSubtitle = localCounter1Subtitle[1];
                        break;
                    case 2:
                        counterNumber = localCounter2Number[0];
                        counterSubtitle = localCounter2Subtitle[0];
                        setCounterNumber = localCounter2Number[1];
                        setCounterSubtitle = localCounter2Subtitle[1];
                        break;
                    case 3:
                        counterNumber = localCounter3Number[0];
                        counterSubtitle = localCounter3Subtitle[0];
                        setCounterNumber = localCounter3Number[1];
                        setCounterSubtitle = localCounter3Subtitle[1];
                        break;
                    case 4:
                        counterNumber = localCounter4Number[0];
                        counterSubtitle = localCounter4Subtitle[0];
                        setCounterNumber = localCounter4Number[1];
                        setCounterSubtitle = localCounter4Subtitle[1];
                        break;
                }

                return el('div', { 
                    className: 'counter-column',
                    key: index,
                    style: {
                        flex: '1',
                        textAlign: 'left',
                        position: 'relative',
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'flex-start',
                        justifyContent: 'center',
                        minWidth: '0'
                    }
                },
                    el('input', {
                        type: 'text',
                        className: 'counter-number-input',
                        value: counterNumber,
                        onChange: function (event) {
                            setCounterNumber(event.target.value);
                        },
                        onBlur: function (event) {
                            setAttributes({ ['counter' + index + 'Number']: event.target.value });
                        },
                        placeholder: __('Number', 'apc-theme'),
                        style: {
                            fontSize: '2.5rem',
                            fontWeight: '700',
                            color: 'white',
                            background: 'transparent',
                            border: '2px dashed rgba(255,255,255,0.3)',
                            padding: '10px',
                            textAlign: 'left',
                            width: '100%',
                            marginBottom: '10px'
                        }
                    }),
                    el('input', {
                        type: 'text',
                        className: 'counter-subtitle-input',
                        value: counterSubtitle,
                        onChange: function (event) {
                            setCounterSubtitle(event.target.value);
                        },
                        onBlur: function (event) {
                            setAttributes({ ['counter' + index + 'Subtitle']: event.target.value });
                        },
                        placeholder: __('Subtitle', 'apc-theme'),
                        style: {
                            fontSize: '1rem',
                            color: 'rgba(255,255,255,0.9)',
                            background: 'transparent',
                            border: '1px dashed rgba(255,255,255,0.3)',
                            padding: '5px',
                            textAlign: 'left',
                            width: '100%'
                        }
                    })
                );
            };

            var counters = [];
            for (var i = 1; i <= attributes.columnsCount; i++) {
                counters.push(renderCounter(i));
                
                // Add separator line between columns (except after last column)
                if (i < attributes.columnsCount) {
                    counters.push(
                        el('div', {
                            key: 'separator-' + i,
                            style: {
                                width: '1px',
                                height: '60px',
                                background: 'rgba(255, 255, 255, 0.3)',
                                alignSelf: 'center'
                            }
                        })
                    );
                }
            }

            return el('div', {},
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Counter Settings', 'apc-theme') },
                        el(RangeControl, {
                            label: __('Number of Columns', 'apc-theme'),
                            value: attributes.columnsCount,
                            onChange: function (newCount) {
                                setAttributes({ columnsCount: newCount });
                            },
                            min: 1,
                            max: 4
                        })
                    )
                ),
                el('div', { 
                    className: 'counters-wrapper',
                    style: {
                        margin: '40px 0'
                    }
                },
                    el('div', { 
                        className: 'counters-container',
                        style: {
                            background: 'linear-gradient(135deg, #00c8ff, #7055ee)',
                            borderRadius: '25px',
                            padding: '40px 20px',
                            display: 'flex',
                            flexDirection: 'row',
                            justifyContent: 'space-around',
                            alignItems: 'center',
                            position: 'relative',
                            width: '100%',
                            boxSizing: 'border-box'
                        }
                    }, counters)
                )
            );
        },

        save: function (props) {
            var attributes = props.attributes;
            
            var counters = [];
            for (var i = 1; i <= attributes.columnsCount; i++) {
                var counterNumber = attributes['counter' + i + 'Number'];
                var counterSubtitle = attributes['counter' + i + 'Subtitle'];
                
                counters.push(
                    el('div', { 
                        className: 'counter-column',
                        key: i 
                    },
                        el('h2', { className: 'counter-number' }, counterNumber),
                        el('p', { className: 'counter-subtitle' }, counterSubtitle)
                    )
                );
            }

            return el('div', { className: 'counters-wrapper' },
                el('div', { className: 'counters-container' }, counters)
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