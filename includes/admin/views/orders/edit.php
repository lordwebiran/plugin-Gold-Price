<div class="wrap vc-orders-admin">
    <h1 class="wp-heading-inline">ویرایش سفارش : کد <?php echo esc_attr($order->ID)  ?></h1>
    <hr class="wp-header-end" />
    <?php VC_Flash_Message::show_message(); ?>

    <hr class="wp-header-end">
    <div id="ajax-response"></div>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <form id="vc-add-order" method="post">
                        <?php wp_nonce_field('update_department', 'update_department_nonce'); ?>
                        <input type="hidden" name="order_id" value="<?php echo esc_attr($order->ID)  ?>">
                        <div class="form-field term-parent-wrap">
                            <label for="order_status_id">ویرایش وضعیت سفارش</label>
                            <select name="order_status_id" id="order_status_id">
                                <?php foreach ($order_statuses as $item) : ?>
                                    <?php if ($order->order_status_id == $item->ID) : ?>
                                        <option selected value="<?php echo esc_attr($item->ID); ?>"><?php echo esc_html($item->name); ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo esc_attr($item->ID); ?>"><?php echo esc_html($item->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary" value="ویرایش">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>