<?php
if (!defined('ABSPATH')) {
    exit;
}

class VC_sale_m
{
    private $wpdb;
    private $table;
    private $product;
    private $product_type;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_orders';
        $this->product = $this->wpdb->prefix . 'VCG_product';
        $this->product_type = $this->wpdb->prefix . 'VCG_product_type';
    }

    public function page()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // اضافه کردن
            if (isset($_POST['add_order_status_nonce']) && wp_verify_nonce($_POST['add_order_status_nonce'], 'add_order_status')) {
                $inserted_id = $this->insert($_POST);

                if ($inserted_id) {
                    VC_Flash_Message::add_message(' با موفقیت ایجاد');
                }
            }

            $this->mine();
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                if (isset($_GET['delete_department_nonce']) && wp_verify_nonce($_GET['delete_department_nonce'], 'delete_department')) {
                    $this->delete(sanitize_text_field($_GET['id']));

                    VC_Flash_Message::add_message('با موفقیت حذف شد');
                    $this->mine();
                }
            } else {
                $this->mine();
            }
        }
    }

    private function mine()
    {
        $product_type = $this->get_product_type();
        $products = $this->get_products();
        $orders = $this->get_order();
        require_once G_ferant_DIR . 'sale/mine.php';
    }

    private function get_product_type()
    {
        return $this->wpdb->get_results("SELECT * FROM {$this->product_type}");
    }

    private function get_products()
    {
        return $this->wpdb->get_results("SELECT * FROM {$this->product}");
    }

    private function get_product($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->product} WHERE ID=%d", $id));
    }

    private function get_order()
    {
        return $this->wpdb->get_results("SELECT * FROM {$this->table}");
    }

    private function insert($data)
    {
        $data = [
            'name' => sanitize_text_field($data['name']),
            'icon' => sanitize_text_field($data['icon']),
        ];

        $data_format = ['%s', '%s'];
        $inserted_id = $this->wpdb->insert($this->table, $data, $data_format);

        return $inserted_id ? $this->wpdb->insert_id : null;
    }

    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }
}
