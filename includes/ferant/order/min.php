<section class="vc-order">
    <div class="vc-header">
        <h2 class="VCA-font">سفارشات</h2>
    </div>

    <div class="vc-header-row">
        <div class="row VCA-font">
            <div class="col-7">تاریخ</div>
            <div class="col-5">
                <div class="row">
                    <span class="col-6">تعداد</span>
                    <span class="col-6">سفارشات</span>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once(G_includes_DIR . 'JD.php');
    $user_id = get_current_user_id();

    if (count($datetime)) :
    ?>
        <?php
        $groupedDates = array();

        foreach ($datetime as $item) {
            if ($item->user_id == $user_id) {
                $date = $item->Date;

                // اگر تاریخ در آرایه وجود ندارد، آن را به آرایه اضافه کنید
                if (!array_key_exists($date, $groupedDates)) {
                    $groupedDates[$date] = array();
                }

                // افزودن موارد به گروه مربوطه
                $groupedDates[$date][] = $item;
            }
        }

        // نمایش گروه‌ها
        foreach ($groupedDates as $date => $group) : ?>
            <div class="vc-item-row">
                <div class="row VCA-font">
                    <div class="col-7">
                        <?php
                        // تاریخ گرفته شده از دیتابیس
                        $databaseDate = $date; // باید از دیتابیس گرفته شود

                        // تبدیل تاریخ به فرمت مورد نظر
                        $formattedDate = jdate("l, j  F  Y", strtotime($databaseDate));

                        // نمایش تاریخ
                        echo $formattedDate;
                        ?>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <?php
                            // تعداد سفارشات هر کاربر بر اساس تاریخ
                            $userOrderCount = 0;
                            $user_id = get_current_user_id();
                            foreach ($group as $item) {
                                if ($item->user_id == $user_id) {
                                    $userOrderCount++;
                                }
                            }

                            // نمایش تعداد سفارشات هر کاربر
                            ?>
                            <span class="col-6"><?php echo $userOrderCount; ?></span>
                            <span class="col-6">
                                <form method="post" class="form-show-info-modal">
                                    <input type="hidden" value="<?php echo $date ?>" name="date" class="date">
                                    <input type="hidden" value="<?php echo $formattedDate ?>" name="jdate" class="jdate">
                                    <button type="submit" class="btn btn-primary">نمایش</button>
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="vc-footer"></div>
</section>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel"></h5>
            </div>
            <div class="modal-body">
                <div class="su">
                    <?php
                    foreach ($statu as $item) {
                        echo ' <p>' . $item->name . '<span style="background-color:' . $item->Color . ' ;" ><i class="' . $item->icon . '"></i></span></p>';
                    }
                    ?>

                </div>
                <div id="orderInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>