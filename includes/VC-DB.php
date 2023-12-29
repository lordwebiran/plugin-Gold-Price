<?php
if (!defined('ABSPATH')) {
    exit;
}

class VC_DB
{
    public static function create_table()
    {
        // تعریف جدول محصولات
        global $wpdb;
        $VC_product_type = $wpdb->prefix . 'VCG_product_type';
        $VC_product = $wpdb->prefix . 'VCG_product';
        $VC_purchase_sale_type = $wpdb->prefix . 'VCG_purchase_sale_type';
        $VC_order_status = $wpdb->prefix . 'VCG_order_status';
        $VC_orders = $wpdb->prefix . 'VCG_orders';

        $charset_collate = $wpdb->get_charset_collate();

        //جدول نوع محصول
        $product_type_sql = "CREATE TABLE IF NOT EXISTS `" . $VC_product_type . "` (
            `ID` bigint(20) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            PRIMARY KEY (`ID`))
            ENGINE=InnoDB " . $charset_collate . ";";

        //جدول محصولات
        $product_sql = "CREATE TABLE IF NOT EXISTS `" . $VC_product . "` (
            `ID` bigint(20) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `purchase_price` DECIMAL(30, 0) DEFAULT NULL,
            `sale_price` DECIMAL(30, 0) DEFAULT NULL,
            `product_type_id` INT DEFAULT NULL,
            `measure` varchar(128) NOT NULL,
            PRIMARY KEY (`ID`),
            KEY `product_type_id` (`product_type_id`))
            ENGINE=InnoDB " . $charset_collate . ";";

        // تعریف جدول نوع خرید و فروش
        $purchase_sale_type_sql = "CREATE TABLE IF NOT EXISTS `" . $VC_purchase_sale_type . "` (
            `ID` bigint(20) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `icon` varchar(128) NOT NULL,
            PRIMARY KEY (`ID`))
            ENGINE=InnoDB " . $charset_collate . ";";

        // تعریف جدول وضعیت سفارش
        $order_status_sql = "CREATE TABLE IF NOT EXISTS `" . $VC_order_status . "` (
            `ID` bigint(20) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `icon` varchar(128) NOT NULL,
            `Color` varchar(128) NOT NULL,
            PRIMARY KEY (`ID`))
            ENGINE=InnoDB " . $charset_collate . ";";

        // تعریف جدول سفارشات
        $orders_sql = "CREATE TABLE IF NOT EXISTS `" . $VC_orders . "` (
            `ID` bigint(20) NOT NULL AUTO_INCREMENT,
            `user_id` INT NOT NULL,
            `products_id` INT DEFAULT NULL,
            `products_sale_type_id` INT DEFAULT NULL,
            `order_status_id` INT DEFAULT NULL,
            `Gold_gram` INT DEFAULT NULL,
            `Total_gold_price` DECIMAL(30, 0) DEFAULT NULL,
            `Number_of_coins` INT DEFAULT NULL,
            `Total_coins_price` DECIMAL(30, 0) DEFAULT NULL,
            `Date` DATE NOT NULL,
            `Hour` TIME NOT NULL,
            `Price` DECIMAL(30, 0) DEFAULT NULL,
            PRIMARY KEY (`ID`),
            KEY `user_id` (`user_id`),
            KEY `products_id` (`products_id`),
            KEY `products_sale_type_id` (`products_sale_type_id`),
            KEY `order_status_id` (`order_status_id`))
            ENGINE=InnoDB " . $charset_collate . ";";

        if (!function_exists('dbDelta')) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        dbDelta($product_type_sql);
        $product_type_to_insert = array(
            array(
                'name' => 'طلا',
            ),
            array(
                'name' => 'سکه',
            ),
        );

        // افزودن اطلاعات به جدول
        foreach ($product_type_to_insert as $data) {
            $wpdb->insert($VC_product_type, $data);
        }
        dbDelta($product_sql);
        dbDelta($purchase_sale_type_sql);
        $purchase_sale_type_to_insert = array(
            array(
                'name' => 'خرید',
                'icon' => 'ip-ar-cart-circle-arrow-down',
            ),
            array(
                'name' => 'فروش',
                'icon' => 'ip-ar-cart-circle-arrow-up',
            ),
        );

        // افزودن اطلاعات به جدول
        foreach ($purchase_sale_type_to_insert as $data) {
            $wpdb->insert($VC_purchase_sale_type, $data);
        }
        dbDelta($order_status_sql);
        $order_status_to_insert = array(
            array(
                'name' => 'در حال برسی',
                'icon' => 'ip-ar-bolt',
                'Color' => '#ff7f50',
            ),
            array(
                'name' => 'رد شده',
                'icon' => 'ip-ar-triangle-exclamation',
                'Color' => '#a52a2a',
            ),
            array(
                'name' => 'تایید شده',
                'icon' => 'ip-ar-award-simple',
                'Color' => '#006400 ',
            ),
        );

        foreach ($order_status_to_insert as $data) {
            $wpdb->insert($VC_order_status, $data);
        }
        dbDelta($orders_sql);
    }
}
