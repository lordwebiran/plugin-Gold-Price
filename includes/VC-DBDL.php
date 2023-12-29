<?php
if (!defined('ABSPATH')) {
    exit;
}

class VC_DBDL
{
    public static function create_table()
    {
        global $wpdb;
        $VC_product_type = $wpdb->prefix . 'VCG_product_type';
        $VC_product = $wpdb->prefix . 'VCG_product';
        $VC_purchase_sale_type = $wpdb->prefix . 'VCG_purchase_sale_type';
        $VC_order_status = $wpdb->prefix . 'VCG_order_status';
        $VC_orders = $wpdb->prefix . 'VCG_orders';

        $tables_to_delete = array(
            $VC_product_type,
            $VC_product,
            $VC_purchase_sale_type,
            $VC_order_status,
            $VC_orders,
        );

        // حذف جدول‌ها
        foreach ($tables_to_delete as $table_name) {
            $sql = "DROP TABLE IF EXISTS $table_name;";
            $wpdb->query($sql);
        }
    }
}
