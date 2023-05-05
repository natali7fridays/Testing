<?php
/**
 * 404 template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

global $adapt_dev_config;

$adapt_dev_404_headline     = $adapt_dev_config['404_headline'];
$adapt_dev_404_message      = $adapt_dev_config['404_message'];
$adapt_dev_404_show_sitemap = $adapt_dev_config['404_show_sitemap']

?>
<?php get_header(); ?>

	<header class="entry-header aligned">
		<h1 class="entry-title">404 / Page Not Found</h1>
	</header>


	<main class="page-full main-content content-404" id="content" role="main">

		<div class="module">

			<div class="col-1 cf">
				<div class="page-title-wrap">
					<h2 class="page-title"><?php esc_html_e( $adapt_dev_404_headline, 'adapt_dev' ); ?></h2>
				</div>

				<div class="entry-content">
					<p><?php echo apply_filters( 'the_content', $adapt_dev_404_message ); //phpcs:ignore?></p>
					<?php echo $adapt_dev_404_show_sitemap === true ? adapt_dev_sitemap() : '';//phpcs:ignore ?>
				</div><!-- entry-content -->

			</div><!-- col-1 -->

		</div><!-- module -->
	</main><!-- page-cols -->

<?php get_footer(); ?>
