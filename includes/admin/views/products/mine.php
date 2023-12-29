<div class="vc-products wrap nosubsub">

    <h1 class="wp-heading-inline">محصولات</h1>

    <hr class="wp-header-end">
    <div id="ajax-response"></div>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2>محصول جدید</h2>

                    <?php VC_Flash_Message::show_message(); ?>

                    <form id="‌vc-add-products" method="post">

                        <?php wp_nonce_field('add_products', 'add_products_nonce', false); ?>

                        <div class="form-field">
                            <label for="products-name">عنوان</label>
                            <input type="text" name="name" id="products-name">
                        </div>

                        <div class="form-field">
                            <label for="purchase_price">خرید (تومان)</label>
                            <input type="number" class="small-text" name="purchase_price" id="purchase_price">
                        </div>

                        <div class="form-field">
                            <label for="sale_price">فروش (تومان)</label>
                            <input type="number" class="small-text" name="sale_price" id="sale_price">
                        </div>

                        <div class="form-field">
                            <label for="products-measure">میزان یا واحد</label>
                            <input type="text" name="measure" id="products-measure" placeholder="مثقال ، عدد، گرم">
                        </div>


                        <div class="form-field term-parent-wrap">
                            <label for="product_type_id">دسته بندی محصول</label>
                            <select name="product_type_id" id="product_type_id">
                                <?php if (count($departments)) : ?>
                                    <?php foreach ($departments as $department) : ?>
                                        <?php if ($department->parent) {
                                            continue;
                                        } ?>
                                        <option value="<?php echo esc_attr($department->ID); ?>"><?php echo esc_html($department->name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
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
                            <th scope="col" class="manage-column">خرید (تومان)</th>
                            <th scope="col" class="manage-column">فروش (تومان)</th>
                            <th scope="col" class="manage-column">میزان یا واحد</th>
                            <th scope="col" class="manage-column">دسته بندی محصول</th>
                        </tr>
                    </thead>
                    <tbody id="the-list">

                        <?php if (count($products)) : ?>
                            <?php foreach ($products as $item2) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($item2->name) ?></strong>
                                        <br>
                                        <div class="row-actions">
                                            <span class="edit"><a href="<?php echo esc_url(admin_url('admin.php?page=VC-products&action=edit&id=' . $item2->ID)) ?>">ویرایش</a> | </span>
                                            <span class="delete"><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=VC-products&action=delete&id=' . $item2->ID), 'delete_department', 'delete_department_nonce') ?>">حذف</a></span>
                                        </div>
                                    </td>
                                    <td> <?php echo esc_html(number_format($item2->purchase_price)) ?> </td>
                                    <td><?php echo esc_html(number_format($item2->sale_price)) ?></td>
                                    <td><?php echo esc_html($item2->measure) ?></td>
                                    <td><?php
                                        if ($item2->product_type_id) {
                                            $product_type = $this->get_product_type($item2->product_type_id);
                                            echo $product_type ? $product_type->name : '___';
                                        }
                                        ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" class="manage-column">عنوان</th>
                            <th scope="col" class="manage-column">خرید (تومان)</th>
                            <th scope="col" class="manage-column">فروش (تومان)</th>
                            <th scope="col" class="manage-column">میزان یا واحد</th>
                            <th scope="col" class="manage-column">دسته بندی محصول</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>