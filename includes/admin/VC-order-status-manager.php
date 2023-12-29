<?php
if (!defined('ABSPATH')) {exit;}

class VC_order_status
{
    private $wpdb;
    private $table;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_order_status';
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
        $order_status = $this->get_order_status();
        require_once G_admin_views_DIR . 'order-status/mine.php';
    }

    private function get_order_status()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table);
    }

    private function insert($data)
    {

        $data = [
            'name' => sanitize_text_field($data['order_status-name']),
            'icon' => sanitize_text_field($data['order_status-icon']),
            'Color' => sanitize_text_field($data['order_status-color'])
    ];
        $data_format = ['%s','%s','%s'];

        $insert = $this->wpdb->insert($this->table, $data, $data_format);

        return $insert ? $this->wpdb->insert_id : null;
    }
    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }

}
