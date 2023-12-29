<?php
if (!defined('ABSPATH')) {exit;}

class VC_purchase_sale_type
{
    private $wpdb;
    private $table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_purchase_sale_type';
    }

    public function page()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // اضافه کردن
            if (isset($_POST['add_purchase_sale_type_nonce'])) {
                if (!isset($_POST['add_purchase_sale_type_nonce']) && !wp_verify_nonce($_POST['add_purchase_sale_type_nonce'], 'add_purchase_sale_type')) {
                    exit('sorry');
                }

                $insert = $this->insert($_POST);

                if ($insert) {
                    VC_Flash_Message::add_message(' با موفقیت ایجاد');
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
            } else {
                $this->mine();
            }
        }
    }

    private function mine()
    {
        $purchase_sale_type = $this->get_purchase_sale_type();
        require_once G_admin_views_DIR . 'purchase-sale-type/mine.php';
    }

    private function get_purchase_sale_type()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table);
    }

    private function insert($data)
    {

        $data = ['name' => sanitize_text_field($data['name'])];
        $data_format = ['%s'];

        $insert = $this->wpdb->insert($this->table, $data, $data_format);

        return $insert ? $this->wpdb->insert_id : null;
    }
    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }

}
