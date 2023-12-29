<div class="vc-product_types wrap nosubsub">

    <h1 class="wp-heading-inline">دسته بندی محصولات</h1>

    <hr class="wp-header-end">
    <div id="ajax-response"></div>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2>دسته بندی جدید</h2>

                    <?php VC_Flash_Message::show_message(); ?>
                    <form id="VC-add-product_type" method="post">
                        <?php wp_nonce_field('add_product_type', 'add_product_type_nonce', false); ?>

                        <div class="form-field">
                            <label for="product_type-name">عنوان</label>
                            <input type="text" name="name" id="product_type-name">
                        </div>
                        
                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary" value="افزودن">
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div id="col-right">
            <div class="col-wrap">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column">عنوان</th>
                        </tr>
                    </thead>
                    <tbody id="the-list">
                        <?php if (count($product_type)) : ?>
                            <?php foreach ($product_type as $item) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($item->name) ?></strong>
                                        <br>
                                        <div class="row-actions">
                                            <span class="delete"><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=VC-products-type&action=delete&id=' . $item->ID), 'delete_department', 'delete_department_nonce') ?>">حذف</a></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" class="manage-column">عنوان</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>