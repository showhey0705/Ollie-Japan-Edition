<?php
/**
 * Ollie Child Theme functions and definitions
 *
 * @package Ollie Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * 親テーマのスタイルを読み込む
 */
function ollie_child_enqueue_styles() {
	wp_enqueue_style(
		'ollie-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'ollie' )->get( 'Version' )
	);

	wp_enqueue_style(
		'ollie-child-style',
		get_stylesheet_uri(),
		array( 'ollie-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ollie_child_enqueue_styles' );

/**
 * in18n　テキストドメインを登録
 */
function ollie_japan_load_textdomain() {
    load_theme_textdomain( 'ollie', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'ollie_japan_load_textdomain' );


/**
 * ブロックスタイルを登録
 */
function register_block_styles() {
	$block_styles = array(
		'core/cover'        => array(
			'blur-image-less' => __( 'Blur Image Less', 'ollie' ),
			'blur-image-more' => __( 'Blur Image More', 'ollie' ),
			'rounded-cover'   => __( 'Rounded', 'ollie' ),
			'circle-cover'    => __( 'Circle', 'ollie' ),
		),
		'core/column'       => array(
			'column-box-shadow'     => __( 'Box Shadow', 'ollie' ),            
			'column-reverse-mobile' => __( 'Reverse on Mobile', 'ollie' ),
		),
		'core/post-excerpt' => array(
			'excerpt-truncate-2' => __( 'Truncate 2 Lines', 'ollie' ),
			'excerpt-truncate-3' => __( 'Truncate 3 Lines', 'ollie' ),
			'excerpt-truncate-4' => __( 'Truncate 4 Lines', 'ollie' ),
		),
		'core/group'        => array(
			'column-box-shadow' => __( 'Box Shadow', 'ollie' ),
			'background-blur'   => __( 'Background Blur', 'ollie' ),
		),
		'core/separator'    => array(
			'separator-dotted' => __( 'Dotted', 'ollie' ),
			'separator-thin'   => __( 'Thin', 'ollie' ),
		),
		'core/image'        => array(
			'rounded-full' => __( 'Rounded Full', 'ollie' ),
			'media-boxed'  => __( 'Boxed', 'ollie' ),
			'media-shine'  => __( 'Shine', 'ollie' ),
			'ken-burns'    => __( 'Ken Burns', 'ollie' ),
		),
		'core/preformatted' => array(
			'preformatted-dark' => __( 'Dark Style', 'ollie' ),
		),
		'core/post-terms'   => array(
			'term-button' => __( 'Button Style', 'ollie' ),
		),
		'core/video'        => array(
			'media-boxed' => __( 'Boxed', 'ollie' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'register_block_styles' );

/**
 * カスタムブロックスタイルを読み込む
 */
function enqueue_custom_block_styles() {
	wp_enqueue_style(
		'custom-block-styles',
		get_stylesheet_directory_uri() . '/assets/css/custom-block-styles.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'enqueue_block_assets', 'enqueue_custom_block_styles' );

/**
 * Register pattern categories.
 */
function pattern_categories() {

	$block_pattern_categories = array(
		'ollie/card'           => array(
			'label' => __( 'Cards', 'ollie' ),
		),
		'ollie/call-to-action' => array(
			'label' => __( 'Call To Action', 'ollie' ),
		),
		'ollie/features'       => array(
			'label' => __( 'Features', 'ollie' ),
		),
		'ollie/hero'           => array(
			'label' => __( 'Hero', 'ollie' ),
		),
		'ollie/pages'          => array(
			'label' => __( 'Pages', 'ollie' ),
		),
		'ollie/posts'          => array(
			'label' => __( 'Posts', 'ollie' ),
		),
		'ollie/pricing'        => array(
			'label' => __( 'Pricing', 'ollie' ),
		),
		'ollie/testimonial'    => array(
			'label' => __( 'Testimonials', 'ollie' ),
		),
	);

	foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}
add_action( 'init', __NAMESPACE__ . '\pattern_categories', 9 );

/**
 * アニメーション設定用のスクリプトを追加
 */
function add_motion_animation_settings() {
	wp_enqueue_script(
		'motion-animation-settings', 
		get_stylesheet_directory_uri() . '/assets/js/motion-animation-settings.js',
		array(
			'wp-blocks',
			'wp-block-editor',
			'wp-element',
			'wp-components',
			'wp-i18n',
			'wp-compose'
		),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// スクリプトの翻訳を追加
	wp_set_script_translations(
		'motion-animation-settings',
		'japonizm',
		get_stylesheet_directory() . '/languages'
	);
}
add_action( 'enqueue_block_editor_assets', 'add_motion_animation_settings' );

/**
 * フロントエンド用のアニメーションスクリプトを追加
 */
function add_frontend_animation_script() {
	// IntersectionObserver用のポリフィル（必要な場合）
	wp_enqueue_script(
		'intersection-observer-polyfill',
		'https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver',
		array(),
		null,
		true
	);

	// アニメーションスクリプト
	wp_enqueue_script(
		'frontend-animation',
		get_stylesheet_directory_uri() . '/assets/js/frontend-animation.js',
		array( 'intersection-observer-polyfill' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'add_frontend_animation_script' );

/**
 * ブロック出力をフィルタリングしてアニメーション属性を追加
 *
 * @param string $block_content ブロックのHTML
 * @param array  $block         ブロック情報
 * @return string               修正されたブロックHTML
 */
function filter_block_output( $block_content, $block ) {
	if ( empty( $block['attrs'] ) ) {
		return $block_content;
	}

	// アニメーション属性が設定されているか確認
	if ( isset( $block['attrs']['motionAnimation'] ) && ! empty( $block['attrs']['motionAnimation']['type'] ) ) {
		$motion = $block['attrs']['motionAnimation'];
		$animation_type = $motion['type'];
		$animation_delay = isset( $motion['delay'] ) ? $motion['delay'] : '0';
		$animation_duration = isset( $motion['duration'] ) ? $motion['duration'] : '0.6';
		$animation_easing = isset( $motion['ease'] ) ? $motion['ease'] : 'easeOut';
		
		// DOMを操作してdata属性を追加
		$dom = new DOMDocument();
		@$dom->loadHTML( mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ) );
		
		$xpath = new DOMXPath( $dom );
		$first_element = $xpath->query( '/html/body/*[1]' )->item( 0 );
		
		if ( $first_element ) {
			// アニメーション属性を追加
			$first_element->setAttribute( 'data-motion', $animation_type );
			$first_element->setAttribute( 'class', $first_element->getAttribute( 'class' ) . ' has-motion-animation' );
			$first_element->setAttribute( 'style', $first_element->getAttribute( 'style' ) . ' --motion-delay: ' . $animation_delay . 's; --motion-duration: ' . $animation_duration . 's; --motion-ease: ' . $animation_easing . ';' );
			
			// 変更を適用
			$body = $dom->getElementsByTagName( 'body' )->item( 0 );
			$html = '';
			foreach ( $body->childNodes as $node ) {
				$html .= $dom->saveHTML( $node );
			}
			
			return $html;
		}
	}
	
	return $block_content;
}
add_filter( 'render_block', 'filter_block_output', 10, 2 );

/**
 * ブロック属性を登録
 */
function register_block_attributes() {
	// アニメーション属性を登録
	$animation_attributes = array(
		'motionAnimation' => array(
			'type' => 'object',
			'default' => array(
				'type' => '',
				'duration' => 0.6,
				'delay' => 0,
				'ease' => 'easeOut'
			),
		),
	);

	// サポートされているブロックタイプ
	$supported_blocks = array(
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
	);

	// 各ブロックタイプに属性を追加
	foreach ( $supported_blocks as $block_name ) {
		// インラインJSは動的属性の登録に問題があるため、
		// ここで登録せず、motion-animation-settings.jsで
		// addFilterフックを使用して登録する方法に変更
	}
}
add_action( 'init', 'register_block_attributes' );
