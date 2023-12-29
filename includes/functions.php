<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once G_admin_DIR . 'VCG-settings.php';
if (is_admin()) {
    new VC_Menu();
}
new VC_Front_Ajax();
new G_Assets();
function sale()
{
    $manager = new VC_sale_m();
    $manager->page();
}
add_shortcode('sale', 'sale');
function order1()
{
    $manager = new order();
    $manager->page();
}
add_shortcode('order', 'order1');
