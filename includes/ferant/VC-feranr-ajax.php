<?php
defined('ABSPATH') || exit('No Access !!!');

class VC_Front_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_vc_submit_form_Order', [$this, 'submit_Order']);
        add_action('wp_ajax_nopriv_vc_submit_form_Order', [$this, 'submit_Order']);

        add_action('wp_ajax_form_show_info_modal', [$this, 'submit_show_info_modal']);
        add_action('wp_ajax_nopriv_form_show_info_modal', [$this, 'submit_show_info_modal']);
    }

    public function submit_Order()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'VC_ajax_nonce')) {
            wp_send_json_error();
        }

        $VC_order_data = [
            'user_id' => $_POST['user_ID'],
            'products_id' => $_POST['product_ID'],
            'products_sale_type_id' => $_POST['sale_type'],
            'order_status_id' => $_POST['order_status'],
            'Date' => $_POST['Date'],
            'Hour' => $_POST['Hour'],
        ];

        if ($_POST['product_type'] == 1) {
            $VC_order_data['Gold_gram'] = $_POST['Qty'];
            $VC_order_data['Total_gold_price'] = $_POST['total'];
        } elseif ($_POST['product_type'] == 2) {
            $VC_order_data['Number_of_coins'] = $_POST['Qty'];
            $VC_order_data['Total_coins_price'] = $_POST['total'];
        }

        $VC_datetime = [
            'user_id' => $_POST['user_ID'],
            'products_id' => $_POST['product_ID'],
            'Date' => $_POST['Date'],
            'Hour' => $_POST['Hour'],
        ];

        $VC_Order = new VC_Order_manager();
        $order = $VC_Order->insert($VC_order_data);

        if (!isset($order['insert_id'])) {
            $this->make_response(['__success' => false, 'results' => $order['insert_id']]);
        } else {
            $VC_datetime = [
                'orders_id' => $order['insert_id'],
            ];
            $order_datetime = $VC_Order->insert_datetime($VC_datetime);
            if (isset($order_datetime['insert_id'])) {
                $this->make_response(['__success' => true, 'results' => $order_datetime['insert_id']]);
            }
            $this->make_response(['__success' => true, 'results' => $order['insert_id']]);
        }
    }

    public function submit_show_info_modal()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'VC_ajax_nonce')) {
            wp_send_json_error();
        }

        $user_id = get_current_user_id();

        $VC_date = new VC_Order_manager();
        $C_date = $VC_date->get_products($_POST['date']);
        $order_r = array_reverse($C_date);

        $date = [];

        foreach ($order_r as $item) {
            // Get additional information
            $product = $VC_date->get_product($item->products_id);
            $sale_type = $VC_date->order_status($item->order_status_id);
            $products_sale_type = $VC_date->sale_type($item->products_sale_type_id);

            $formattedDate = jdate("l, j  F  Y", strtotime($item->Date));

            if ($item->user_id == $user_id) {
                // Build the array for the current item
                $tempDate = [
                    'ID' => $item->ID,
                    'products' => $product->name,
                    'products_sale_type' => $products_sale_type->name,
                    'order_status_Color' => $sale_type->Color,
                    'order_status_icon' => $sale_type->icon,
                    'Price' => number_format($item->Price, 0),
                    'Date' => $formattedDate,
                    'Hour' => $item->Hour,
                    'titel_t' => $product->measure,

                ];

                if (!$item->Number_of_coins == null) {
                    // Append coin-related data
                    $tempDate['titel_Qty'] = 'تعداد';
                    $tempDate['Qty'] = $item->Number_of_coins;
                    $tempDate['total'] = number_format($item->Total_coins_price, 0);
                } elseif (!$item->Gold_gram == null) {
                    // Append gold-related data
                    $tempDate['titel_Qty'] = 'وزن';
                    $tempDate['Qty'] = $item->Gold_gram;
                    $tempDate['total'] = number_format($item->Total_gold_price, 0);
                }

                // Append the current item to the $date array
                $date[] = $tempDate;
            }
        }

        $this->make_response(['__success' => true, 'results' => $date]);
    }

    public function make_response($result)
    {
        if (is_array($result)) {
            wp_send_json($result);
        } else {
            echo $result;
        }
        wp_die();
    }
}
