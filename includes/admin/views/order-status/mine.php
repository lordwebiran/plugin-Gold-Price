<div class="vc-order_statuss wrap nosubsub">

    <h1 class="wp-heading-inline">وضعیت سفارش</h1>

    <hr class="wp-header-end">
    <div id="ajax-response"></div>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2> وضعیت سفارش جدید</h2>

                    <?php VC_Flash_Message::show_message(); ?>
                    <form id="VC-add-purchase_ale_type" method="post">
                        <?php wp_nonce_field('add_order_status', 'add_order_status_nonce', false); ?>

                        <div class="form-field">
                            <label for="purchase_ale_type-icon">آیکون</label>
                            <input type="text" name="order_status-icon" id="order_status-icon">
                        </div>
                        <div class="form-field">
                            <label for="purchase_ale_type-name">عنوان</label>
                            <input type="text" name="order_status-name" id="order_status-name">
                        </div>
                        <div class="form-field">
                            <label for="purchase_ale_type-color">رنگ</label>
                            <input type="color" name="order_status-color" id="order_status-color">
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary" value="افزودن">
                        </p>
                    </form>
                    <div class="VCA-font">
                        <h4 class="VCA-font">راهنمای استفاده از فونت</h4>
                        <p>برای انتخاب فونت میتوانید از سایت مرجع زیر استفاده نمایید</p>
                        <a href="https://iconplanet.app/uicons/pack/awesome-regular--442" target="_blank" rel="noopener noreferrer">پکیج فونت آیکن | ویژه متوسط</a><span style="font-size: 8px;"> ۳,۱۲۴ فونت آیکن</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="col-right">
            <div class="col-wrap">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column">آیکون</th>
                            <th scope="col" class="manage-column">عنوان</th>
                            <th scope="col" class="manage-column">رنگ</th>
                        </tr>
                    </thead>
                    <tbody id="the-list">
                        <?php if (count($order_status)) : ?>
                            <?php foreach ($order_status  as $item) : ?>
                                <tr>
                                    <td>
                                        <strong><i style="color:<?php echo esc_html($item->Color) ?> ;" class="<?php echo esc_html($item->icon) ?>" title="<?php echo esc_html($item->name) ?>"></i></strong>
                                        <br>
                                        <div class="row-actions">
                                            <span class="delete"><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=order-status&action=delete&id=' . $item->ID), 'delete_department', 'delete_department_nonce') ?>">حذف</a></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo esc_html($item->name) ?>
                                    </td>
                                    <td>
                                        <strong style="background-color:<?php echo esc_html($item->Color) ?> ; color: #fff; padding: 2px 5px; border-radius: 5px;"><?php echo esc_html($item->Color) ?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" class="manage-column">آیکون</th>
                            <th scope="col" class="manage-column">عنوان</th>
                            <th scope="col" class="manage-column">رنگ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>