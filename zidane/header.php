<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<?php 
	zidane_framework()->the_head();
	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'is_before_wrapper' ); ?>

<div id="wrapper" class="wrapper">
	
	<?php 
		// Render templates header

		zidane_framework()->the_header();
	?>

	<?php zidane_framework()->the_breadcrumb(); ?>
	
	


