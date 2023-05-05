<?php
/**
 * Search Form template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

?>

<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input class="search-form__input" type="search" placeholder="Search..." value="" name="s" id="s">
		<button class="search-form__submit" type="submit"><span class="sr-only">Search</span><i class="fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>
