<?php
vc_map( array(
	'name'                    => esc_html__( 'Tabs', 'zidane' ),
	'base'                    => 'is_tabs',
	"icon"                    => "icon-wpb-inspius",
	'is_container'            => true,
	'show_settings_on_create' => false,
	'as_parent'               => array(
		'only' => 'is_tab'
	),
	'category'                => esc_html__( 'Inspius', 'zidane' ),
	'description'             => esc_html__( 'Tabbed content', 'zidane' ),
	'params'                  => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Row stretch', 'zidane' ),
			'param_name'  => 'full_width',
			'value'       => array(
				esc_html__( 'Default', 'zidane' )                               => '',
				esc_html__( 'Stretch row', 'zidane' )                           => 'stretch_row',
				esc_html__( 'Stretch row and content', 'zidane' )               => 'stretch_row_content',
				esc_html__( 'Stretch row and content (no paddings)', 'zidane' ) => 'stretch_row_content_no_spaces',
			),
			'description' => esc_html__( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'zidane' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'zidane' ),
			'param_name'  => 'el_class',
			'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'zidane' )
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'zidane' ),
			'param_name' => 'css',
		),
	),
	'js_view'                 => 'VcBackendTIsTabsView',
	'custom_markup'           => '
<div class="vc_tta-container" data-vc-action="collapse">
	<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
		<div class="vc_tta-tabs-container">'
	                             . '<ul class="vc_tta-tabs-list">'
	                             . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="is_tab"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
	                             . '</ul>
		</div>
		<div class="vc_tta-panels vc_clearfix {{container-class}}">
		  {{ content }}
		</div>
	</div>
</div>',
	'default_content'         => '
[is_tab title="' . sprintf( "%s %d", esc_html__( 'Tab', 'zidane' ), 1 ) . '"][/is_tab]
[is_tab title="' . sprintf( "%s %d", esc_html__( 'Tab', 'zidane' ), 2 ) . '"][/is_tab]
	',
	'admin_enqueue_js'        => array(
		vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
		INSPIUS_PATH_URI . '/framework/assets/js/pagebuilder.js',
	)
) );


VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Tabs' );

class WPBakeryShortCode_Is_Tabs extends WPBakeryShortCode_VC_Tta_Tabs {
	public function getFileName() {
		return 'is_tabs';
	}

	public function resetListTab(){
		global $is_tab_item;
		$is_tab_item = array();
	}

	public function getListTab(){
		global $is_tab_item;
		return $is_tab_item;
	}

}

