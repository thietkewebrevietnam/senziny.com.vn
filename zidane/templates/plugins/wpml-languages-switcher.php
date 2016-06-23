<?php
if ( ! empty( $languages ) ) {
	$l_active 	= '';
	$l 			= array();
	foreach ( $languages as $language ) {
		/*
		* $language['id'] :
		* $language['active']  :
		* $language['native_name']  :
		* $language['missing']  :
		* $language['translated_name'] :
		* $language['language_code'] :
		* $language['country_flag_url'] :
		* $language['url'] :
		*/
		if( $language['active'] ){
			$l_active = $language;
		}else{
			$l[] = $language;
		}
	}

?>
	<div class="language-switch">
		<div class="dropdown">
			<a href="#" data-toggle="dropdown">
				<span class="title"><?php echo esc_html( $l_active['native_name'] ); ?></span>
				<img src="<?php echo esc_url( $l_active['country_flag_url'] ); ?>" alt="<?php echo esc_attr( $l_active['language_code'] ); ?>">
				<i class="icon-arrow-down"></i>
			</a>
			<?php if( !empty( $l ) ){ ?>
			<ul class="dropdown-menu">
				<?php foreach ($l as $value) { ?>
				<li>
					<a href="<?php echo esc_url( $value['url'] ); ?>">
						<span class="title"><?php echo esc_html( $value['native_name'] ); ?></span>
						<img src="<?php echo esc_url( $value['country_flag_url'] ); ?>" alt="<?php echo esc_attr( $value['language_code'] ); ?>">
					</a>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
	</div>
<?php
}