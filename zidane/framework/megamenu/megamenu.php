<?php
if( !class_exists( 'Inspius_Megamenu_Theme' ) ){
	class Inspius_Megamenu_Theme{

		public function __construct(){
			$this->include_core();
			add_action( 'wp_enqueue_scripts',		array($this,'init_front_scripts') );
		}

		private function include_core(){
			require_once ( INSPIUS_PATH_URL . '/framework/megamenu/includes/megamenu-offcanvas.php' );
			require_once ( INSPIUS_PATH_URL . '/framework/megamenu/includes/megamenu-base-front.php' );
		}

		public function init_front_scripts(){
			wp_enqueue_script( 'is_megamenu', INSPIUS_PATH_URI . '/framework/megamenu/js/megamenu-front.js', array(), false, true );
		}
	}

	new Inspius_Megamenu_Theme();
}




