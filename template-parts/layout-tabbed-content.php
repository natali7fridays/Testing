<?php
/**
 * Accordion flexible content layout
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$tabbed_content = get_sub_field( 'tabbed_content' );

?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>

	<div class="tabbed-content">

			<?php if ( $tabbed_content ) : ?>
				<nav class="tabbed-content__tab-list">
					<?php $i = 1; ?>
					<ul class="menu">
						<?php foreach ( $tabbed_content as $tabbed_content_tab ) : ?>

							<?php if ( $tabbed_content_tab['summary'] ) : ?>
								<li class="menu-item tab tab-<?php echo esc_attr( $i ); ?>" role="button" aria-controls="tab-content-<?php echo esc_attr( $i ); ?>" data-target="tab-content-<?php echo esc_attr( $i ); ?>" tabindex="0">
									<?php echo esc_html( $tabbed_content_tab['summary'] ); ?>
									<i class="fas fa-chevron-down"></i>
								</li>
							<?php endif; ?>
							<?php $i++; ?>

						<?php endforeach; ?>
						<?php unset( $i ); ?>
					</ul>

					<?php $i = 1; ?>
					<select class="tabbed-content__tab-select">
						<?php foreach ( $tabbed_content as $tabbed_content_tab ) : ?>

							<?php if ( $tabbed_content_tab['summary'] ) : ?>
								<option value="tab-content-<?php echo esc_attr( $i ); ?>" data-content="tab-<?php echo esc_attr( $i ); ?>">
									<?php echo esc_html( $tabbed_content_tab['summary'] ); ?>
								</option>
							<?php endif; ?>
							<?php $i++; ?>
						<?php endforeach; ?>
						<?php unset( $i ); ?>
					</select>
				</nav><!--.tabbed-content__tab-list-->

				<?php $i = 1; ?>

				<div class="tabbed-content__content-list">

					<?php foreach ( $tabbed_content as $the_tab_content ) : ?>

						<?php if ( $the_tab_content['entry-content'] ) : ?>
							<div class="tab-details entry-content tab-content-<?php echo esc_attr( $i ); ?>" aria-labelledby="tab-<?php echo esc_attr( $i ); ?>" >
								<?php echo wp_kses_post( $the_tab_content['entry-content'] ); ?>
							</div>
						<?php endif; ?>

						<?php $i++; ?>
					<?php endforeach; ?>

				</div><!--.tabbed-content__content-list-->

			<?php endif; ?>

	</div><!--.tabbed-content-->

</section>
