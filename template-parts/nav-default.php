<?php
/**
 * Template nav part for default header option.
 *
 * @package adaptdev/base
 */

global $adapt_dev_config;

$adapt_dev_primary_nav    = $adapt_dev_config['header_primary_nav'];
$adapt_dev_primary_toggle = $adapt_dev_config['header_search_primary_menu_toggle'];
$adapt_dev_nav_align      = $adapt_dev_config['header_nav_alignment'];
$adapt_dev_nav_bg_color   = $adapt_dev_config['header_nav_bg_color'];
$adapt_dev_header_layout  = $adapt_dev_config['header_layout'];
$adapt_dev_header_menu    = $adapt_dev_config['header_menu'];

?>

<nav class="main-nav <?php echo $adapt_dev_nav_align == 'center' ? 'nav-center' : ''; ?>">
	<?php
	if ( $adapt_dev_primary_nav == '1' ) :
		wp_nav_menu(
			array(
				'menu'              => $adapt_dev_header_menu, // If set to '', will fallback to the location given
				'theme_location'    => 'primary',
				'menu_class'        => 'menu',
				'container'         => '',
			)
		);
		if ( $adapt_dev_primary_toggle !== false ) :
			echo '<button class="header-search"><i class="fas fa-search" aria-hidden="true"></i></button>';
		endif;
	endif;
	?>
	<?php if ( $adapt_dev_header_layout == 'two' ) : ?>
		<div class="site-header__widget-area">
			<?php get_template_part( 'template-parts/header-widget-area', '', ); ?>
		</div>
	<?php endif; ?>
</nav>
