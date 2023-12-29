<?php
$user_id = $this->users($order->user_id);
$product = $this->get_product($order->products_id);
$product_type = $this->product_type($product->product_type_id);
$sale_type = $this->sale_type($order->products_sale_type_id);
$order_status = $this->order_status($order->order_status_id);
?>
<div class="vc-limiter">
    <div class="vc-container-table100">
        <div class="vc-wrap-table100">
            <div class="vc-table100">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">کد سفارش</th>
                            <th class="column2">سفارش دهنده</th>
                            <th class="column3">نام محصول</th>
                            <th class="column4">
                            <?php
                            if ($product->product_type_id) {
                                if ($product->product_type_id == 2) {
                                    echo 'تعداد ';
                                } elseif ($product->product_type_id == 1) {
                                    echo 'وزن';
                                }
                            }
                            ?></th>
                            <th class="column5">قیمت کل</th>
                            <th class="column6">وضعیت سفارش</th>
                            <th class="column7">نوع سفارش</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="column1"><?php echo esc_attr($order->ID)  ?></td>
                            <td class="column2"><?php
                                                if ($order->user_id) {
                                                    echo esc_html($user_id->display_name);
                                                } ?></td>
                            <td class="column3"><?php
                                                if ($order->products_id) {
                                                    echo esc_html($product->name);
                                                } ?></td>
                            <th class="column4">
                            <?php if(!$order->Gold_gram==null){
                                echo esc_html($order->Gold_gram);
                                echo 'گرم';
                            }else{
                                echo esc_html($order->Number_of_coins);
                                echo 'عدد';
                            } ?>
                                
                        </th>
                            <td class="column5">
                            <?php if(!$order->Total_gold_price==null){
                                echo esc_html(number_format($order->Total_gold_price));
                                echo ' تومان';
                            }else{
                                echo esc_html(number_format($order->Total_coins_price));
                                echo ' تومان';
                            } ?>
                            </td>
                            <td class="column6"><i class="<?php if ($order->order_status_id) {
                                                                echo $order_status->icon;
                                                            } ?>" title="<?php if ($order->order_status_id) {
                                                            echo $order_status->name;
                                                        } ?>"></i><br><a href="<?php echo esc_url(admin_url('admin.php?page=VC-orders&action=edit&id=' . $order->ID)) ?>">ویرایش</a></td>
                            <td class="column7"><?php if ($order->products_sale_type_id) {
                                                    if ($order->products_sale_type_id == 1) {
                                                        echo 'فروش';
                                                    } elseif ($order->products_sale_type_id == 2) {
                                                        echo 'خرید';
                                                    }
                                                } ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>