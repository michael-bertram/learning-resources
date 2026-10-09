
(function (wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginDocumentSettingPanel } = wp.editPost;
    const { SelectControl, TextControl, Button } = wp.components;
    const { useSelect, useDispatch } = wp.data;
    const { createElement: el, Fragment } = wp.element;

    function ResourceMetadataPanel() {
        const meta = useSelect(
            (select) =>
                select('core/editor').getEditedPostAttribute('meta') || {},
            []
        );

        const { editPost } = useDispatch('core/editor');

        const updateMeta = (key, value) => {
            editPost({
                meta: {
                    ...meta,
                    [key]: value,
                },
            });
        };

        const objectives = Array.isArray(
            meta._learning_resource_objectives
        )
            ? meta._learning_resource_objectives
            : [];

        const addObjective = () => {
            updateMeta(
                '_learning_resource_objectives',
                [...objectives, '']
            );
        };

        const updateObjective = (index, value) => {
            updateMeta(
                '_learning_resource_objectives',
                objectives.map((objective, i) =>
                    i === index ? value : objective
                )
            );
        };

        const removeObjective = (index) => {
            updateMeta(
                '_learning_resource_objectives',
                objectives.filter((_, i) => i !== index)
            );
        };

        return el(
            PluginDocumentSettingPanel,
            {
                name: 'learning-resource-details',
                title: 'Learning Resource Details',
                className: 'learning-resource-details',
            },
            el(
                Fragment,
                {},
                el(SelectControl, {
                    label: 'Resource type',
                    value: meta._learning_resource_type || 'lesson',
                    options: [
                        { label: 'Lesson', value: 'lesson' },
                        { label: 'Sub-lesson', value: 'sub_lesson' },
                        { label: 'Topic', value: 'topic' },
                        { label: 'Exercise', value: 'exercise' },
                        { label: 'Quiz', value: 'quiz' },
                        { label: 'Assessment', value: 'assessment' },
                    ],
                    onChange: (value) =>
                        updateMeta('_learning_resource_type', value),
                }),
                el(TextControl, {
                    label: 'Estimated duration (minutes)',
                    type: 'number',
                    min: 0,
                    value: String(
                        meta._learning_resource_duration ?? ''
                    ),
                    onChange: (value) =>
                        updateMeta(
                            '_learning_resource_duration',
                            value === '' ? 0 : Math.max(0, parseInt(value, 10) || 0)
                        ),
                }),
                el(SelectControl, {
                    label: 'Difficulty',
                    value: meta._learning_resource_difficulty || 'beginner',
                    options: [
                        { label: 'Beginner', value: 'beginner' },
                        { label: 'Intermediate', value: 'intermediate' },
                        { label: 'Advanced', value: 'advanced' },
                    ],
                    onChange: (value) =>
                        updateMeta('_learning_resource_difficulty', value),
                }),
                el(
                    'div',
                    { className: 'learning-resource-objectives' },
                    el(
                        'h4',
                        {},
                        'Learning objectives'
                    ),
                    el(
                        'p',
                        {},
                        'What should learners be able to do after completing this resource?'
                    ),
                    ...objectives.map((objective, index) =>
                        el(
                            'div',
                            {
                                key: index,
                                style: { marginBottom: '12px' },
                            },
                            el(TextControl, {
                                label: 'Objective ' + (index + 1),
                                value: objective,
                                onChange: (value) =>
                                    updateObjective(index, value),
                            }),
                            el(
                                Button,
                                {
                                    variant: 'tertiary',
                                    isDestructive: true,
                                    onClick: () => removeObjective(index),
                                },
                                'Remove objective'
                            )
                        )
                    ),
                    el(
                        Button,
                        {
                            variant: 'secondary',
                            onClick: addObjective,
                        },
                        'Add objective'
                    )
                )
            )
        );
    }

    registerPlugin('learning-resource-details', {
        render: ResourceMetadataPanel,
    });
})(window.wp);