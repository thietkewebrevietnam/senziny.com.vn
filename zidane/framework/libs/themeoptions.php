<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

class Inspius_Redux_Framework_Base {

    public $args = array();
    public $sections = array();
    public $theme;
    public $ReduxFramework;

    protected $function;

    public function __construct(){
        $this->function = Inspius_Functions::instance();
        $this->initSettings();
    }

    public function initSettings()
    {

        // Just for demo purposes. Not needed per say.
        $this->theme = wp_get_theme();

        // Set the default arguments
        $this->setArguments();

        // Create the sections and fields
        $this->set_sections();

        if (!isset($this->args['opt_name'])) { // No errors please
            return;
        }

        
        $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        
    }

    public function set_sections(){}

    /**
     * Return Header options
     * 
     * */   
    protected function get_header_options(){
        $options = array();
        $files = glob( INSPIUS_PATH_URL . '/templates/header/*.php' );
        
        foreach ($files as $f) {
            $id = wp_basename( $f, '.php' );
            $options[$id] = ucfirst( str_replace( '-', ' ', $id ) );
        }
        return $options;
    }

    protected function get_skin_options(){
        $dirs = array_filter(glob( INSPIUS_PATH_URL . '/css/*' ), 'is_dir');
        foreach ($dirs as $d) {
            $id = wp_basename( $d );
            $options[$id] = ucfirst( str_replace( '-', ' ', $id ) );
        }
        return $options;
    }
    

    /**
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
    public function setArguments()
    {

        $theme = wp_get_theme(); // For use with some settings. Not necessary.

        $this->args = array(
            // TYPICAL -> Change these values as you need/desire
            'opt_name' => 'theme_option',
            // This is where your data is stored in the database and also becomes your global variable name.
            'display_name' => $theme->get('Name'),
            // Name that appears at the top of your panel
            'display_version' => $theme->get('Version'),
            // Version that appears at the top of your panel
            'menu_type' => 'menu',
            //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
            'allow_sub_menu' => true,
            // Show the sections below the admin menu item or not
            'menu_title' => esc_html__('Theme Options', 'zidane'),
            'page_title' => esc_html__('Theme Options', 'zidane'),
            // You will need to generate a Google API key to use this feature.
            // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
            'google_api_key' => '',
            // Set it you want google fonts to update weekly. A google_api_key value is required.
            'google_update_weekly' => false,
            // Must be defined to add google fonts to the typography module
            'async_typography' => true,
            // Use a asynchronous font on the front end or font string
            //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
            'admin_bar' => true,
            // Show the panel pages on the admin bar
            'admin_bar_icon' => 'dashicons-portfolio',
            // Choose an icon for the admin bar menu
            'admin_bar_priority' => 50,
            // Choose an priority for the admin bar menu
            'global_variable' => '',
            // Set a different name for your global variable other than the opt_name
            'dev_mode' => false,
            // Show the time the page took to load, etc
            'update_notice' => true,
            // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
            'customizer' => true,
            // Enable basic customizer support
            //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
            //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

            // OPTIONAL -> Give you extra features
            'page_priority' => 59,
            // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
            'page_parent' => 'themes.php',
            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'page_permissions' => 'manage_options',
            // Permissions needed to access the options panel.
            'menu_icon' => '',
            // Specify a custom URL to an icon
            'last_tab' => '',
            // Force your panel to always open to a specific tab (by id)
            'page_icon' => 'icon-themes',
            // Icon displayed in the admin panel next to your menu_title
            'page_slug' => 'inspius-options',
            // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
            'save_defaults' => true,
            // On load save the defaults to DB before user clicks save or not
            'default_show' => false,
            // If true, shows the default value next to each field that is not the default value.
            'default_mark' => '',
            // What to print by the field's title if the value shown is default. Suggested: *
            'show_import_export' => true,
            // Shows the Import/Export panel when not used as a field.

            // CAREFUL -> These options are for advanced use only
            'transient_time' => 60 * MINUTE_IN_SECONDS,
            'output' => true,
            // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
            'output_tag' => true,
            // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
            // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
            'database' => '',
            // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
            'system_info' => false,
            // REMOVE

            // HINTS
            'hints' => array(
                'icon' => 'el el-question-sign',
                'icon_position' => 'right',
                'icon_color' => 'lightgray',
                'icon_size' => 'normal',
                'tip_style' => array(
                    'color' => 'light',
                    'shadow' => true,
                    'rounded' => false,
                    'style' => '',
                ),
                'tip_position' => array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                ),
                'tip_effect' => array(
                    'show' => array(
                        'effect' => 'slide',
                        'duration' => '500',
                        'event' => 'mouseover',
                    ),
                    'hide' => array(
                        'effect' => 'slide',
                        'duration' => '500',
                        'event' => 'click mouseleave',
                    ),
                ),
            )
        );
        
        

        // Panel Intro text -> before the form
        if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
            if (!empty($this->args['global_variable'])) {
                $v = $this->args['global_variable'];
            } else {
                $v = str_replace('-', '_', $this->args['opt_name']);
            }
            $this->args['intro_text'] = wp_kses_post( sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'zidane'), $v) );
        } else {
            $this->args['intro_text'] = esc_html__('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'zidane');
        }
    }
}










