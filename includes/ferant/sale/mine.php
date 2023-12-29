<section class="mt-4">
    <div class="vc-heah VCA-font">
        <h2 class="vc-text-heah VCA-font">قیمت پایه</h2>
        <p class="vc-time">
            <span id="show_time_1">
                <script language="JavaScript">
                    function show_time_1() {
                        d = new Date();
                        H = d.getHours();
                        H = H < 10 ? "0" + H : H;
                        i = d.getMinutes();
                        i = i < 10 ? "0" + i : i;
                        s = d.getSeconds();
                        s = s < 10 ? "0" + s : s;
                        document.getElementById("show_time_1").innerHTML =
                            H + ":" + i + ":" + s;
                        setTimeout("show_time_1()", 1000); /* 1 sec */
                    }
                    show_time_1();
                </script>
            </span>
            : ساعت
        </p>
        <p class="vc-Date">
            <?php
            $databaseDate = new DateTime();
            $timestamp = $databaseDate->getTimestamp();
            $formattedDate = jdate("l, j F Y", $timestamp);
            echo $formattedDate;
            ?>
        </p>
    </div>

    <?php if (count($product_type)) : ?>
        <?php foreach ($product_type as $item2) : ?>
            <div class="vc-body VCA-font">
                <div class="vc-hr"></div>
                <div class="row vc-coler-gold">
                    <div class="col-4"><?php echo esc_html($item2->name) ?></div>
                    <div class="col-4">خرید (تومان)</div>
                    <div class="col-4">فروش (تومان)</div>
                </div>

                <?php if (count($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <?php if ($product->product_type_id == $item2->ID) : ?>
                            <div class="row vc-body-row">
                                <div class="col-4"><?php if ($product->product_type_id == "1") {
                                                        echo esc_html($product->measure);
                                                        echo esc_html(' ');
                                                    }
                                                    echo esc_html($product->name); ?></div>
                                <div class="col-4 vc-body-border">
                                    <form class="form-Buy" method="post">
                                        <input type="hidden" name="ID-<?php echo esc_attr($product->ID) ?>" class="Buy-ID" value="<?php echo esc_attr($product->ID) ?>" />
                                        <input type="hidden" name="Buy-product-name-<?php echo esc_attr($product->ID) ?>" class="Buy-product-name" value="خرید <?php echo esc_attr($product->name) ?>" />
                                        <input type="hidden" name="Buy-product-name-<?php echo esc_attr($product->ID) ?>" class="Buy-measure" value="<?php echo esc_attr($product->measure) ?>" />
                                        <input type="hidden" name="Buy-<?php echo esc_attr($product->ID) ?>" class="Buy" value="<?php echo esc_attr($product->purchase_price) ?>" />
                                        <input type="hidden" name="Buy-product-<?php echo esc_attr($item2->ID) ?>" class="Buy-product-type" value="<?php echo esc_attr($item2->ID) ?>" />
                                        <button type="submit" id="Buy-submit"><?php echo esc_html(number_format($product->purchase_price, 0)) ?></button>
                                    </form>
                                </div>
                                <div class="col-4 vc-body-border">
                                    <form class="form-Selling">
                                        <input type="hidden" name="ID-<?php echo esc_attr($product->ID) ?>" class="Selling-ID" value="<?php echo esc_attr($product->ID) ?>" />
                                        <input type="hidden" name="Buy-product-name-<?php echo esc_attr($product->ID) ?>" class="Selling-product-name" value="فروش <?php echo esc_attr($product->name) ?>" />
                                        <input type="hidden" name="Buy-product-name-<?php echo esc_attr($product->ID) ?>" class="Selling-measure" value="<?php echo esc_attr($product->measure) ?>" />
                                        <input type="hidden" name="Selling-<?php echo esc_attr($product->ID) ?>" class="Selling" value="<?php echo esc_attr($product->sale_price) ?>" />
                                        <input type="hidden" name="Selling-product-<?php echo esc_attr($item2->ID) ?>" class="Selling-product-type" value="<?php echo esc_attr($item2->ID) ?>" />
                                        <button type="submit" id="Selling-submit"><?php echo esc_html(number_format($product->sale_price, 0)) ?></button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="vc-footer">
        <div class="vc-hr"></div>
    </div>
</section>

<section class="VCA-font vc-t-Order d-none">
    <div class="vc-hb">
        <h3>پیش فاکتور</h3>
    </div>
    <div class="vc-body-b">
        <div style="margin-right:10px; padding-top:13px;">
            <div class="row">
                <div class="col-4">
                    <p>کد سفارش</p>
                </div>
                <div class="col-8" id="order_id">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>وضعیت سفارش</p>
                </div>
                <div class="col-8">
                    <p style="color: coral !important;"><i class="ip-ar-bolt" title="درحال برسی"></i> در حال برسی</p>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <p>سفارش شما با موفقیت ثبت شد و برای برسی سفارش خود به صفحه سفارشات بروید</p>
        </div>
    </div>
    <div class="vc-bf"></div>
</section>

<section class="VCA-font vc-form-Order d-none">
    <div class="vc-hb">
        <h3 id="product_name"></h3>
    </div>
    <div class="vc-body-b">
        <form method="post" class="form-Order">
            <input type="hidden" name="user-ID" id="user-ID" value="<?php echo esc_attr(get_current_user_id()); ?>">
            <input type="hidden" name="product-ID" id="product-ID" value="">
            <input type="hidden" name="sale-type" id="sale-type" value="">
            <input type="hidden" name="order-status" id="order-status" value="1">
            <input type="hidden" name="product-type" id="product-type" value="">
            <input type="hidden" name="date" id="date" value="">
            <input type="hidden" name="Hour" id="Hour" value="">
            <div class="row">
                <div class="col-4 text-center">
                    <p class="text-product-type">گرم طلا</p>
                </div>
                <div class="col-8"><input type="text" name="Qty" id="Qty" /><span id="measure">گرم</span></div>
            </div>
            <div class="row">
                <div class="col-4 text-center">
                    <p>قیمت کل</p>
                </div>
                <div class="col-8"><input type="text" name="total" id="total" /><input type="hidden" name="total2" id="total2" />
                    <p class="total3">مبلغ وارد شده <span id="total3"></span> تومان</p>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">ثبت سفارش</button>
        </form>
    </div>
    <div class="vc-bf"></div>
</section>


<div class="vc-alert">
    لطفا اطلاعات لازم را به درستی وارد کنید
</div>