<?php
if (!defined('ABSPATH')) {
    exit;
}

class order
{
    private $wpdb;
    private $table;
    private $product;
    private $product_type;
    private $sale_type;
    private $order_status;
    private $datetime;
    private $users;



    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_orders';
        $this->product = $this->wpdb->prefix . 'VCG_product';
        $this->product_type = $this->wpdb->prefix . 'VCG_product_type';
        $this->sale_type = $this->wpdb->prefix . 'VCG_purchase_sale_type';
        $this->order_status = $this->wpdb->prefix . 'VCG_order_status';
        $this->datetime = $this->wpdb->prefix . 'VCG_datetime';
        $this->users = $this->wpdb->prefix . 'users';
    }

    public function page()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // اضافه کردن
            if (isset($_POST['add_order_status_nonce'])) {
                if (!isset($_POST['add_order_status_nonce']) && !wp_verify_nonce($_POST['add_order_status_nonce'], 'add_order_status')) {
                    exit('sorry');
                }

                $insert = $this->insert($_POST);

                if ($insert) {
                    VC_Flash_Message::add_message(' با موفقیت ایجاد');
                }
            }

            $this->mine();
        } else {
            $this->mine();
        }
    }

    private function mine()
    {
        $order = $this->get_order();
        $datetime = $this->get_datetime();
        $statu = $this->order_statu();
        require_once G_ferant_DIR . 'order/min.php';
    }

    private function get_order()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table);
    }
    private function get_datetime()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table . " ORDER BY `Date` DESC");
    }
    private function order_statu()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->order_status);
    }
    public function get_datetime1($date)
    {
        $count = $this->wpdb->get_var($this->wpdb->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE `Date` = %s", $date));
        return $count;
    }

    private function get_product($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->product . " WHERE ID=%d", $id));
    }
    private function product_type($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->product_type . " WHERE ID=%d", $id));
    }
    private function sale_type($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->sale_type . " WHERE ID=%d", $id));
    }
    private function order_status($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->order_status . " WHERE ID=%d", $id));
    }
    private function insert($data)
    {

        $data = [
            'name' => sanitize_text_field($data['name']),
            'icon' => sanitize_text_field($data['icon'])
        ];
        $data_format = ['%s', '%s'];

        $insert = $this->wpdb->insert($this->table, $data, $data_format);

        return $insert ? $this->wpdb->insert_id : null;
    }
}
