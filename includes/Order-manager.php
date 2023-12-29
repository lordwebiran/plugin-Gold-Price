<?php
defined('ABSPATH') || exit('No Access !!!');

class VC_Order_manager
{
    private $wpdb;
    private $table;
    private $datetime;
    private $product;
    private $product_type;
    private $sale_type;
    private $order_status;
    private $users;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix . 'VCG_orders';
        $this->datetime = $this->wpdb->prefix . 'VCG_datetime';
        $this->product = $this->wpdb->prefix . 'VCG_product';
        $this->product_type = $this->wpdb->prefix . 'VCG_product_type';
        $this->sale_type = $this->wpdb->prefix . 'VCG_purchase_sale_type';
        $this->order_status = $this->wpdb->prefix . 'VCG_order_status';
        $this->users = $this->wpdb->prefix . 'users';
    }

    public function get_products($id)
    {
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM " . $this->table. " WHERE Date=%s", $id));
    }

    public function get_product($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->product . " WHERE ID=%d", $id));
    }
    public function product_type($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->product_type . " WHERE ID=%d", $id));
    }
    public function sale_type($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->sale_type . " WHERE ID=%d", $id));
    }
    public function order_status($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->order_status . " WHERE ID=%d", $id));
    }
    public function users($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM " . $this->users . " WHERE ID=%d", $id));
    }

    public function insert($data)
    {
        $errors = [];
        $user_id = get_current_user_id();

        if (!intval($data['user_id'])) {
            $errors[] = 'وارد حساب کاربری نشده اید';
        }

        if (!intval($data['Gold_gram']) && !intval($data['Number_of_coins'])) {
            $errors[] = 'تعداد و یا وزن محصول خود را وارد نمایید';
        }

        if (count($errors) > 0) {
            return ['errors' => $errors];
        }

        $Price=null;
        $product = $this->get_product($data['products_id']);
        if($data['products_sale_type_id']==1){
            $Price=$product->purchase_price;
        }elseif($data['products_sale_type_id']==2){
            $Price=$product->sale_price;
        }

        $jdat=date("Y-m-d");

        $insert_data = [
            'user_id' => $user_id ? $user_id : $data['user_ID'],
            'products_id' => $data['products_id'],
            'Price' => $Price,
            'products_sale_type_id' => $data['products_sale_type_id'],
            'order_status_id' => $data['order_status_id'],
            'Gold_gram' => $data['Gold_gram'] ?: null,
            'Total_gold_price' => $data['Total_gold_price'] ?: null,
            'Number_of_coins' => $data['Number_of_coins'] ?: null,
            'Total_coins_price' => $data['Total_coins_price'] ?: null,
            'Date' => $data['Date'] ? $jdat :null,
            'Hour' => $data['Hour'] ?: null,
        ];

        $this->wpdb->insert(
            $this->table,
            $insert_data,
            ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
        );

        $insert_id = $this->wpdb->insert_id;
        return ['insert_id' => $insert_id];
    }

    public function insert_datetime($data)
    {
        $errors = [];
        $user_id = get_current_user_id();

        if (!intval($data['user_id'])) {
            $errors[] = 'وارد حساب کاربری نشده اید';
        }

        if (count($errors) > 0) {
            return ['errors' => $errors];
        }
        
        $insert_data = [
            'user_id' => $user_id ? $user_id : $data['user_ID'],
            'products_id' => $data['products_id'],
            'orders_id' => $data['orders_id'],
            'Date' => $data['Date'] ?:null,
            'Hour' => $data['Hour'] ?: null,
        ];

        $this->wpdb->insert(
            $this->datetime,
            $insert_data,
            ['%d', '%d', '%d', '%s', '%s']
        );

        $insert_id = $this->wpdb->insert_id;
        return ['insert_id' => $insert_id];
    }
}