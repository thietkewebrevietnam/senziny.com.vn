<?php 
extract(shortcode_atts(array(
    'title' => '',
    'icon' => '',
), $atts));

?>
<div class="is-contact-icon clearfix">
    <div class="icon">
    	<i class="<?php echo esc_attr( $icon ); ?>"></i>
    </div>
    <div class="title">
        <?php echo esc_html( $title ); ?>
    </div>
</div>