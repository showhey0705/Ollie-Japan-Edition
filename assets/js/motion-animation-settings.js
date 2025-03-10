(function(wp) {
    const { addFilter } = wp.hooks;
    const { createHigherOrderComponent } = wp.compose;
    const { InspectorControls } = wp.blockEditor;
    const { PanelBody, SelectControl, RangeControl, ToggleControl } = wp.components;
    const { __ } = wp.i18n;

    // アニメーション対象のブロックリスト
    const SUPPORTED_BLOCKS = [
        'core/paragraph',
        'core/heading',
        'core/image',
        'core/group',
        'core/button',
        'core/buttons',
        'core/column',
        'core/columns',
        'core/media-text',
        'core/list',
        'core/quote',
        'core/cover',
        'core/spacer',
        'core/separator'
    ];

    // アニメーション属性を追加
    function addMotionAttributes(settings, name) {
        if (!SUPPORTED_BLOCKS.includes(name)) {
            return settings;
        }

        return {
            ...settings,
            attributes: {
                ...settings.attributes,
                motionAnimation: {
                    type: 'object',
                    default: {
                        type: '',
                        duration: 0.6,
                        delay: 0,
                        ease: 'easeOut'
                    }
                }
            }
        };
    }

    // アニメーションタイプのラベルを取得
    function getAnimationLabel(type) {
        const labels = {
            fadeIn: 'フェードイン',
            fadeInUp: '下からフェードイン',
            fadeInLeft: '左からフェードイン',
            fadeInRight: '右からフェードイン',
            zoomIn: 'ズームイン',
            zoomInUp: '下からズームイン'
        };
        return labels[type] || type;
    }

    // アニメーションの初期位置とスケールを取得
    function getInitialTransform(type) {
        switch (type) {
            case 'fadeInUp':
                return 'translate3d(0, 30px, 0) scale(0.9)';
            case 'fadeInLeft':
                return 'translate3d(-30px, 0, 0) scale(0.9)';
            case 'fadeInRight':
                return 'translate3d(30px, 0, 0) scale(0.9)';
            case 'fadeIn':
                return 'scale(0.9) translateY(8px)';
            case 'zoomIn':
                return 'scale(0.85)';
            case 'zoomInUp':
                return 'translate3d(0, 30px, 0) scale(0.85)';
            default:
                return 'translate3d(0, 0, 0)';
        }
    }

    // アニメーションオプションを更新
    const animationOptions = [
        { label: 'なし', value: '' },
        { label: 'フェードイン', value: 'fadeIn' },
        { label: '下からフェードイン', value: 'fadeInUp' },
        { label: '左からフェードイン', value: 'fadeInLeft' },
        { label: '右からフェードイン', value: 'fadeInRight' },
        { label: 'ズームイン', value: 'zoomIn' },
        { label: '下からズームイン', value: 'zoomInUp' }
    ];

    // インスペクターコントロールを追加
    const withMotionControls = createHigherOrderComponent((BlockEdit) => {
        return (props) => {
            const { attributes, setAttributes, name, clientId } = props;
            const { motionAnimation } = attributes;

            // 対象外のブロックは通常表示
            if (!SUPPORTED_BLOCKS.includes(name)) {
                return wp.element.createElement(BlockEdit, props);
            }

            // プレビューアニメーションを実行
            const previewAnimation = (newMotion) => {
                // ブロック要素を取得（より具体的なセレクタを使用）
                const block = document.querySelector(`[data-block="${clientId}"] > .wp-block, [data-block="${clientId}"] > .block-editor-block-list__block-edit > [data-block="${clientId}"]`);
                
                if (!block) {
                    console.log('Block not found:', clientId);
                    return;
                }

                console.log('Found block:', block);

                // アニメーション属性を設定
                if (newMotion.type) {
                    block.dataset.motion = newMotion.type;
                    block.classList.add('has-motion-animation');
                } else {
                    delete block.dataset.motion;
                    block.classList.remove('has-motion-animation');
                }

                // スタイルをリセット
                block.style.transition = 'none';
                block.style.opacity = '0';
                block.style.transform = getInitialTransform(newMotion.type);

                // 強制リフロー
                void block.offsetHeight;

                // アニメーション開始
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        block.style.transition = `all ${newMotion.duration}s cubic-bezier(0.33, 1, 0.68, 1) ${newMotion.delay}s`;
                        block.style.opacity = '1';
                        block.style.transform = 'translate3d(0, 0, 0)';
                    }, 50);
                });
            };

            // アニメーション設定の変更を監視
            wp.element.useEffect(() => {
                if (motionAnimation?.type) {
                    previewAnimation(motionAnimation);
                }
            }, [motionAnimation?.type]);

            return wp.element.createElement(
                wp.element.Fragment,
                null,
                wp.element.createElement(BlockEdit, {
                    ...props,
                    className: motionAnimation?.type ? 'has-motion-animation' : ''
                }),
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        {
                            title: __('アニメーション設定', 'japonizm'),
                            initialOpen: true
                        },
                        wp.element.createElement(SelectControl, {
                            label: __('アニメーションタイプ', 'japonizm'),
                            value: motionAnimation?.type || '',
                            options: animationOptions,
                            onChange: (type) => {
                                const newMotion = {
                                    ...motionAnimation,
                                    type,
                                    duration: 0.8,
                                    delay: 0,
                                    ease: 'cubic-bezier(0.66, 0, 0.34, 1)'
                                };
                                setAttributes({ motionAnimation: newMotion });
                            }
                        }),
                        motionAnimation?.type && [
                            wp.element.createElement(RangeControl, {
                                label: __('アニメーション時間（秒）', 'japonizm'),
                                value: motionAnimation.duration,
                                onChange: (duration) => {
                                    const newMotion = { ...motionAnimation, duration };
                                    setAttributes({ motionAnimation: newMotion });
                                },
                                min: 0.1,
                                max: 2,
                                step: 0.1
                            }),
                            wp.element.createElement(RangeControl, {
                                label: __('遅延時間（秒）', 'japonizm'),
                                value: motionAnimation.delay,
                                onChange: (delay) => {
                                    const newMotion = { ...motionAnimation, delay };
                                    setAttributes({ motionAnimation: newMotion });
                                },
                                min: 0,
                                max: 2,
                                step: 0.1
                            })
                        ]
                    )
                )
            );
        };
    }, 'withMotionControls');

    // ブロックの保存時の属性を設定
    function addSaveProps(extraProps, blockType, attributes) {
        if (!SUPPORTED_BLOCKS.includes(blockType.name)) {
            return extraProps;
        }

        const { motionAnimation } = attributes;
        if (!motionAnimation?.type) {
            return extraProps;
        }

        return {
            ...extraProps,
            'data-motion': motionAnimation.type,
            className: `${extraProps.className || ''} has-motion-animation`.trim(),
            style: {
                ...extraProps.style,
                '--motion-duration': `${motionAnimation.duration}s`,
                '--motion-delay': `${motionAnimation.delay}s`,
                '--motion-ease': motionAnimation.ease
            }
        };
    }

    // フィルターを追加
    addFilter('blocks.registerBlockType', 'japonizm/motion-attributes', addMotionAttributes);
    addFilter('editor.BlockEdit', 'japonizm/motion-controls', withMotionControls);
    addFilter('blocks.getSaveContent.extraProps', 'japonizm/motion-save-props', addSaveProps);

    // 例: アニメーション設定用の基本的なスクリプト
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Motion Animation Settings Script Loaded');
        // アニメーション設定の初期化コードをここに追加
    });

})(window.wp);