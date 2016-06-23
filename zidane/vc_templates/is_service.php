<?php 
extract(shortcode_atts(array(
    'title'     => '',
    'desc'      => '',
    'icon'      => '',
    'bg'        => '#87c24e',
    'css_class' => ''
), $atts));

?>
<div class="is-service clearfix <?php echo esc_attr( $css_class ); ?>" style="background:<?php echo esc_attr( $bg ); ?>">
    <div class="service-icon pull-left">
    	<i class="<?php echo esc_attr($icon);?>" style="color:<?php echo esc_attr( $bg ); ?>"></i>
    </div>
    <div class="service-content">
    	<div class="name"><?php echo $title; ?></div>
	    <div class="text"><?php echo $desc; ?></div>
    </div>
</div>