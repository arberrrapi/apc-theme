import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

export default function Edit({ attributes, setAttributes }) {
    const { 
        heroLine1, 
        heroLine2, 
        cubeText1, 
        cubeText2, 
        cubeText3, 
        cubeText4 
    } = attributes;

    const blockProps = useBlockProps({
        className: 'hero-block-editor'
    });

    return (
        <>
            <InspectorControls>
                <div style={{ padding: '16px' }}>
                    <h3>{__('Hero Text Settings', 'apc-theme')}</h3>
                    <TextControl
                        label={__('Hero Line 1', 'apc-theme')}
                        value={heroLine1}
                        onChange={(value) => setAttributes({ heroLine1: value })}
                    />
                    <TextControl
                        label={__('Hero Line 2', 'apc-theme')}
                        value={heroLine2}
                        onChange={(value) => setAttributes({ heroLine2: value })}
                    />
                    <h4>{__('Cube Text Options', 'apc-theme')}</h4>
                    <TextControl
                        label={__('Cube Text 1', 'apc-theme')}
                        value={cubeText1}
                        onChange={(value) => setAttributes({ cubeText1: value })}
                    />
                    <TextControl
                        label={__('Cube Text 2', 'apc-theme')}
                        value={cubeText2}
                        onChange={(value) => setAttributes({ cubeText2: value })}
                    />
                    <TextControl
                        label={__('Cube Text 3', 'apc-theme')}
                        value={cubeText3}
                        onChange={(value) => setAttributes({ cubeText3: value })}
                    />
                    <TextControl
                        label={__('Cube Text 4', 'apc-theme')}
                        value={cubeText4}
                        onChange={(value) => setAttributes({ cubeText4: value })}
                    />
                </div>
            </InspectorControls>
            
            <div {...blockProps}>
                <div className="hero-preview">
                    <div className="hero-container">
                        <div className="hero-text">
                            <div className="hero-line">{heroLine1}</div>
                            <div className="hero-highlight">
                                <div className="cube-container">
                                    <div className="cube">
                                        <div className="cube-face active">{cubeText1}</div>
                                        <div className="cube-face next">{cubeText2}</div>
                                        <div className="cube-face next">{cubeText3}</div>
                                        <div className="cube-face next">{cubeText4}</div>
                                    </div>
                                </div>
                            </div>
                            <div className="hero-line">{heroLine2}</div>
                        </div>
                    </div>
                    <div className="editor-note">
                        <p><strong>Note:</strong> The animated icons and cube rotation will be active on the frontend.</p>
                    </div>
                </div>
            </div>
        </>
    );
}