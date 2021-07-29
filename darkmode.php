<?php

/*
Plugin Name: DarkMode
Description: Extension pour donner la possibilité de fournir un darkmode aux sites Wordpress
Version: 1.0
Author: ESGI
*/


class darkmodeSettings
{

    private $darkmode_options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'darkmode_settings_page' ) );
        add_action( 'admin_init', array( $this, 'darkmode_page_init' ) );
    }

    public function darkmode_settings_page()
    {
        add_options_page(
            'darkmode Admin',
            'darkmode',
            'manage_options',
            'darkmode_settings_admin_page',
            array( $this, 'darkmode_admin_page' )
        );
    }

    public function darkmode_admin_page()
    {
        $this->options = get_option( 'darkmode_options' );
        ?>
        <div class="wrap">
            <h2>darkmode Settings</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'darkmode_main_options_group' );
                do_settings_sections( 'darkmode_settings_admin_page' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function darkmode_page_init()
    {
        register_setting(
            'darkmode_main_options_group',
            'darkmode_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'darkmode_main_section',
            'Position personnalisée',
            array( $this, 'darkmode_print_main_section_info' ),
            'darkmode_settings_admin_page'
        );
        add_settings_section(
            'darkmode_positions_section',
            'Position pré définit',
            array( $this, 'darkmode_print_positions_section_info' ),
            'darkmode_settings_admin_page'
        );
        add_settings_section(
            'darkmode_widget_section',
            'Paramètre du bouton',
            array( $this, 'darkmode_print_main_section_info' ),
            'darkmode_settings_admin_page'
        );

        add_settings_field(
            'darkmode_bottom',
            'Bas du site',
            array( $this, 'darkmode_bottom_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_main_section'
        );

        add_settings_field(
            'darkmode_right',
            'Droite',
            array( $this, 'darkmode_right_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_main_section'
        );

        add_settings_field(
            'darkmode_left',
            'Gauche',
            array( $this, 'darkmode_left_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_main_section'
        );
        add_settings_field(
            'darkmode_button_size',
            'Taille du bouton',
            array( $this, 'darkmode_button_size_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_widget_section'
        );
        add_settings_field(
            'darkmode_icon_size',
            'Taille de l\'icone',
            array( $this, 'darkmode_icon_size_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_widget_section'
        );
        add_settings_field(
            'darkmode_left_bottom',
            'En bas à gauche',
            array( $this, 'darkmode_left_bottom_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_positions_section'
        );
        add_settings_field(
            'darkmode_right_bottom',
            'En bas à droite',
            array( $this, 'darkmode_right_bottom_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_positions_section'
        );
        add_settings_field(
            'darkmode_match_os',
            'Want to match the OS mode?',
            array( $this, 'darkmode_match_os_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_extras_section'
        );
        add_settings_field(
            'darkmode_toggle',
            'Want to use your own toggle widget or button?',
            array( $this, 'darkmode_toggle_callback' ),
            'darkmode_settings_admin_page',
            'darkmode_extras_section'
        );

    }

    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['darkmode_right'] ) )
            $new_input['darkmode_right'] = sanitize_text_field( $input['darkmode_right'] );

        if( isset( $input['darkmode_bottom'] ) )
            $new_input['darkmode_bottom'] = sanitize_text_field( $input['darkmode_bottom'] );

        if( isset( $input['darkmode_left'] ) )
            $new_input['darkmode_left'] = sanitize_text_field( $input['darkmode_left'] );

        if( isset( $input['darkmode_icon_size'] ) )
            $new_input['darkmode_icon_size'] = sanitize_text_field( $input['darkmode_icon_size'] );

        if( isset( $input['darkmode_button_size'] ) )
            $new_input['darkmode_button_size'] = sanitize_text_field( $input['darkmode_button_size'] );

        if( isset( $input['darkmode_left_bottom'] ) )
            $new_input['darkmode_left_bottom'] = absint( $input['darkmode_left_bottom'] );

        if( isset( $input['darkmode_right_bottom'] ) )
            $new_input['darkmode_right_bottom'] = absint( $input['darkmode_right_bottom'] );

        if( isset( $input['darkmode_match_os'] ) )
            $new_input['darkmode_match_os'] = absint( $input['darkmode_match_os'] );

        if( isset( $input['darkmode_toggle'] ) )
            $new_input['darkmode_toggle'] = absint( $input['darkmode_toggle'] );

        return $new_input;
    }

    public function darkmode_print_main_section_info()
    {
        print 'Personnalisez ci-dessous:';
    }
    public function darkmode_print_positions_section_info()
    {
        print 'Choisir la position du bouton:';
    }

    //On affiche les boutons
    public function darkmode_bottom_callback()
    {
        printf(
            '<input type="text" id="darkmode_bottom" placeholder="32px" name="darkmode_options[darkmode_bottom]" value="%s" />',
            isset( $this->options['darkmode_bottom'] ) ? esc_attr( $this->options['darkmode_bottom']) : ''
        );
    }

    public function darkmode_right_callback()
    {
        printf(
            '<input type="text" id="darkmode_right" name="darkmode_options[darkmode_right]" placeholder="32px" value="%s" />',
            isset( $this->options['darkmode_right'] ) ? esc_attr( $this->options['darkmode_right']) : ''
        );
    }
    public function darkmode_left_callback()
    {
        printf(
            '<input type="text" id="darkmode_left" placeholder="32px" name="darkmode_options[darkmode_left]" value="%s" />',
            isset( $this->options['darkmode_left'] ) ? esc_attr( $this->options['darkmode_left']) : ''
        );
    }
    public function darkmode_button_size_callback()
    {
        printf(
            '<input type="range" min="1" max="5" step="1" id="darkmode_button_size" name="darkmode_options[darkmode_button_size]" value="%s" />',
            isset( $this->options['darkmode_button_size'] ) ? esc_attr( $this->options['darkmode_button_size']) : ''
        );
    }
    public function darkmode_icon_size_callback()
    {
        printf(
            '<input type="range" min="1.5" max="5.5" step="1" id="darkmode_icon_size" name="darkmode_options[darkmode_icon_size]" value="%s" />',
            isset( $this->options['darkmode_icon_size'] ) ? esc_attr( $this->options['darkmode_icon_size']) : ''
        );
    }

    public function darkmode_left_bottom_callback()
    {
        printf(
            '<input type="checkbox" id="darkmode_left_bottom" name="darkmode_options[darkmode_left_bottom]" value="1"' . checked( 1, $this->options['darkmode_left_bottom'], false ) . ' />',
            isset( $this->options['darkmode_left_bottom'] ) ? esc_attr( $this->options['darkmode_left_bottom']) : ''
        );
    }
    public function darkmode_right_bottom_callback()
    {
        printf(
            '<input type="checkbox" id="darkmode_right_bottom" name="darkmode_options[darkmode_right_bottom]" value="1"' . checked( 1, $this->options['darkmode_right_bottom'], false ) . ' />',
            isset( $this->options['darkmode_right_bottom'] ) ? esc_attr( $this->options['darkmode_right_bottom']) : ''
        );
    }
    public function darkmode_match_os_callback()
    {
        printf(
            '<input type="checkbox" id="darkmode_match_os" name="darkmode_options[darkmode_match_os]" value="1"' . checked( 1, $this->options['darkmode_match_os'], false ) . ' />',
            isset( $this->options['darkmode_match_os'] ) ? esc_attr( $this->options['darkmode_match_os']) : ''
        );
    }
    public function darkmode_toggle_callback()
    {
        printf(
            '<input type="checkbox" id="darkmode_toggle" name="darkmode_options[darkmode_toggle]" value="1"' . checked( 1, $this->options['darkmode_toggle'], false ) . ' />',
            isset( $this->options['darkmode_toggle'] ) ? esc_attr( $this->options['darkmode_toggle']) : ''
        );
    }
}

function darkmode_enqueues(){
    $darkmode_options = get_option('darkmode_options');
    wp_enqueue_script('darkmode_script', plugin_dir_url( __FILE__ ) . 'js/darkmode.js', array(), '1.0', 'true');
    $darkmode_custom_css = ".darkmode-toggle>img{
            width: {$darkmode_options['darkmode_icon_size']}rem !important;
            height:{$darkmode_options['darkmode_icon_size']}rem !important;
        }
        .darkmode-toggle {
            width:{$darkmode_options['darkmode_button_size']}rem !important;
            height:{$darkmode_options['darkmode_button_size']}rem !important;
        }
        ";
    wp_add_inline_style('darkmode_style', $darkmode_custom_css);
}

function darkmode_position(){
    $darkmode_options = get_option('darkmode_options');
    $darkmode_match_os = "false";
    $darkmode_toggle = "const darkmode = new Darkmode(options); darkmode.showWidget();";
    $darkmode_bottom = "false";
    $darkmode_left = "false";
    $darkmode_right = "false";

    if ($darkmode_options['darkmode_toggle'] == 1){
        $darkmode_toggle = "const darkmode = new Darkmode(options);";
    }else{
        $darkmode_toggle = "const darkmode = new Darkmode(options); darkmode.showWidget();";
    }

    // position personnalisée
    $darkmode_options['darkmode_bottom'] !== '' ? $darkmode_bottom = $darkmode_options['darkmode_bottom'] : $darkmode_bottom = '32px';
    $darkmode_options['darkmode_right'] !== '' ? $darkmode_right = $darkmode_options['darkmode_right'] : $darkmode_right = '32px';
    $darkmode_options['darkmode_left'] !== '' ? $darkmode_left = $darkmode_options['darkmode_left'] : $darkmode_left = 'unset';





    if ($darkmode_options['darkmode_left_bottom'] == '1'){
        $darkmode_custom_js = "
        var options = {
            bottom: '{$darkmode_bottom}', 
            right: 'unset',
            left: '{$darkmode_left}', 
            label: '🌓' // default: ''
        }
        {$darkmode_toggle}
        ";
    }elseif ($darkmode_options['darkmode_right_bottom'] == '1'){
        $darkmode_custom_js = "
        var options = {
            bottom: '{$darkmode_bottom}', 
            right: '{$darkmode_right}', 
            left: 'unset', // default: 'unset'
            label: '🌓' // default: ''
        }
         {$darkmode_toggle}
         ";
    }else{
        $darkmode_custom_js = "
        var options = {
            bottom: '{$darkmode_bottom}', 
            right: '{$darkmode_right}', 
            left: '{$darkmode_left}', 
            label: '🌓' // default: ''
        }
        {$darkmode_toggle}
        ";
    }


    wp_add_inline_script('darkmode_script', $darkmode_custom_js);
}
function darkmode_init(){
    $darkmode_options = get_option('darkmode_options');

    add_action( 'wp_enqueue_scripts', 'darkmode_enqueues' );
    add_action( 'wp_enqueue_scripts', 'darkmode_position' );

}
$darkmode_options = get_option('darkmode_options');
if( is_admin() ) {
    $darkmode_settings = new darkmodeSettings();
}else{
    add_action('wp', 'darkmode_init');
}
