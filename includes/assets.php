<?php
// Enqueue scripts and styles

class G_Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'VCA_font']);
        add_action('admin_enqueue_scripts', [$this, 'VCA_font']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts_and_styles']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
    }

    function enqueue_scripts_and_styles()
    {
        //style
        wp_enqueue_style('bootstrap-style', G_ASSETS_URL . 'css/bootstrap.rtl.min.css');
        wp_enqueue_style('ip',  G_ASSETS_URL . 'css/ip-awesome-regular.css');
        wp_enqueue_style('custom-style', G_ASSETS_URL . 'css/custom-style.css');


        //script
        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap-script', G_ASSETS_URL . 'js/bootstrap.min.js', array('jquery'), null, true);
        wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
        wp_enqueue_script('moment', G_ASSETS_URL . 'js/moment.min.js', array('jquery'), null, true);
        wp_enqueue_script('custom-script', G_ASSETS_URL . 'js/custom-script.js', array('jquery'), null, true);
        wp_localize_script('custom-script', 'VC_DATA', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('VC_ajax_nonce')
        ]);
    }

    function admin_assets()
    {
        //style
        wp_enqueue_style('bootstrap-style', G_ASSETS_URL . 'css/bootstrap.rtl.min.css');
        wp_enqueue_style('vc-custom-style', G_ASSETS_URL . 'css/custom-style.css');
        wp_enqueue_style('ip', G_ASSETS_URL . 'css/ip-awesome-regular.css');
        wp_enqueue_style('VCG-admin', G_ASSETS_URL . 'css/VCG-admin.css');

        //script
        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap-script', G_ASSETS_URL . 'js/bootstrap.min.js', array('jquery'), null, true);
        wp_enqueue_script('moment', G_ASSETS_URL . 'js/moment.min.js', array('jquery'), null, true);
        wp_enqueue_script('vc-custom-script', G_ASSETS_URL . 'js/custom-script.js', array('jquery'), null, true);
        wp_localize_script('vc-custom-script', 'VC_DATA', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('VC_ajax_nonce')
        ]);
    }

    public static function VCA_font()
    {
        $options = get_option('VCG-settings');
        if (isset($options['VCA-font']) && $options['VCA-font'] == 'Vazir') {
            if (isset($options['VCA-font-Vazir']) && $options['VCA-font-Vazir'] == 'Vazir-en') {
                wp_enqueue_style('VCA-Vazir-en', G_ASSETS_URL . 'font/Vazir-en.css');
            } else {
                wp_enqueue_style('VCA-Vazir-fa', G_ASSETS_URL . 'font/Vazir-fa.css');
            }
        }
    }
}
