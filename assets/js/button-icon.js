const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

// ボタンブロックに属性を追加
addFilter(
    'blocks.registerBlockType',
    'japonizm/button-icon',
    function(settings, name) {
        if (name !== 'core/button') {
            return settings;
        }

        return {
            ...settings,
            attributes: {
                ...settings.attributes,
                buttonIcon: {
                    type: 'string',
                    default: ''
                }
            }
        };
    }
);

// エディターUIに設定パネルを追加
const withButtonIconControl = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        if (props.name !== 'core/button') {
            return <BlockEdit {...props} />;
        }

        const { attributes, setAttributes } = props;
        const { buttonIcon } = attributes;

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody title="Button Icon">
                        <TextControl
                            label="Icon Class"
                            value={buttonIcon}
                            onChange={(value) => setAttributes({ buttonIcon: value })}
                        />
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };
}, 'withButtonIconControl');

addFilter(
    'editor.BlockEdit',
    'japonizm/button-icon',
    withButtonIconControl
);

// フロントエンドでのアイコン表示
addFilter(
    'blocks.getSaveElement',
    'japonizm/button-icon',
    function(element, blockType, attributes) {
        if (blockType.name !== 'core/button' || !attributes.buttonIcon) {
            return element;
        }

        const iconElement = wp.element.createElement('i', { className: attributes.buttonIcon });
        return wp.element.cloneElement(element, {}, iconElement, element.props.children);
    }
); 