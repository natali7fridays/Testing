<?php
/**
 * Content for a post
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

 //phpcs:disable WordPress.NamingConventions.PrefixAllGlobals

$today           = gmdate( 'w' );
$hours           = get_field( 'hours' );
$location_status = 'closed';
$open            = '';
$close           = '';
if ( $hours ) :
	foreach ( $hours as $hour ) {
		if ( $hour['day'] == $today ) {
			if ( $hour['status'] ) {
				$location_status = 'open';
				$open            = $hour['opening'];
				$close           = $hour['closing'];
			}
		}
	}
endif;
?>

<article id="location-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<div class="location-thumb">
		<div class="image-container">
			<?php
			if ( has_post_thumbnail( $post->ID ) ) {
				the_post_thumbnail( 'large' );
			} else {
				$thumbnail = get_field( 'sitewide_placeholder_image', 'option' );
				if ( ! empty( $thumbnail ) ) {
					$testing = wp_get_attachment_image( $thumbnail, 'large' );
					echo esc_html( $testing );
				}
			}
			?>
			<span class="icon"><i class="fas fa-map-marker-alt"></i></span>
		</div>
	</div>
	<div class="location-title">
		<h3><?php the_title(); ?></h3>
	</div>
	<div class="location-contact">
		<p><?php the_field( 'address' ); ?></p>
		<a href="tel:<?php the_field( 'phone' ); ?>"><?php the_field( 'phone' ); ?></a>
	</div>
	<div class="location-hours">
		<?php
		$status_text = $location_status;
		if ( $location_status != 'closed' ) :
			$status_text = $location_status . ' - ' . $open . ' to ' . $close;
			else :
				$status_text = 'Hours';
		endif;
			?>
		<button class="hours-toggler <?php echo esc_html( $location_status ); ?>" data-location-id="<?php the_ID(); ?>"><?php echo esc_html( $status_text ); ?>  <i class="fas fa-sort-down"></i></button>
		<div class="location-hours--list" id="hours-list-<?php the_ID(); ?>" style="display:none;">
			<?php
			if ( $hours ) :
				foreach ( $hours as $hour ) {
					$day         = jddayofweek( $hour['day'] - 1, 2 );
					$status_text = $hour['status'] ? $hour['opening'] . ' to ' . $hour['closing'] : 'closed';
					$class       = $hour['day'] == $today ? 'bold' : '';

					echo '<p class="' . esc_html( $class ) . '"><span>' . esc_html( $day ) . '</span> - ' . esc_html( $status_text ) . '</p>';
				}
			else :
				echo '<p>Call us for open hours.</p>';
			endif;
			?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
