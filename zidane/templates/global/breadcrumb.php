<?php

if ( ! empty( $breadcrumb ) ) {

	$title = $content = '';

	foreach ( $breadcrumb as $key => $crumb ) { 
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			$content .= '<li><a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a></li>';
		} else {
			$content .= '<li class="active">' . esc_html( $crumb[0] ) . '</li>';
			$title =  $crumb[0];
		}
	}
?>
	<nav class="is-breadcrumb"<?php echo apply_filters( 'is_style_breadcrumb', '' ); ?>>
		<div class="container">
			<h3 class="breadcrumb-title"><?php echo esc_html( $title ); ?></h3>
			<ol class="breadcrumb">
				<?php echo wp_kses_post( $content ); ?>
			</ol>
		</div>
	</nav>

<?php } ?>