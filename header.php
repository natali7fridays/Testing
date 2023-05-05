<?php
/**
 * Header template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

do_action( 'adapt_dev_html_before' );

global $adapt_dev_config;

$adapt_dev_display_top_bar = $adapt_dev_config['header_top_bar_display'];
$adapt_dev_header_layout   = $adapt_dev_config['header_layout'];
$adapt_dev_debugger        = $adapt_dev_config['debug_mode'] ? 'debug-mode' : '';

?>

<html <?php language_attributes(); ?> class="no-js">
<head>
	<?php do_action( 'adapt_dev_head_open' ); ?>

	<?php wp_head(); ?>

	<?php do_action( 'adapt_dev_head_close' ); ?>
</head>

<body <?php body_class( 'color-text bg-light ' . $adapt_dev_debugger ); ?>>
	<?php do_action( 'adapt_dev_body_open' ); ?>

	<?php do_action( 'adapt_dev_header_before' ); ?>

	<?php if ( $adapt_dev_display_top_bar == true ) : ?>
		<div class="top-bar">
			<?php get_template_part( 'template-parts/header-top-bar' ); ?>
		</div>
	<?php endif; ?>
	<header class="site-header<?php echo $adapt_dev_header_layout == 'one' ? ' justify-center' : ''; ?>">
		<?php do_action( 'adapt_dev_header_top' ); ?>

		<div class="search-bar"><?php get_search_form(); ?></div>

		<div class="site-header__content">
			<div class="logo-row">
				<?php adapt_dev_the_site_logo(); ?>

				<?php if ( $adapt_dev_header_layout == 'two' ) : ?>
					<div class="site-header__widget-area">
						<?php get_template_part( 'template-parts/header-widget-area', '', ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php get_template_part( 'template-parts/nav-default', '', ); ?>

		</div>

		<?php do_action( 'adapt_dev_header_bottom' ); ?>
	</header>
	<?php do_action( 'adapt_dev_header_after' ); ?>
