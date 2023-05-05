<?php
/**
 * Widget Library page template
 *
 * A page template thats static for the purposes of displaying content widgets.
 *
 * @package adaptdev/base
 */

//phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Add specific CSS class by filter.
add_filter(
	'body_class',
	function( $classes ) {
		return array_merge( $classes, array( 'widget-library-template' ) );
	}
);

$widget_lib_images = ADAPT_DEV_IMAGES . '/widget-library/';
?>

<?php get_header(); ?>

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 ) : ?>
		<header class="entry-header <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> <?php echo $adapt_dev_featured_img_url ? 'has-bg-img' : ''; ?>"

		<?php if ( $adapt_dev_featured_img_url ) : ?>
			style="--entry-background-image:url(<?php echo esc_html( $adapt_dev_featured_img_url[0] ); ?>);"
		<?php endif; ?>	

		><!--header-->
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<?php do_action( 'adapt_dev_content_before' ); ?>
	<main class="main-content" id="content" role="main">
		<?php do_action( 'adapt_dev_content_top' ); ?>

		<!-- Cards layout -->
		<div class="cards-widget-layout view-select-container">
			<?php
				$cards_layout_1 = uniqid();
				$cards_layout_2 = uniqid();
				$cards_layout_3 = uniqid();
				$cards_layout_4 = uniqid();

			?>
			<h2 class="flex-layout__heading gutter vertical-spacing center">Cards</h2>
			<h3 class="button-action-text gutter center">Choose card style</h3>
			<div class="card-layout-btn-group layout-btn-group">
				<button class="btn active" layout="<?php echo esc_html( $cards_layout_1 ); ?>">Polaroid</button>
				<button class="btn" layout="<?php echo esc_html( $cards_layout_2 ); ?>">Call to Action</button>
				<button class="btn" layout="<?php echo esc_html( $cards_layout_3 ); ?>">Feature</button>
				<button class="btn" layout="<?php echo esc_html( $cards_layout_4 ); ?>">Postcard</button>
			</div>

			<section class="acf-flex-layout layout--cards" layout="<?php echo esc_html( $cards_layout_1 ); ?>">
				<div class="rows">
					<div class="bg-off-light text-center card card--polaroid">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-pol-1.jpg' ); ?>" class="card__img" alt="" loading="lazy">
						<h3 class="card__heading"><a href="#">Headline Text</a></h3>
						<p class="text-uppercase card__subheading">Sub Headline</p>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
						<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
					</div><!--.card-->

					<div class="bg-off-light text-center card card--polaroid">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-pol-2.jpg' ); ?>" class="card__img" alt="" loading="lazy">
						<h3 class="card__heading"><a href="#">Headline Text</a></h3>
						<p class="text-uppercase card__subheading">Sub Headline</p>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
						<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
					</div><!--.card-->

					<div class="bg-off-light text-center card card--polaroid">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-pol-3.jpg' ); ?>" class="card__img" alt="" loading="lazy">
						<h3 class="card__heading"><a href="#">Headline Text</a></h3>
						<p class="text-uppercase card__subheading">Sub Headline</p>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
						<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
					</div><!--.card-->
				</div>
			</section>

			<section class="acf-flex-layout layout--cards hidden" layout="<?php echo esc_html( $cards_layout_2 ); ?>">
				<div class="rows">
					<div class="card card--cta">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-cta-1.jpg' ); ?>" class="card__img" alt="" loading="lazy" />
						<div class="text-center card__content">
							<h3 class="card__heading"><a href="#">Headline Text</a></h3>
							<div class="card__text">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
							</div><!--.card__text-->
							<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
						</div>
					</div><!--.card-->

					<div class="card card--cta">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-cta-2.jpg' ); ?>" class="card__img" alt="" loading="lazy" />
						<div class="text-center card__content">
							<h3 class="card__heading"><a href="#">Headline Text</a></h3>
							<div class="card__text">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
							</div><!--.card__text-->
							<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
						</div>
					</div><!--.card-->

					<div class="card card--cta">
						<img width="290" height="193" src="<?php echo esc_attr( $widget_lib_images . 'cards-cta-3.jpg' ); ?>" class="card__img" alt="" loading="lazy" />
						<div class="text-center card__content">
							<h3 class="card__heading"><a href="#">Headline Text</a></h3>
							<div class="card__text">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
							</div><!--.card__text-->
							<a class="text-uppercase card__link" href="#" target="">Call to Action</a>
						</div>
					</div><!--.card-->
				</div>
			</section>

			<section class="acf-flex-layout layout--cards hidden" layout="<?php echo esc_html( $cards_layout_3 ); ?>">
				<div class="rows">
					<div class="text-center card card--feature">
						<div class="card__icon"><i class="far fa-globe" aria-hidden="true"></i></div>
						<h3 class="card__heading text-uppercase">Headline Text</h3>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
					</div><!--.card-->

					<div class="text-center card card--feature">
						<div class="card__icon"><i class="fas fa-cog" aria-hidden="true"></i></div>
						<h3 class="card__heading text-uppercase">Headline Text</h3>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
					</div><!--.card-->

					<div class="text-center card card--feature">
						<div class="card__icon"><i class="fas fa-lightbulb" aria-hidden="true"></i></div>
						<h3 class="card__heading text-uppercase">Headline Text</h3>
						<div class="card__text">
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
						</div><!--.card__text-->
					</div><!--.card-->
				</div>
			</section>

			<section class="acf-flex-layout layout--cards hidden" layout="<?php echo esc_html( $cards_layout_4 ); ?>">
				<div class="rows">
					<div class="bg-off-light text-center card card--postcard" style="background-image: url( <?php echo esc_attr( $widget_lib_images . 'cards-post-1.jpg' ); ?> );">
						<h2 class="card__heading"><a href="#">Headline Text</a></h2>
						<a class="text-uppercase card__link" href="#" target="_self">
							<div class="card__icon"><i class="fas fa-plus" aria-hidden="true"></i></div>
						</a>
					</div><!--.card-->

					<div class="bg-off-light text-center card card--postcard" style="background-image: url( <?php echo esc_attr( $widget_lib_images . 'cards-post-2.jpg' ); ?> );">
						<h2 class="card__heading"><a href="#">Headline Text</a></h2>
						<a class="text-uppercase card__link" href="#" target="_self">
							<div class="card__icon"><i class="fas fa-plus" aria-hidden="true"></i></div>
						</a>
					</div><!--.card-->

					<div class="bg-off-light text-center card card--postcard" style="background-image: url( <?php echo esc_attr( $widget_lib_images . 'cards-post-3.jpg' ); ?> );">
						<h2 class="card__heading"><a href="#">Headline Text</a></h2>
						<a class="text-uppercase card__link" href="#" target="_self">
							<div class="card__icon"><i class="fas fa-plus" aria-hidden="true"></i></div>
						</a>
					</div><!--.card-->
				</div>
			</section>

		</div>

		<!-- Testimonial Cards -->
		<section class="acf-flex-layout layout--testimonials">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Testimonial Cards</h2>
			</div>
			<ul class="testimonial-slides testimonials">
				<li class="testimonial testimonials__slide">
					<span class="testimonial__text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma.</span>
					<div class="testimonial__author">
						<div class="testimonial__author__name">Author Name</div>
						<div class="testimonial__author__info">Author Info</div>
					</div>
				</li>
				<li class="testimonial testimonials__slide">
					<span class="testimonial__text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma.</span>
					<div class="testimonial__author">
						<div class="testimonial__author__name">Author Name</div>
						<div class="testimonial__author__info">Author Info</div>
					</div>
				</li>
				<li class="testimonial testimonials__slide">
					<span class="testimonial__text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore ma.</span>
					<div class="testimonial__author">
						<div class="testimonial__author__name">Author Name</div>
						<div class="testimonial__author__info">Author Info</div>
					</div>
				</li>
			</ul>
		</section>

		<!-- Blog widget -->
		<section class="acf-flex-layout layout--featured-posts neutral-1 has-bg-color">
			<?php
				$blog_img_1 = ADAPT_DEV_IMAGES . '/widget-library/blog-img-1.jpeg';
				$blog_img_2 = ADAPT_DEV_IMAGES . '/widget-library/blog-img-2.jpeg';
			?>
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Blog Feature</h2>
			</div>
			<div class="card-grid">
				<article id="post-558" class="post-558 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized" role="article">
					<div class="thumb">
						<a href="#">
							<img src="<?php echo esc_attr( $blog_img_1 ); ?>" class="attachment-medium size-medium wp-post-image" alt="" loading="lazy">
						</a>
					</div><!-- thumb -->
					<div class="the-content post-content">
						<header class="post-header">
							<h2 class="post-title"><a href="#" title="Blog Title">Blog Title</a></h2>
						</header>

						<div class="entry-content">
							Numquam autem at reprehenderit autem. Rem dolorem consequatur sit et voluptate Ex Temporibus maxime qui eaque...
						</div>

						<div class="learn-more"><a href="#" class="entry__cta btn" title="Blog Title" rel="bookmark">Read More</a></div>
					</div>

				</article><!-- #post-558 -->

				<article id="post-535" class="post-535 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized" role="article">
					<div class="thumb">
						<a href="#">
							<img src="<?php echo esc_attr( $blog_img_2 ); ?>" class="attachment-medium size-medium wp-post-image" alt="" loading="lazy">
						</a>
					</div><!-- thumb -->
					<div class="the-content post-content">
						<header class="post-header">
							<h2 class="post-title"><a href="#" title="Blog Title">Blog Title</a></h2>
						</header>

						<div class="entry-content">
							Numquam autem at reprehenderit autem. Rem dolorem consequatur sit et voluptate Ex Temporibus maxime qui eaque...
						</div>
						<div class="learn-more"><a href="#" class="entry__cta btn" rel="bookmark">Read More</a></div>
					</div>

				</article><!-- #post-535 -->
			</div><!--.card-grid-->
		</section>

		<!-- Accordion / FAQs -->
		<section class="acf-flex-layout layout--accordion">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Accordion / FAQs</h2>
			</div>
			<div class="accordion-list">
				<details class="accordion-item details accordion">
					<summary><h3 id="summary-62151e7265aa9" role="button" aria-expanded="false" aria-controls="details-62151e7265aaa" data-target="details-62151e7265aaa" class="heading summary">This is a question?</h3></summary>
					<div id="details-62151e7265aaa" aria-labelledby="summary-62151e7265aa9" class="details__content">
						<div class="entry-content">
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia a voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. El Neque porro quisquam est, qui dolorem ipsum quia dolor sit.</p>
						</div>
					</div>
				</details><!--.accordion-->

				<details class="accordion-item details accordion">
					<summary><h3 id="summary-62151e7265cc2" role="button" aria-expanded="false" aria-controls="details-62151e7265cc4" data-target="details-62151e7265cc4" class="heading summary">This is a question?</h3></summary>
					<div id="details-62151e7265cc4" aria-labelledby="summary-62151e7265cc2" class="details__content">
						<div class="entry-content">
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia a voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. El Neque porro quisquam est, qui dolorem ipsum quia dolor sit.</p>
						</div>
					</div>
				</details><!--.accordion-->

				<details class="accordion-item details accordion" open>
					<summary><h3 id="summary-62151e7265eab" role="button" aria-expanded="false" aria-controls="details-62151e7265eac" data-target="details-62151e7265eac" class="heading summary">This is a question?</h3></summary>
					<div id="details-62151e7265eac" aria-labelledby="summary-62151e7265eab" class="details__content">
						<div class="entry-content">
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia a voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. El Neque porro quisquam est, qui dolorem ipsum quia dolor sit.</p>
						</div>
					</div>
				</details><!--.accordion-->
			</div>

		</section>

		<!-- Billboard -->
		<section class="acf-flex-layout layout--billboard neutral-1 has-bg-color billboard--image layout__text-media">
			<?php
				$billboard_img = ADAPT_DEV_IMAGES . '/widget-library/billboard-img.jpeg';
			?>
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Billboard</h2>
			</div>
			<div class="billboard-container">
				<div class="billboard__content">
						<h2 class="billboard__headline">This is a heading</h2>
						<h5 class="billboard__subheading">This is a subheading</h5>
						<p class="billboard__message">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exe rcitation ullamco laboris nisi ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					<div class="billboard__cta-container">
						<a href="#" class="btn-primary color-1">Call to Action</a>
					</div>
				</div>
				<div class="billboard__media">
					<img width="375" height="437" src="<?php echo esc_attr( $billboard_img ); ?>" class="attachment-large size-large" alt="" loading="lazy" />
				</div>
			</div>
		</section>

		<!-- Video -->
		<section class="acf-flex-layout layout--video">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Video</h2>
			</div>
			<div class="video__container">
				<?php get_template_part( 'template-parts/partials/video-widget-library' ); ?>
			</div>
		</section>
		<section class="acf-flex-layout layout--billboard billboard--video layout__media-text">
			<div class="billboard-container">
				<div class="billboard__content">
						<h2 class="billboard__headline">This is a heading</h2>
						<h5 class="billboard__subheading">This is a subheading</h5>
						<p class="billboard__message">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exe rcitation ullamco laboris nisi ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					<div class="billboard__cta-container">
						<a href="#" class="btn-primary color-1">Call to Action</a>
					</div>
				</div>
				<div class="billboard__media">
					<?php
						$video_2_args = array(
							'poster_url' => $widget_lib_images . 'video-2.jpg',
							'embed_url'  => 'https://www.youtube.com/watch?v=G1hKzCkywM8',
						);
						get_template_part( 'template-parts/partials/video-widget-library', '', $video_2_args );
						?>
				</div>
			</div>
		</section>

		<!-- Form and Lists -->
		<section class="acf-flex-layout layout--two-column neutral-1 has-bg-color">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Form / Lists</h2>
			</div>
			<div class="row vertical-align-center">
				<div class="col">
					<section class="acf-flex-layout layout--gravity-form">
						<div class="layout--gravity-form--form-wrap">
							<div class="gf_browser_chrome gform_wrapper gravity-theme" id="gform_wrapper_1">
								<div id="gf_1" class="gform_anchor" tabindex="-1"></div>
								<div class="gform_heading">
									<h2 class="gform_title">This is a Headline</h2>
									<span class="gform_description">Lorem ipsum dolor sit amet, consetetur a sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magn aliquyam era zod mal elixorate.</span>
								</div>
								<form id="gform_1">
									<div class="gform_body gform-body">
										<div id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">
											<fieldset id="field_1_1" class="gfield gfield--width-full field_sublabel_hidden_label field_description_below gfield_visibility_visible">
												<legend class="gfield_label gfield_label_before_complex">Name</legend>
												<div class="ginput_complex ginput_container no_prefix has_first_name no_middle_name has_last_name no_suffix gf_name_has_2 ginput_container_name" id="input_1_1">
													<span id="input_1_1_3_container" class="name_first">
													<input type="text" name="input_1.3" id="input_1_1_3" value="" aria-required="false" placeholder="First Name" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
													<label for="input_1_1_3" class="hidden_sub_label screen-reader-text">First</label>
													</span>
													<span id="input_1_1_6_container" class="name_last">
													<input type="text" name="input_1.6" id="input_1_1_6" value="" aria-required="false" placeholder="Last Name">
													<label for="input_1_1_6" class="hidden_sub_label screen-reader-text">Last</label>
													</span>
												</div>
											</fieldset>
											<div id="field_1_2" class="gfield gfield--width-half gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible">
												<label class="gfield_label" for="input_1_2">Email<span class="gfield_required"><span class="gfield_required gfield_required_asterisk">*</span></span></label>
												<div class="ginput_container ginput_container_email">
													<input name="input_2" id="input_1_2" type="text" value="" class="large" placeholder="Email Address" aria-required="true" aria-invalid="false">
												</div>
											</div>
											<div id="field_1_3" class="gfield gfield--width-half field_sublabel_below field_description_below gfield_visibility_visible">
												<label class="gfield_label" for="input_1_3">Phone</label>
												<div class="ginput_container ginput_container_phone"><input name="input_3" id="input_1_3" type="text" value="" class="large" placeholder="(555) 555-5555" aria-invalid="false"></div>
											</div>
										</div>
									</div>
									<div class="gform_footer top_label">
										<a href="#" class="btn btn-primary">Call to Action</a>
									</div>
								</form>
							</div>
						</div>
					</section>
				</div>
				<div class="col">
					<section class="acf-flex-layout layout--entry-content ">
						<div class="entry-content">
							<p>Unordered List</p>
							<ul>
								<li>Sed ut perspiciatis unde omnis iste</li>
								<li>Lorem ipsum dolor sit amet consetetur</li>
								<li>Sed ut perspiciatis unde omnis iste</li>
								<li>Lorem ipsum dolor sit amet consetetur</li>
							</ul>
							<p>&nbsp;</p>
							<p>Ordered List</p>
							<ol>
								<li>Sed ut perspiciatis unde omnis iste</li>
								<li>Lorem ipsum dolor sit amet consetetur</li>
								<li>Sed ut perspiciatis unde omnis iste</li>
								<li>Lorem ipsum dolor sit amet consetetur</li>
							</ol>
						</div>
					</section>
				</div>
			</div>
		</section>

		<!-- Locations -->
		<div class="locations-widget-layout view-select-container">
			<?php
				$locations_layout_1 = uniqid();
				$locations_layout_2 = uniqid();

				$location_img_1 = ADAPT_DEV_IMAGES . '/widget-library/location-1.jpeg';
				$location_img_2 = ADAPT_DEV_IMAGES . '/widget-library/location-2.jpeg';
				$location_img_3 = ADAPT_DEV_IMAGES . '/widget-library/location-3.jpeg';
				$location_img_4 = ADAPT_DEV_IMAGES . '/widget-library/location-cards-1.jpg';
				$location_img_5 = ADAPT_DEV_IMAGES . '/widget-library/location-cards-2.jpg';
				$location_img_6 = ADAPT_DEV_IMAGES . '/widget-library/location-cards-3.jpg';
			?>
			<h2 class="flex-layout__heading gutter vertical-spacing center">Locations</h2>
			<h3 class="button-action-text gutter center">Choose location style</h3>
			<div class="locations-layout-btn-group layout-btn-group">
				<button class="btn active" layout="<?php echo esc_html( $locations_layout_1 ); ?>">List View</button>
				<button class="btn" layout="<?php echo esc_html( $locations_layout_2 ); ?>">Card View</button>
			</div>
			<section class="acf-flex-layout layout--locations layout-style__list" layout="<?php echo esc_html( $locations_layout_1 ); ?>">
				<div class="locations-listing list">
					<article id="location-1405" class="post-1405 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_1 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Little Rock, AR</h3>
						</div>
						<div class="location-contact">
							<p>2300 COTTONDALE LANE, STE. 300<br>
								Little Rock, AR 72202
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1405">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1405" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1405 -->
					<article id="location-1406" class="post-1406 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_2 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Northwest Arkansas</h3>
						</div>
						<div class="location-contact">
							<p>1800 S Osage Spring Dr, Ste. 225<br>
								Rogers, Arkansas 72758
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1406">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1406" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1406 -->
					<article id="location-1407" class="post-1407 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_3 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Tampa, FL</h3>
						</div>
						<div class="location-contact">
							<p>401 Channelside Dr<br>
								Tampa, FL 33602
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1407">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1407" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1407 -->
				</div>
				<!--.card-grid-->
			</section>
			<section class="acf-flex-layout layout--locations layout-style__grid hidden" layout="<?php echo esc_html( $locations_layout_2 ); ?>">
				<div class="locations-listing grid">
					<article id="location-1405" class="post-1405 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_4 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Little Rock, AR</h3>
						</div>
						<div class="location-contact">
							<p>2300 COTTONDALE LANE, STE. 300<br>
								Little Rock, AR 72202
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1405">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1405" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1405 -->
					<article id="location-1406" class="post-1406 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_5 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Northwest Arkansas</h3>
						</div>
						<div class="location-contact">
							<p>1800 S Osage Spring Dr, Ste. 225<br>
								Rogers, Arkansas 72758
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1406">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1406" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1406 -->
					<article id="location-1407" class="post-1407 adapt_dev_locations type-adapt_dev_locations status-publish has-post-thumbnail hentry" role="article">
						<div class="location-thumb">
							<div class="image-container">
								<img width="546" height="364" src="<?php echo esc_attr( $location_img_6 ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">
								<span class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="location-title">
							<h3>Tampa, FL</h3>
						</div>
						<div class="location-contact">
							<p>401 Channelside Dr<br>
								Tampa, FL 33602
							</p>
							<a href="tel:555-555-5555">555-555-5555</a>
						</div>
						<div class="location-hours">
							<button class="hours-toggler open" data-location-id="1407">open - 8:00 am to 5:00 pm  <i class="fas fa-sort-down" aria-hidden="true"></i></button>
							<div class="location-hours--list" id="hours-list-1407" style="display:none;">
								<p class=""><span>Mon</span> - 8:00 am to 5:00 pm</p>
								<p class="bold"><span>Tue</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Wed</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Thu</span> - 8:00 am to 5:00 pm</p>
								<p class=""><span>Fri</span> - 8:00 am to 5:00 pm</p>
							</div>
						</div>
					</article>
					<!-- #post-1407 -->
				</div>
				<!--.card-grid-->
			</section>
		</div>

		<!-- Offers -->
		<section class="acf-flex-layout layout--offers neutral-1 has-bg-color">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Offers</h2>
			</div>
			<div class="rows">
				<div class="card card--">
					<h3 class="card__heading">This is a Headline</h3>
					<div class="card__text">
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem laudantium, totam rem aperiam, eaque.</p>
					</div>
					<!--.card__text-->
				</div>
				<!--.card-->
				<div class="card card--">
					<h3 class="card__heading">This is a Headline</h3>
					<div class="card__text">
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem laudantium, totam rem aperiam, eaque.</p>
					</div>
					<!--.card__text-->
				</div>
				<!--.card-->
			</div>
		</section>

		<!-- Price Block -->
		<section class="acf-flex-layout layout--two-column">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Price Block</h2>
			</div>
			<div class="row vertical-align-center">
				<div class="col">
					<section class="acf-flex-layout layout--prices ">
						<div class="prices-list">
							<div class="price-row">
								<div class="entry-title">
									<h3 style="text-align: left;">This is a pricing headline</h3>
									&nbsp;
									<span class="price">$99</span>
								</div>
								<hr>
								<p>Sed ut perspiciatis unde omnis iste natus error sit volupta accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi.</p>
							</div>
						</div>
						<!--.card-grid-->
					</section>
				</div>
				<div class="col">
					<section class="acf-flex-layout layout--prices ">
						<div class="prices-list">
							<div class="price-row">
								<div class="entry-title">
									<h3 style="text-align: left;">This is a pricing headline</h3>
									&nbsp;
									<span class="price">$99</span>
								</div>
								<hr>
								<p>Sed ut perspiciatis unde omnis iste natus error sit volupta accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi.</p>
							</div>
						</div>
						<!--.card-grid-->
					</section>
				</div>
			</div>
		</section>

		<!-- Tabbed Content -->
		<section class="acf-flex-layout layout--tabbed-content neutral-1 has-bg-color">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Tabbed Content</h2>
			</div>
			<div class="tabbed-content">
				<nav class="tabbed-content__tab-list">
					<ul class="menu">
						<li class="menu-item tab tab-1 active" role="button" aria-controls="tab-content-1" data-target="tab-content-1" tabindex="0">
							Tab Lorem 1									<i class="fas fa-chevron-down" aria-hidden="true"></i>
						</li>
						<li class="menu-item tab tab-2" role="button" aria-controls="tab-content-2" data-target="tab-content-2" tabindex="0">
							Tab Lorem 2									<i class="fas fa-chevron-down" aria-hidden="true"></i>
						</li>
						<li class="menu-item tab tab-3" role="button" aria-controls="tab-content-3" data-target="tab-content-3" tabindex="0">
							Tab Lorem 3									<i class="fas fa-chevron-down" aria-hidden="true"></i>
						</li>
						<li class="menu-item tab tab-4" role="button" aria-controls="tab-content-4" data-target="tab-content-4" tabindex="0">
							Tab Lorem 4									<i class="fas fa-chevron-down" aria-hidden="true"></i>
						</li>
					</ul>
					<select class="tabbed-content__tab-select">
						<option value="tab-content-1" data-content="tab-1">
							Tab Lorem 1								
						</option>
						<option value="tab-content-2" data-content="tab-2">
							Tab Lorem 2								
						</option>
						<option value="tab-content-3" data-content="tab-3">
							Tab Lorem 3								
						</option>
						<option value="tab-content-4" data-content="tab-4">
							Tab Lorem 4								
						</option>
					</select>
				</nav>
				<!--.tabbed-content__tab-list-->
				<div class="tabbed-content__content-list">
					<div class="tab-details entry-content tab-content-1" aria-labelledby="tab-1" style="">
						<h2>Lorem Ipsum</h2>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<h3>Dolor Amet Sit</h3>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
					</div>
					<div class="tab-details entry-content tab-content-2" aria-labelledby="tab-2" style="display: none;">
						<h2>Lorem Ipsum</h2>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<h3>Dolor Amet Sit</h3>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
					</div>
					<div class="tab-details entry-content tab-content-3" aria-labelledby="tab-3" style="display: none;">
						<h2>Lorem Ipsum</h2>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<h3>Dolor Amet Sit</h3>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
					</div>
					<div class="tab-details entry-content tab-content-4" aria-labelledby="tab-4" style="display: none;">
						<h2>Lorem Ipsum</h2>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<h3>Dolor Amet Sit</h3>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia ella voluptas sit aspernatur aut odit aut fugit, sed quia?</p>
					</div>
				</div>
				<!--.tabbed-content__content-list-->
			</div>
			<!--.tabbed-content-->
		</section>

		<!-- Team Members -->
		<div class="team-widget-layout view-select-container">
			<?php
				$team_layout_1 = uniqid();
				$team_layout_2 = uniqid();

				$team_1_img = ADAPT_DEV_IMAGES . '/widget-library/team-1.jpeg';
				$team_2_img = ADAPT_DEV_IMAGES . '/widget-library/team-2.jpeg';
				$team_3_img = ADAPT_DEV_IMAGES . '/widget-library/team-3.jpeg';
				$team_4_img = ADAPT_DEV_IMAGES . '/widget-library/team-rows-1.jpg';
				$team_5_img = ADAPT_DEV_IMAGES . '/widget-library/team-rows-2.jpg';
				$team_6_img = ADAPT_DEV_IMAGES . '/widget-library/team-rows-3.jpg';
			?>
			<h2 class="flex-layout__heading gutter vertical-spacing center">Team</h2>
			<h3 class="button-action-text gutter center">Choose team style</h3>
			<div class="team-layout-btn-group layout-btn-group">
				<button class="btn active" layout="<?php echo esc_html( $team_layout_1 ); ?>">Grid Layout</button>
				<button class="btn" layout="<?php echo esc_html( $team_layout_2 ); ?>">List Layout</button>
			</div>
			<section class="acf-flex-layout layout--team" layout="<?php echo esc_html( $team_layout_1 ); ?>">
				<div class="card-grid excerpt-visible">
					<article id="post-1434" class="post-1434 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 1"><img width="500" height="750" src="<?php echo esc_url( $team_1_img ); ?>" class="attachment-large size-large wp-post-image" alt="Team member 1" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 1">Team Member 1</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 1" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1434 -->
					<article id="post-1440" class="post-1440 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 2"><img width="1024" height="682" src="<?php echo esc_url( $team_2_img ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 2">Team Member 2</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 2" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1440 -->
					<article id="post-1441" class="post-1441 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 3"><img width="500" height="575" src="<?php echo esc_url( $team_3_img ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 3">Team Member 3</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 3" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1441 -->
				</div>
				<!--.card-grid-->
			</section>
			<section class="acf-flex-layout layout--team hidden" layout="<?php echo esc_html( $team_layout_2 ); ?>">
				<div class="card-rows excerpt-hidden">
					<article id="post-1434" class="post-1434 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 1"><img width="500" height="750" src="<?php echo esc_url( $team_4_img ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 1">Team Member 1</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 1" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1434 -->
					<article id="post-1440" class="post-1440 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 2"><img width="1024" height="682" src="<?php echo esc_url( $team_5_img ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 2">Team Member 2</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 2" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1440 -->
					<article id="post-1441" class="post-1441 adaptdev_team_member type-adaptdev_team_member status-publish has-post-thumbnail hentry" role="article">
						<div class="thumb">
							<a href="#" title="Team Member 3"><img width="500" height="575" src="<?php echo esc_url( $team_6_img ); ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"></a>
						</div>
						<!-- thumb -->
						<div class="the-content post-content">
							<header class="post-header">
								<h2 class="post-title"><a href="#" title="Team Member 3">Team Member 3</a></h2>
								<p class="entry-subheading">Sub heading</p>
							</header>
							<div class="entry-content">
								Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.			
							</div>
							<div class="learn-more"><a href="#" class="entry__cta" title="Permalink to Team Member 3" rel="bookmark">Read More</a></div>
						</div>
					</article>
					<!-- #post-1441 -->
				</div>
				<!--.card-grid-->
			</section>
		</div>

		<!-- Text Examples -->
		<section class="acf-flex-layout layout--two-column neutral-1 has-bg-color">
			<div class="flex-layout__headings">
				<h2 class="flex-layout__heading">Text Editor</h2>
			</div>
			<div class="row vertical-align-center">
				<div class="col">
					<section class="acf-flex-layout layout--entry-content ">
						<div class="entry-content">
							<h1>Headline 1</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
							<h2>Headline 2</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
						</div>
					</section>
				</div>
				<div class="col">
					<section class="acf-flex-layout layout--entry-content ">
						<div class="entry-content">
							<p><strong>Blockquote</strong></p>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
							<blockquote>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
							</blockquote>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
						</div>
					</section>
				</div>
			</div>
		</section>

		<?php do_action( 'adapt_dev_content_bottom' ); ?>
	</main>
	<?php do_action( 'adapt_dev_content_after' ); ?>

<?php get_footer(); ?>
