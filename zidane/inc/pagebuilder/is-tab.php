<?php
vc_map( array(
	'name'                      => esc_html__( 'Tab', 'zidane' ),
	'base'                      => 'is_tab',
	"icon"                      => "icon-wpb-inspius",
	'allowed_container_element' => 'vc_row',
	'is_container'              => true,
	'show_settings_on_create'   => false,
	'as_child'                  => array(
		'only' => 'is_tabs',
	),
	'category'                  => esc_html__( 'Inspius', 'zidane' ),
	'params'                    => array(
		array(
			'type'        => 'textfield',
			'param_name'  => 'title',
			'heading'     => esc_html__( 'Title', 'zidane' ),
			'description' => esc_html__( 'Enter section title (Note: you can leave it empty).', 'zidane' ),
		),
		array(
			'type'        => 'el_id',
			'param_name'  => 'tab_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'heading'     => esc_html__( 'Section ID', 'zidane' ),
			'description' => wp_kses_post( __( 'Enter section ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'zidane' ) ),
		),
	),
	'js_view'                   => 'VcBackendTtaSectionView',
	'custom_markup'             => '
		<div class="vc_tta-panel-heading">
		    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
		</div>
		<div class="vc_tta-panel-body">
			{{ editor_controls }}
			<div class="{{ container-class }}">
			{{ content }}
			</div>
		</div>',
	'default_content'           => '',
) );


VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Section' );

class WPBakeryShortCode_Is_Tab extends WPBakeryShortCode_VC_Tta_Section {

	public function getFileName() {
		return 'is_tab';
	}

	public function setListTab( $tab_item ){
		global $is_tab_item;
		$is_tab_item[] = $tab_item;
	}
}
