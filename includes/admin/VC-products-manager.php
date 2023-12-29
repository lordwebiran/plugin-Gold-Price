<?php
if (!defined('ABSPATH')) {
    exit;
}

class VC_products
{
    private $wpdb;
    private $table;
    private $product_type;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_product';
        $this->product_type = $this->wpdb->prefix . 'VCG_product_type';
    }

    public function page()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // اضافه کردن
            if (isset($_POST['add_products_nonce'])) {
                if (!isset($_POST['add_products_nonce']) && !wp_verify_nonce($_POST['add_products_nonce'], 'add_products')) {
                    exit('sorry');
                }

                $insert = $this->insert($_POST);

                if ($insert) {
                    VC_Flash_Message::add_message(' با موفقیت ثبت شد');
                }
            }

            // update department
            if (isset($_POST['update_department_nonce'])) {

                if (!isset($_POST['update_department_nonce']) && !wp_verify_nonce($_POST['update_department_nonce'], 'update_department')) {
                    exit('Sorry , your nonce did not verify');
                }

                $update = $this->update($_POST['department_id'], $_POST);


                if ($update) {
                    VC_Flash_Message::add_message('بروزرسانی با موفقیت انجام شد');
                }
            }

            $this->mine();
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                if (isset($_GET['delete_department_nonce']) && wp_verify_nonce($_GET['delete_department_nonce'], 'delete_department')) {
                    $this->delete($_GET['id']);

                    VC_Flash_Message::add_message('با موفقیت حذف شد');

                    $this->mine();
                }
            } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
                $products = $this->get_product($_GET['id']);
                $product_types = $this->get_product_types();
                include G_admin_views_DIR . 'products/edit.php';
            } else {
                $this->mine();
            }
        }
    }

    private function mine()
    {
        $products = $this->get_products();
        $departments = $this->get_product_types();
        require_once G_admin_views_DIR . 'products/mine.php';
    }

    private function get_products()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table);
    }
    private function get_product($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ID=%d", $id));
    }
    private function get_product_types()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->product_type);
    }

    private function get_product_type($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->product_type . " WHERE ID=%d", $id));
    }

    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }

    public function update($id, $data)
    {

        $data = [
            'name' => sanitize_text_field($data['name']),
            'purchase_price' => sanitize_text_field($data['purchase_price']),
            'sale_price' => sanitize_text_field($data['sale_price']),
            'measure' => sanitize_text_field($data['measure']),
            'product_type_id' => sanitize_text_field($data['product_type_id'])
        ];
        $where = ['ID' => (int) $id];
        $data_format = ['%s', '%d', '%d', '%s', '%d'];
        $where_format = ['%d'];


        return $this->wpdb->update($this->table, $data, $where, $data_format, $where_format);
    }

    private function insert($data)
    {

        $data = [
            'name' => sanitize_text_field($data['name']),
            'purchase_price' => sanitize_text_field($data['purchase_price']),
            'sale_price' => sanitize_text_field($data['sale_price']),
            'measure' => sanitize_text_field($data['measure']),
            'product_type_id' => sanitize_text_field($data['product_type_id'])
        ];
        $data_format = ['%s', '%d', '%d', '%s', '%d'];

        $insert = $this->wpdb->insert($this->table, $data, $data_format);

        return $insert ? $this->wpdb->insert_id : null;
    }
}
