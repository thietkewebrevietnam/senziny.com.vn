<?php
$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
    'title'         => '',
    'el_class'      => '',
    'full_width'    => '',
    'css'           => '',
), $atts));
$this->resetListTab();
do_shortcode( $content );
$is_tab_item = $this->getListTab();


$el_class = $this->getExtraClass($el_class);

$wrapper_attributes = array();
$after_output = '';

$css_classes = array(
    'tab-content',
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);

if ( ! empty( $full_width ) ) {
    $wrapper_attributes[] = 'data-vc-full-width="true"';
    $wrapper_attributes[] = 'data-vc-full-width-init="false"';
    if ( 'stretch_row_content' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
    } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        $css_classes[] = 'vc_row-no-padding';
    }
    $after_output .= '<div class="vc_row-full-width"></div>';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

?>

<div class="tabbable is-tabbable <?php echo esc_attr( $el_class ); ?>">
    <div class="tabbable-inner">
        <ul class="nav nav-tabs">
            <?php foreach( $is_tab_item as $key => $tab ){ ?>
                <li<?php echo ( $key==0 ) ? ' class="active"' : ''; ?>>
                    <a href="#tab-<?php echo esc_attr( $tab['tab-id'] ); ?>" data-toggle="tab">
                        <?php echo esc_html( $tab['title'] ); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <div <?php echo implode( ' ', $wrapper_attributes ); ?>>
            <?php foreach( $is_tab_item as $key=>$tab ){ ?>
                <div class="fade tab-pane<?php echo ($key==0) ? ' active in' : ''; ?>" id="tab-<?php echo esc_attr( $tab['tab-id'] ); ?>">
                    <?php echo do_shortcode( $tab['content'] ); ?>
                </div>
            <?php } ?>
        </div>
        <?php echo $after_output; ?>
    </div>
</div>