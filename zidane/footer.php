
	<footer id="is-footer-copyright-group">
	<?php 
		if( zidane_framework()->get_option( 'footer_custom', false ) ){
			zidane_framework()->the_footer_custom_content();
		}else{
	?>
			<div class="footer-top container">
				<div class="inner">
					<?php echo do_shortcode( zidane_framework()->get_option('footer_top','') ); ?>
				</div>
			</div>
			<?php if( 	   is_active_sidebar( 'footer-1' )
						|| is_active_sidebar( 'footer-2' )
						|| is_active_sidebar( 'footer-3' )
						|| is_active_sidebar( 'footer-4' )
				 ): ?>
			<div id="footer" class="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<?php dynamic_sidebar('footer-1'); ?>
						</div>
						<div class="col-md-3 col-sm-6">
							<?php dynamic_sidebar('footer-2'); ?>
						</div>
						<div class="col-md-3 col-sm-6">
							<?php dynamic_sidebar('footer-3'); ?>
						</div>
						<div class="col-md-3 col-sm-6">
							<?php dynamic_sidebar('footer-4'); ?>
						</div>
					</div>
				</div>		
			</div> <!-- End .is-footer -->
			<?php endif; ?>

		<?php } ?>

		<div class="copyright">
			<div class="container text-center">
				<?php echo do_shortcode( wpautop( zidane_framework()->get_option('footer_copyright','Copyright &copy;2016 zidane by Inspius. All right Reserved') ) ); ?>
			</div>
		</div>
	</footer> <!-- End .is-footer-copyright-group -->
</div> <!-- End .wrapper -->

<?php do_action( 'is_after_wrapper' ); ?>

<?php wp_footer(); ?>

</body>
</html>