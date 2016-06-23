<?php

class Inspius_Page_Builder_Base{

	private $elements = array();
	private $url;

	public function __construct(){

		add_action( 'vc_after_init', array( $this, 'init_pagebuilder' ) );

		//Remove "Edit with Visual Composer" option
		add_action( 'vc_after_init', array( $this, 'vc_remove_frontend_links' ) );

		// Filter to replace default css class names for vc_row shortcode and vc_column
		add_filter( 'vc_shortcodes_css_class', array( $this, 'custom_css_classes_for_vc_row_and_vc_column' ), 10, 2 );

		$function = 'vc_add' . '_shortcode_param';
		//Add parram Animation
		$function( 'animation', array( $this,'add_param_animation' ) , 		INSPIUS_PATH_URI . '/framework/assets/js/vc_animation.js' );
		$function( 'location', 	array( $this,'add_param_location_map' ) , 	INSPIUS_PATH_URI . '/framework/assets/js/vc_googlemap.js' );

		$list = array(
		    'page',
		    'footer'
		);
		vc_set_default_editor_post_types( $list );
	}

	public function init_pagebuilder(){
		$this->include_all_element();
		$this->edit_element_text_separator();
		$this->edit_element_image();
	}
	
	private function edit_element_text_separator(){
		vc_remove_param( 'vc_text_separator', 'align' );
		vc_remove_param( 'vc_text_separator', 'color' );
		vc_remove_param( 'vc_text_separator', 'accent_color' );
		vc_remove_param( 'vc_text_separator', 'style' );
		vc_remove_param( 'vc_text_separator', 'border_width' );
		vc_remove_param( 'vc_text_separator', 'el_width' );
		vc_remove_param( 'vc_text_separator', 'css' );
		vc_remove_param( 'vc_text_separator', 'layout' );
	}

	private function edit_element_image(){
		// Column
	    vc_add_param( 'vc_column', array(
	         "type" => "animation",
	         "heading" => esc_html__("CSS Animation",'zidane'),
	         "param_name" => "is_animation",
	    ));
	    vc_add_param( 'vc_column_inner', array(
	         "type" => "animation",
	         "heading" => esc_html__("CSS Animation",'zidane'),
	         "param_name" => "is_animation",
	    ));
	}

	public function add_param_location_map( $settings, $value ){
		$dependency = vc_generate_dependencies_attributes($settings);
		ob_start();
	?>
		<div id="is_element-map">
			<div class="map_canvas" style="height:200px;"></div>

			<div class="vc_row-fluid googlefind">
				<input id="geocomplete" type="text" class="is_location" placeholder="Type in an address" size="90" />
				<button class="button-primary find">Find</button>
			</div>

			<div class="row-fluid mapdetail">
				<div class="span6">
					<div class="wpb_element_label">Latitude</div>
					<input name="lat" class="is_latgmap" type="text" value="">
				</div>
				
				<div class="span6">
					<div class="wpb_element_label">Longitude</div>
					<input name="lng" class="is_lnggmap" type="text" value="">
				</div>
			</div>
	<?php
		$output = ob_get_clean();
		return  $output . '<input name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput '
				.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				.$value.'" ' . $dependency . '/></div>';

	}


	public function add_param_animation( $settings, $value ) {
		$value = ($value=='') ? 'none|1000|200' : $value;
	    $dependency = vc_generate_dependencies_attributes( $settings );
	    $options = array(
	    				'none' 				=> 'none',
						'bounce' 			=> 'bounce',
						'flash' 			=> 'flash',
						'pulse' 			=> 'pulse',
						'rubberBand' 		=> 'rubberBand',
						'shake' 			=> 'shake',
						'swing' 			=> 'swing',
						'tada' 				=> 'tada',
						'wobble' 			=> 'wobble',
						'bounceIn' 			=> 'bounceIn',
						'fadeIn' 			=> 'fadeIn',
						'fadeInDown' 		=> 'fadeInDown',
						'fadeInDownBig' 	=> 'fadeInDownBig',
						'fadeInLeft' 		=> 'fadeInLeft',
						'fadeInLeftBig' 	=> 'fadeInLeftBig',
						'fadeInRight' 		=> 'fadeInRight',
						'fadeInRightBig' 	=> 'fadeInRightBig',
						'fadeInUp' 			=> 'fadeInUp',
						'fadeInUpBig' 		=> 'fadeInUpBig',
						'flip' 				=> 'flip',
						'flipInX' 			=> 'flipInX',
						'flipInY' 			=> 'flipInY',
						'lightSpeedIn' 		=> 'lightSpeedIn',
						'rotateInrotateIn' 	=> 'rotateIn',
						'rotateInDownLeft' 	=> 'rotateInDownLeft',
						'rotateInDownRight' => 'rotateInDownRight',
						'rotateInUpLeft' 	=> 'rotateInUpLeft',
						'rotateInUpRight' 	=> 'rotateInUpRight',
						'slideInDown' 		=> 'slideInDown',
						'slideInLeft' 		=> 'slideInLeft',
						'slideInRight' 		=> 'slideInRight',
						'rollIn' 			=> 'rollIn'
					);
	    ob_start();
	    echo '<input id="'.$settings['param_name'].'" 
	    		name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput '
				.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				.$value.'" ' . $dependency . '/>';
		?>
		<div class="vc_row">
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Effect</div>
				<select id="is_effect">
					<?php foreach ($options as $key => $value) {
						echo '<option value="'.$key.'">'.$value.'</option>';
					} ?>
				</select>
			</div>
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Duration</div>
				<input type="text" value="" id="is_duration">
			</div>
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Delay</div>
				<input type="text" id="is_delay">
			</div>
		</div>
		<?php
	    return ob_get_clean();
	}

	private function include_all_element(){
		foreach ( $this->elements as $value ) {
			include_once ( INSPIUS_PATH_URL . '/inc/pagebuilder/' . $value . '.php' );
		}
	}

	public function add_element( $element ){
		if( is_array( $element ) ){
			$this->elements = array_merge( $this->elements, $element );
		}else{
			$this->elements[] = $element;
		}
	}


	// Action 'vc_after_init'
	public function vc_remove_frontend_links() {
	    vc_disable_frontend(); // this will disable frontend editor
	}

	//filter 'vc_shortcodes_css_class'
	public function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
		if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
			$class_string = str_replace( 'vc_row-fluid', '', $class_string );
			$class_string = str_replace( 'vc_row', 'row', $class_string );
		}
		if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
			$class_string = preg_replace('/vc_col-(\w)/', 'col-$1', $class_string);
			$class_string = str_replace('vc_column_container', '', $class_string);
		}
		return $class_string; // Important: you should always return modified or original $class_string
	}

}