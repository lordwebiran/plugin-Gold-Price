<?php
if (!defined('ABSPATH')) {
    exit;
}

class VC_Order_Manager_admin
{
    private $wpdb;
    private $table;
    private $product; //
    private $product_type;
    private $sale_type;
    private $order_status;
    private $users;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix . 'VCG_orders';
        $this->product = $this->wpdb->prefix . 'VCG_product';
        $this->product_type = $this->wpdb->prefix . 'VCG_product_type';
        $this->sale_type = $this->wpdb->prefix . 'VCG_purchase_sale_type';
        $this->order_status = $this->wpdb->prefix . 'VCG_order_status';
        $this->users = $this->wpdb->prefix . 'users';
    }


    public function page()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // update department
            if (isset($_POST['update_department_nonce'])) {

                if (!isset($_POST['update_department_nonce']) && !wp_verify_nonce($_POST['update_department_nonce'], 'update_department')) {
                    exit('Sorry , your nonce did not verify');
                }

                $update = $this->update($_POST['order_id'], $_POST);


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
                $order = $this->get_order($_GET['id']);
                $order_statuses = $this->get_order_statuses();
                include G_admin_views_DIR . 'orders/edit.php';
            } elseif (isset($_GET['action']) && $_GET['action'] == 'view') {
                $order = $this->get_order($_GET['id']);
                include G_admin_views_DIR . 'orders/view.php';
            } else {
                $this->mine();
            }
        }
    }

    private function mine()
    {
        $orders = $this->get_orders();
        require_once G_admin_views_DIR . 'orders/mine.php';
    }


    private function get_orders()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->table);
    }
    private function get_order($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ID=%d", $id));
    }
    private function get_order_statuses()
    {
        return $this->wpdb->get_results("SELECT * FROM " . $this->order_status);
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
    private function users($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->users . " WHERE ID=%d", $id));
    }


    public function update($id, $data)
    {

        $data = [
            'order_status_id' => sanitize_text_field($data['order_status_id'])
        ];
        $where = ['ID' => (int) $id];
        $data_format = ['%s', '%d', '%d', '%d'];
        $where_format = ['%d'];


        return $this->wpdb->update($this->table, $data, $where, $data_format, $where_format);
    }

    public function delete($id)
    {
        $this->wpdb->delete($this->table, ['ID' => $id], ['%d']);
    }

    public function view($id)
    {
        return $this->wpdb->view($this->wpdb->prepare("SELECT * FROM " . $this->table . " WHERE ID=%d", $id));
    }
}
