/**
 * Our Team Block Editor
 */
(function (blocks, element, editor, components, i18n) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var MediaUpload = editor.MediaUpload;
    var Button = components.Button;
    var TextControl = components.TextControl;
    var __ = i18n.__;

    blocks.registerBlockType('apc-theme/our-team', {
        title: __('Our Team'),
        icon: 'groups',
        category: 'apc-blocks',
        attributes: {
            title: {
                type: 'string',
                default: 'Our Team'
            },
            description: {
                type: 'string',
                default: 'Meet the talented professionals behind our success.'
            },
            teamMembers: {
                type: 'array',
                default: [
                    {
                        image: '',
                        name: '',
                        title: ''
                    }
                ]
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var teamMembers = attributes.teamMembers || [];
            var title = attributes.title || 'Our Team';
            var description = attributes.description || 'Meet the talented professionals behind our success.';

            function updateMember(index, field, value) {
                var newMembers = teamMembers.slice();
                newMembers[index] = Object.assign({}, newMembers[index], { [field]: value });
                setAttributes({ teamMembers: newMembers });
            }

            function addMember() {
                var newMembers = teamMembers.concat([{
                    image: '',
                    name: '',
                    title: ''
                }]);
                setAttributes({ teamMembers: newMembers });
            }

            function removeMember(index) {
                if (teamMembers.length > 1) {
                    var newMembers = teamMembers.filter(function(member, i) { return i !== index; });
                    setAttributes({ teamMembers: newMembers });
                }
            }

            return el('div', { className: 'our-team-block' },
                // Section Header
                el('div', { className: 'team-header' },
                    el(TextControl, {
                        label: __('Section Title'),
                        value: title,
                        onChange: function(value) { setAttributes({ title: value }); },
                        placeholder: __('Enter section title')
                    }),
                    el(TextControl, {
                        label: __('Section Description'),
                        value: description,
                        onChange: function(value) { setAttributes({ description: value }); },
                        placeholder: __('Enter section description')
                    })
                ),

                // Team Members Grid
                el('div', { className: 'team-members-grid' },
                    teamMembers.map(function(member, index) {
                        return el('div', {
                            key: index,
                            className: 'team-member',
                            style: { position: 'relative' }
                        },
                            // Member Image
                            el('div', { className: 'member-image' },
                                el(MediaUpload, {
                                    onSelect: function(media) {
                                        updateMember(index, 'image', media.url);
                                    },
                                    allowedTypes: ['image'],
                                    value: member.image,
                                    render: function(obj) {
                                        return member.image ?
                                            el('img', {
                                                src: member.image,
                                                alt: member.name || 'Team member',
                                                onClick: obj.open,
                                                style: { cursor: 'pointer' }
                                            }) :
                                            el('div', {
                                                className: 'member-image-placeholder',
                                                onClick: obj.open,
                                                style: { cursor: 'pointer' }
                                            }, __('Select Photo'));
                                    }
                                })
                            ),

                            // Member Info
                            el('div', { className: 'member-info' },
                                el(TextControl, {
                                    label: __('Full Name'),
                                    value: member.name,
                                    onChange: function(value) { updateMember(index, 'name', value); },
                                    placeholder: __('Enter full name')
                                }),
                                el(TextControl, {
                                    label: __('Title'),
                                    value: member.title,
                                    onChange: function(value) { updateMember(index, 'title', value); },
                                    placeholder: __('Enter job title')
                                })
                            ),

                            // Remove button
                            teamMembers.length > 1 ? el(Button, {
                                onClick: function() { removeMember(index); },
                                isSmall: true,
                                isDestructive: true,
                                style: {
                                    position: 'absolute',
                                    top: '10px',
                                    right: '10px',
                                    zIndex: 10
                                }
                            }, '×') : null
                        );
                    })
                ),

                // Add member button
                el('div', {
                    style: {
                        marginTop: '20px',
                        textAlign: 'center'
                    }
                },
                    el(Button, {
                        onClick: addMember,
                        variant: 'primary',
                        style: { marginRight: '10px' }
                    }, __('Add Team Member'))
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