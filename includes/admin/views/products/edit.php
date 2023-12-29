<div class="vc-productswrap nosubsub">

    <h1 class="wp-heading-inline">ویرایش دپارتمان</h1>

    <hr class="wp-header-end">
    <div id="ajax-response"></div>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">

                    <?php VC_Flash_Message::show_message(); ?>

                    <form id="‌vc-add-products" method="post">

                        <?php wp_nonce_field('update_department', 'update_department_nonce', false);
                        ?>

                        <input type="hidden" name="department_id" value="<?php echo esc_attr($products->ID)  ?>">

                        <div class="form-field">
                            <label for="products-name">عنوان</label>
                            <input type="text" name="name" id="products-name" value="<?php echo esc_attr($products->name) ?>">
                        </div>

                        <div class="form-field">
                            <label for="purchase_price">خرید (تومان)</label>
                            <input type="number" class="small-text" name="purchase_price" id="purchase_price" value="<?php echo esc_attr__($products->purchase_price) ?>">
                        </div>

                        <div class=" form-field">
                            <label for="sale_price">فروش (تومان)</label>
                            <input type="number" class="small-text" name="sale_price" id="sale_price" value="<?php echo esc_attr__($products->sale_price) ?>">
                        </div>
                        <div class="form-field">
                            <label for="products-measure">میزان یا واحد</label>
                            <input type="text" name="measure" id="products-measure" value="<?php echo esc_attr($products->measure) ?>">
                        </div>

                        <div class=" form-field term-parent-wrap">
                            <label for="product_type_id">دسته بندی محصول</label>
                            <select name="product_type_id" id="product_type_id">
                                <?php if (count($product_types)) : ?>
                                    <?php foreach ($product_types as $item) : ?>
                                        <option <?php echo $products->product_type_id == $item->ID ? 'selected' : '' ?> value="<?php echo esc_attr($item->ID); ?>"><?php echo esc_html($item->name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
</div>