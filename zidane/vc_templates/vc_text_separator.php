<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title_align
 * @var $el_width
 * @var $style
 * @var $title
 * @var $align
 * @var $color
 * @var $accent_color
 * @var $el_class
 * @var $layout
 * @var $css
 * @var $border_width
 * @var $add_icon
 * Icons:
 * @var $i_type
 * @var $i_icon_fontawesome
 * @var $i_icon_openiconic
 * @var $i_icon_typicons
 * @var $i_icon_entypo
 * @var $i_icon_linecons
 * @var $i_color
 * @var $i_custom_color
 * @var $i_background_style
 * @var $i_background_color
 * @var $i_custom_background_color
 * @var $i_size
 * @var $i_css_animation
 * Shortcode class
 * @var $this WPBakeryShortcode_Vc_Text_Separator
 */

$title_align = $el_width = $style = $title = $align =
$color = $accent_color = $el_class = $layout = $css =
$border_width = $add_icon = $i_type = $i_icon_fontawesome =
$i_icon_openiconic = $i_icon_typicons = $i_icon_entypo =
$i_icon_linecons = $i_color = $i_custom_color =
$i_background_style = $i_background_color =
$i_custom_background_color = $i_size = $i_css_animation = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class = 'vc_separator wpb_content_element';

switch ($title_align) {
	case 'separator_align_center':
		$class .= ' text-center';
		break;
	case 'separator_align_left':
		$class .= ' text-left';
		break;
	case 'separator_align_right':
		$class .= ' text-right';
		break;
	default:
		$class .= ' text-center';
		break;
}

$icon = '';
if ( 'true' === $add_icon ) {
	vc_icon_element_fonts_enqueue( $i_type );
	$icon = $this->getVcIcon( $atts );
}

$content = '';
if ( $icon ) {
	$content = $icon;
}

?>

<h3 class="heading-title <?php echo esc_attr( $class ); ?>">
	<?php echo $icon; ?>
	<span><?php echo esc_html( $title ); ?></span>
</h3>




