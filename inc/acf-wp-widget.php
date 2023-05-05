<?php
// phpcs:ignoreFile
/**
 * A custom ACF widget.
 */
class ACF_Custom_Widget extends WP_Widget {

	/**
	* Register widget with WordPress.
	*/
	function __construct() {
		parent::__construct(
			'acf_wp_widget', // Base ID
			__( 'AdaptDev Widget', 'text_domain' ), // Name
			array(
				'description' => __( 'A multi-purpose widget for AdaptDev', 'text_domain' ), 
				'classname'   => 'acf-wp-widget',
			) // Args
		);
	}

	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args     Widget arguments.
	* @param array $instance Saved values from database.
	*/
	public function widget( $args, $instance ) {
		global $adapt_dev_config;

		echo $args['before_widget'];
		if ( !empty( $instance['title' ] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$widget_type = get_field( 'wp_widget_type', 'widget_' . $args['widget_id'] );

		$links           = get_field( 'wp_widget_links', 'widget_' . $args['widget_id'] );
		$logo            = $adapt_dev_config['footer_logo'];
		$contact         = get_field( 'wp_widget_contact', 'widget_' . $args['widget_id'] );
		$contact_content = get_field( 'wp_widget_contact_widget_content', 'widget_' . $args['widget_id'] );

		$address_options = get_field( 'wp_widget_address_options', 'widget_' . $args['widget_id'] );

		$address_phone = $adapt_dev_config['phone'];
		$address_email = $adapt_dev_config['email'];

		echo get_field( 'title', 'widget_' . $args['widget_id'] );
		?>

		<!-- Footer logo widget type -->
		<?php if ( $logo && $widget_type == 'logo') : ?>
			<div class="acf-wp-widget__logo">
				<?php
				$image_id   = $logo;
				$image_size = 'medium';
				$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

				echo wp_get_attachment_image( $image_id, $image_size, false, array( 'alt' => $image_alt ) );
				?>
			</div>
		<?php endif; ?>

		<!-- Address widget type -->
		<?php if ( $widget_type == 'address' ) : ?>
			<div class="acf-wp-widget__address">
				<a href="<?php adapt_dev_the_address_url(); ?>" target="_blank">
					<?php adapt_dev_the_address(); ?>
				</a>
				<?php if ( $address_options ) : ?>
					<div class="address-contact-info">
						<?php if ( in_array( 'phone', $address_options ) ) : ?>
							<div class="address-contact-info__phone">
								<i class="fas fa-phone-alt"></i>
								<a href="tel:<?php echo esc_html( $address_phone ); ?>"><?php echo esc_html( $address_phone ); ?></a>
							</div>
						<?php endif; ?>

						<?php if ( in_array( 'email', $address_options ) ) : ?>
							<div class="address-contact-info__email">
								<i class="fas fa-envelope"></i>
								<a href="mailto:<?php echo esc_html( $address_email ); ?>" class="address-contact-info__email"><?php echo esc_html( $address_email ); ?></a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<!-- Links widget type -->
		<?php if ( $links && $widget_type == 'links') : ?>
			<div class="acf-wp-widget__links">
				<ul>
					<?php foreach ( $links as $link ) : ?>
						<?php if ( $link['link'] ) : ?>
							<?php $link = $link['link']; ?>
							<li>
								<a href="<?php echo esc_html( $link['url'] ); ?>">
									<?php echo esc_html( $link['title'] ); ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<!-- Contact widget type -->
		<?php if ( $contact && $widget_type == 'contact') : ?>
			<div class="acf-wp-widget__contact">
				<ul>

					<?php if ( in_array('phone', $contact_content) ) : ?>
						<?php $contact_phone = $contact['phone']; ?>
						<li class="contact-phone">
							<div class="contact-icon">
								<i class="fas fa-phone-alt"></i>
							</div>
							<div class="contact-phone__text">
								<?php if ( $contact_phone['title'] ) : ?>
									<h5><?php echo esc_html( $contact_phone['title'] ); ?></h5>
								<?php endif; ?>

								<?php if ( $contact_phone['number'] ) : ?>
									<a href="tel:<?php echo esc_html( $contact_phone['number'] ); ?>">
										<?php echo esc_html( $contact_phone['number'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						</li>
					<?php endif; ?>

					<?php if ( in_array('fax', $contact_content) ) : ?>
						<?php $contact_fax = $contact['fax'] ;?>
						<li class="contact-fax">
							<div class="contact-icon">
								<i class="fas fa-fax"></i>
							</div>
							<div class="contact-fax__text">
								<?php if ( $contact_fax['title'] ) : ?>
									<h5><?php echo esc_html( $contact_fax['title'] ); ?></h5>
								<?php endif; ?>

								<?php if ( $contact_fax['number'] ) : ?>
									<a href="fax:<?php echo esc_html( $contact_fax['number'] ); ?>">
										<?php echo esc_html( $contact_fax['number'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						</li>
					<?php endif; ?>

					<?php if ( in_array('email', $contact_content) ) : ?>
						<?php $contact_email = $contact['email'] ;?>
						<li class="contact-email">
							<div class="contact-icon">
								<i class="fas fa-envelope"></i>
							</div>
							<div class="contact-email__text">
								<?php if ( $contact_email['title'] ) : ?>
									<h5><?php echo esc_html( $contact_email['title'] ); ?></h5>
								<?php endif; ?>

								<?php if ( $contact_email['email_address'] ) : ?>
									<a href="mailto:<?php echo esc_html( $contact_email['email_address'] ); ?>">
										<?php echo esc_html( $contact_email['email_address'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						</li>
					<?php endif; ?>

					<?php if ( in_array('address', $contact_content) ) : ?>
						<?php $contact_address = $contact['address'] ;?>
						<li class="contact-address">
							<div class="contact-icon">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<div class="contact-address__text">
								<?php if ( $contact_address['title'] ) : ?>
									<h5><?php echo esc_html( $contact_address['title'] ); ?></h5>
								<?php endif; ?>

								<a href="<?php adapt_dev_the_address_url(); ?>" target="_blank">
									<?php adapt_dev_the_address(); ?>
								</a>
							</div>
						</li>
					<?php endif; ?>

				</ul>
			</div>
		<?php endif; ?>

		<!-- Social Icons widget type -->
		<?php if ( $contact && $widget_type == 'social') :
			adapt_dev_the_social_icons();
		endif; ?>

		<?php 
		echo $args['after_widget'];
	}

	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) {
		$title = $instance['title'] ?? '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class ACF_Custom_Widget

// register ACF_Custom_Widget widget
add_action(
	'widgets_init',
	function() {
		register_widget( 'ACF_Custom_Widget' );
	}
);
