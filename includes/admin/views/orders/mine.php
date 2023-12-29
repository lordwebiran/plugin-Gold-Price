<div class="wrap vc-orders-admin">
    <h1 class="wp-heading-inline">سفارشات</h1>
    <hr class="wp-header-end" />
    <?php VC_Flash_Message::show_message(); ?>
    <h2 class="screen-reader-text">لیست سفارشات</h2>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th>کد سفارش</th>
                <th>نام مشتری</th>
                <th>نوع</th>
                <th>وضعیت</th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php if (count($orders)) {
                $order_r = array_reverse($orders); ?>
                <?php foreach ($order_r as $item) : ?>

                    <tr>
                        <th>
                            <strong><?php echo esc_html($item->ID) ?></strong>
                            <br>
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo esc_url(admin_url('admin.php?page=VC-orders&action=edit&id=' . $item->ID)) ?>">ویرایش وضعیت سفارش</a> | </span>
                                <span class="delete"><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=VC-orders&action=delete&id=' . $item->ID), 'delete_department', 'delete_department_nonce') ?>">حذف</a> | </span>
                                <span class="view"><a href="<?php echo esc_url(admin_url('admin.php?page=VC-orders&action=view&id=' . $item->ID)) ?>">اطلاعات بیشتر</a></span>

                            </div>
                        </th>
                        <th><?php
                            $user_id = $this->users($item->user_id);
                            if ($item->user_id) {
                                echo esc_html($user_id->display_name);
                            }

                            $sale_type = $this->sale_type($item->products_sale_type_id);
                            $order_status = $this->order_status($item->order_status_id);
                            ?></th>
                        <th><i class="<?php if ($item->products_sale_type_id) {
                                            if ($item->products_sale_type_id == 1) {
                                                echo 'ip-ar-cart-circle-arrow-down';
                                            } elseif ($item->products_sale_type_id == 2) {
                                                echo 'ip-ar-cart-circle-arrow-up';
                                            }
                                        } ?>" title="<?php if ($item->products_sale_type_id) {
                                                            if ($item->products_sale_type_id == 1) {
                                                                echo 'خرید';
                                                            } elseif ($item->products_sale_type_id == 2) {
                                                                echo 'فروش';
                                                            }
                                                        } ?>"></i></th>
                        <th><i class="<?php if ($item->order_status_id) {
                                            echo $order_status->icon;
                                        } ?>" title="<?php if ($item->order_status_id) {
                                                            echo $order_status->name;
                                                        } ?>"></i></th>
                    </tr>

                <?php endforeach; ?>
            <?php } else {
            ?>
                <tr class="no-items">
                    <td class="colspanchange" colspan="7">هیچ سفارشی ثبت نشد.</td>
                </tr>
            <?php
            } ?>
        </tbody>

        <tfoot>
            <tr>
                <th>کد سفارش</th>
                <th>نام مشتری</th>
                <th>نوع</th>
                <th>وضعیت</th>
            </tr>
        </tfoot>
    </table>
    <div class="clear"></div>
</div>