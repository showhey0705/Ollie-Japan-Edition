<?php
/**
 * Title: Footer Centered Light
 * Slug: ollie/footer-light-centered
 * Description:
 * Categories: footer
 * Keywords:
 * Viewport Width: 1500
 * Block Types: core/template-part/footer
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"footer","metadata":{"name":"Footer"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","right":"var:preset|spacing|medium","left":"var:preset|spacing|medium"},"margin":{"top":"0px"},"blockGap":"var:preset|spacing|large"},"border":{"top":{"color":"var:preset|color|border-light","width":"1px"},"right":{},"bottom":{},"left":{}}},"backgroundColor":"base","layout":{"inherit":true,"type":"constrained"}} -->
<footer class="wp-block-group alignfull has-base-background-color has-background" style="border-top-color:var(--wp--preset--color--border-light);border-top-width:1px;margin-top:0px;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Footer Inside"},"style":{"spacing":{}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:site-title {"level":0,"textAlign":"center","isLink":false} /-->

<!-- wp:group {"metadata":{"name":"Links"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group has-secondary-color has-text-color has-link-color has-small-font-size"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Download', 'ollie' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Visit Ollie', 'ollie' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Twitter', 'ollie' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Visit Mike', 'ollie' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"small"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-small-font-size"><?php echo wp_kses_post( _x( '© 2024 · Powered by WordPress and <a href="https://olliewp.com">Ollie</a>', 'Copyright text', 'ollie' ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"base","iconColorValue":"#fff","iconBackgroundColor":"main","iconBackgroundColorValue":"#14111f","className":"is-style-default","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|small","left":"var:preset|spacing|small"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<ul class="wp-block-social-links has-icon-color has-icon-background-color is-style-default"><!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"facebook"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></footer>
<!-- /wp:group -->
