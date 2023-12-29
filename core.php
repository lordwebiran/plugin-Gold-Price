<?php
/*
Plugin Name: افزونه ثبت سفارش گلد
Description: این افزونه به شما این امکان را می‌دهد تا سفارش‌های خرید و فروش طلا و سکه را ثبت کنید.
Version: 2.0.0
Author: پرتو گستر ویانا
Author URI: https://viennaco.ir/
Plugin URI: https://github.com/lordwebiran/Silica-Order
*/

if (!defined('ABSPATH')) {
    exit;
}
require 'includes/assets.php';
require 'includes/VC-DB.php';
require 'includes/admin/astract/base-menu.php';
require 'includes/admin/VC_menu.php';
require 'includes/JD.php';
class Core
{
    private static $_instance = null;

    const MINIMUM_PHP_VERSION = "7.4";
    const Plugin_Name = "ثبت سفارش گلد";

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice']);
            return;
        }
        $this->constans();
        $this->init();
    }

    public function constans()
    {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        define('G_BASE_FILE', __FILE__);
        define('G_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('G_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('G_ASSETS_URL', G_PLUGIN_URL . 'assets/');
        define('G_includes_DIR', G_PLUGIN_DIR . 'includes/');
        define('G_admin_DIR', G_includes_DIR . 'admin/');
        define('G_admin_views_DIR', G_admin_DIR . 'views/');
        define('G_ferant_DIR', G_includes_DIR . 'ferant/');

        $VCG_plugin_data = get_plugin_data(G_BASE_FILE);
        define('VCG_VER', $VCG_plugin_data['Version']);
    }
    public function init()
    {
        require_once G_PLUGIN_DIR . 'vendor/autoload.php';
        require_once G_PLUGIN_DIR . 'includes/codestar/codestar-framework.php';
        register_activation_hook(G_BASE_FILE, [$this, 'active']);
        register_deactivation_hook(G_BASE_FILE, [$this, 'deactive']);
        require_once G_includes_DIR . 'functions.php';
    }
    public function active()
    {
        VC_DB::create_table();
    }

    public function deactive()
    {
        VC_DBDL::create_table();
    }

    public function admin_notice()
    {
?>
        <div class="notice notice-warning is-dismissible">
            <p><?php echo esc_html('افزونه <b>' . self::Plugin_Name . '</b> برای اجرای صحیح نیاز به نسخه <b>' . self::MINIMUM_PHP_VERSION . ' PHP</b> به بالا دارد، لطفا نسخه PHP خود را ارتقا دهید'); ?></p>
        </div>
<?php
    }
}

Core::instance();
