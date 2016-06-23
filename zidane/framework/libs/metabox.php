<?php

abstract class Inspius_Metabox_Base{

	private $framework_url = '';

	public function __construct(){
		add_action( 'cmb2_render_layout', array( $this, 'metabox_layout_field' ), 10, 5 );
		add_action( 'cmb2_render_sidebar', array( $this, 'metabox_sidebar_field' ), 10, 5 );
	}


	public function metabox_sidebar_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
		global $wp_registered_sidebars;
		$options = array( 'none' => '---Select Sidebar---' );
		foreach ( $wp_registered_sidebars as $key => $value ) {
			$options[$value['id']] = $value['name'];
		}
		$field_type_object->field->args['options'] = $options;
		
		echo $field_type_object->select();
	}

	
	public function metabox_layout_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
		?>
		   	<div class="layout-image">
		   		<img src="<?php echo esc_url( INSPIUS_PATH_URI . '/framework/assets/images/1col.png' ); ?>" data-value="1" class="<?php echo esc_attr( $this->check_active( $escaped_value, 1 ) ); ?>">
		   		<img src="<?php echo esc_url( INSPIUS_PATH_URI . '/framework/assets/images/2cl.png' ); ?>" data-value="2" class="<?php echo esc_attr( $this->check_active( $escaped_value, 2 ) ); ?>">
		   		<img src="<?php echo esc_url( INSPIUS_PATH_URI . '/framework/assets/images/2cr.png' ); ?>" data-value="3" class="<?php echo esc_attr( $this->check_active( $escaped_value, 3 ) ); ?>">
		   	</div>
		<?php
		echo wp_kses_post( $field_type_object->input( array('type'=>'hidden') ) );
	}


	private function check_active( $value, $default ){
		if( $value == $default )
			return ' active';
	}
}