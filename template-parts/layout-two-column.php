<?php
/**
 * Two Column layout for flex content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$vertical_alignment = get_sub_field( 'vertical_alignment' );
?>

<section 
	<?php
	adapt_dev_section_classes(
		[
			get_sub_field( 'two_column_layout' ) == 'forty-sixty' ? 'forty-sixty' : '',
			get_sub_field( 'two_column_layout' ) == 'sixty-forty' ? 'sixty-forty' : '',
			get_sub_field( 'reverse_on_mobile' ) ? 'reverse-on-mobile' : '',
		]
	);
	?>
>
	<?php adapt_dev_section_heading(); ?>
	<div class="row <?php echo esc_attr( $vertical_alignment ); ?>">
		<div class="col">
			<?php
			if ( have_rows( 'column_1_column-widgets' ) ) :
				while ( have_rows( 'column_1_column-widgets' ) ) :
					the_row();
					get_template_part( 'template-parts/layout', get_row_layout() );
				endwhile;
			endif;
			?>
		</div>

		<div class="col">
			<?php
			if ( have_rows( 'column_2_column-widgets' ) ) :
				while ( have_rows( 'column_2_column-widgets' ) ) :
					the_row();
					get_template_part( 'template-parts/layout', get_row_layout() );
				endwhile;
			endif;
			?>
		</div>
	</div>
</section>
