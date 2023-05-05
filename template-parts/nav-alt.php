<?php
/**
 * Template nav part for alt (secondary) nav option.
 *
 * @package adaptdev/base
 */

global $adapt_dev_config;

$adapt_dev_secondary_toggle = $adapt_dev_config['header_search_secondary_menu_toggle'];

?>

<nav class="secondary-nav">
	<?php
	wp_nav_menu(
		array(
			'theme_location'    => 'secondary',
			'menu_class'        => 'menu',
			'container'         => '',
		)
	);

	if ( $adapt_dev_secondary_toggle == true ) :
		echo '<button class="header-search"><i class="fas fa-search" aria-hidden="true"></i></button>';
	endif;
	?>
</nav>
