jQuery(document).ready(function () {
  const modal = jQuery('.vc-alert');
  const tpt = jQuery('.text-product-type');
  const formBuy = jQuery(".form-Buy");
  const formSelling = jQuery(".form-Selling");
  const formOrder = jQuery(".form-Order");
  const formShowInfoModal = jQuery(".form-show-info-modal");
  const date = moment();

  function productType(productType) {
    if (productType == 1) {
      tpt.html('<p>وزن</p>');
      jQuery("#total").prop("disabled", false);
    } else if (productType == 2) {
      tpt.html('<p>تعداد</p>');
      jQuery("#total").prop("disabled", true);
    }
  }

  const yourParsedNumber = null;

  function handleSubmit(form, saleType) {
    form.submit(function (e) {
      e.preventDefault();
      const ID = jQuery(this).find(`.${saleType}-ID`).val();
      let yourParsedNumber = jQuery(this).find(`.${saleType}`).val();
      updateTotalOnQty(yourParsedNumber);
      jQuery(".vc-form-Order").removeClass("d-none");
      jQuery(".form-Order").trigger("reset");
      productType(jQuery(this).find(`.${saleType}-product-type`).val());
      jQuery("#product_name").text(jQuery(this).find(`.${saleType}-product-name`).val());
      jQuery("#product-ID").val(ID);
      jQuery("#sale-type").val(saleType === 'Buy' ? '1' : '2');
      jQuery("#product-type").val(jQuery(this).find(`.${saleType}-product-type`).val());
      jQuery("#measure").text(jQuery(this).find(`.${saleType}-measure`).val());
      let Datet = date.format('YYYY-MM-DD');
      let Hour = date.format('HH:mm:ss');
      jQuery("#date").val(Datet);
      jQuery("#Hour").val(Hour);
      jQuery("#total3").text('0');
      jQuery("#total2").val('');
    });
  }

  function updateTotalOnQty(parsedNumber) {
    jQuery("#Qty").on("input", function () {
      const QtyValue = jQuery(this).val();

      // بررسی مقدار معتبر برای محاسبه
      if (!isNaN(QtyValue) && !isNaN(parsedNumber)) {
        const total = QtyValue * parsedNumber;
        jQuery("#total").val(total);
        jQuery("#total3").text(total.toLocaleString());
        jQuery("#total2").val(total);
      } else {
        // اعلام خطا یا انجام عملیات دیگر در صورت مقدار نامعتبر
        console.error("Invalid input");
      }
    });

    jQuery("#total").on("input", function () {
      const totalValue = jQuery(this).val();

      // بررسی مقدار معتبر برای محاسبه
      if (!isNaN(totalValue) && !isNaN(parsedNumber)) {
        const Qty = parseInt(totalValue / parsedNumber);
        jQuery("#Qty").val(Qty);
        jQuery("#total3").text(parseFloat(jQuery(this).val()).toLocaleString('fa-IR'));
        jQuery("#total2").val(totalValue);
      } else {
        // اعلام خطا یا انجام عملیات دیگر در صورت مقدار نامعتبر
        console.error("Invalid input");
      }
    });
  }


  handleSubmit(formBuy, 'Buy');
  handleSubmit(formSelling, 'Selling');

  jQuery(".form-Order").submit(function (e) {
    e.preventDefault();

    const form_data = new FormData();
    form_data.append('action', 'vc_submit_form_Order');
    form_data.append('nonce', VC_DATA.nonce);
    form_data.append('user_ID', jQuery('#user-ID').val());
    form_data.append('product_ID', jQuery('#product-ID').val());
    form_data.append('sale_type', jQuery('#sale-type').val());
    form_data.append('order_status', jQuery('#order-status').val());
    form_data.append('product_type', jQuery('#product-type').val());
    form_data.append('Qty', jQuery('#Qty').val());
    form_data.append('total', jQuery('#total2').val());
    form_data.append('Date', jQuery('#date').val());
    form_data.append('Hour', jQuery('#Hour').val());

    jQuery.ajax({
      type: "post",
      url: VC_DATA.ajax_url,
      data: form_data,
      processData: false,
      contentType: false,

      success: function (response) {
        if (response.__success) {
          if (response.results == null) {
            modal.css({ background: 'red', display: 'inline' }).html('تعداد و یا وزن محصول خود را وارد نمایید');
          } else {
            modal.css({ background: 'green', display: 'inline' }).html('سفارش شما با موفقیت ثبت شد');
            jQuery(".vc-form-Order").addClass("d-none");
            jQuery(".form-Order").trigger("reset");
            jQuery(".vc-t-Order").removeClass("d-none");
            jQuery("#order_id").text(response.results);
          }
        }
      },
      error: function (error) {
        modal.css({ background: 'red', display: 'inline' }).html('خطای 20 رخ داده است');
      }
    });
    setTimeout(function () {
      modal.css('display', 'none');
      jQuery(".vc-t-Order").addClass("d-none");
    }, 10000);
  });

  formShowInfoModal.submit(function (e) {
    e.preventDefault();

    const form_data = new FormData();
    form_data.append('action', 'form_show_info_modal');
    form_data.append('nonce', VC_DATA.nonce);
    var date = jQuery(this).data("date");
    jQuery(this).closest('.vc-item-row').find('input, select, textarea').each(function () {
      var fieldName = jQuery(this).attr('name');
      var fieldValue = jQuery(this).val();
      form_data.append(fieldName, fieldValue);
      jQuery(".modal-title").html(fieldValue);
    });

    jQuery.ajax({
      url: VC_DATA.ajax_url,
      type: 'POST',
      data: form_data,
      processData: false,
      contentType: false,

      success: function (response) {
        if (response.__success) {
          var orderInfoContent = "";
          if (response.results) {
            response.results.forEach(function (order) {

              orderInfoContent += '<div class="vc-mitem VCA-font">';

              orderInfoContent += '<div class="vcmitemh" style="background-color: ' + order.order_status_Color + ';">';
              orderInfoContent += ' <h4>' + order.products_sale_type + ' - ' + order.products + '</h4>';
              orderInfoContent += '</div>';
              orderInfoContent += '<div class="vcmitemb VCA-font">';

              orderInfoContent += '<div class="vcitem">';
              orderInfoContent += '<div class="row VCA-font">';
              orderInfoContent += '<div class="col-3">کد سفارش</div>';
              orderInfoContent += '<div class="col-9">' + order.ID + '</div>';
              orderInfoContent += '</div>';
              orderInfoContent += '</div>';

              orderInfoContent += '<div class="vcitem">';
              orderInfoContent += '<div class="row VCA-font">';
              orderInfoContent += '<div class="col-3">فی</div>';
              orderInfoContent += '<div class="col-9">' + order.Price + '</div>';
              orderInfoContent += '</div>';
              orderInfoContent += '</div>';

              orderInfoContent += '<div class="vcitem">';
              orderInfoContent += '<div class="row VCA-font">';
              orderInfoContent += '<div class="col-3">' + order.titel_Qty + '</div>';
              orderInfoContent += '<div class="col-9">' + order.Qty + ' ' + order.titel_t + '</div>';
              orderInfoContent += '</div>';
              orderInfoContent += '</div>';

              orderInfoContent += '<div class="vcitem">';
              orderInfoContent += '<div class="row VCA-font">';
              orderInfoContent += '<div class="col-3">مبلغ نهایی</div>';
              orderInfoContent += '<div class="col-9">' + order.total + '</div>';
              orderInfoContent += '</div>';
              orderInfoContent += '</div>';

              orderInfoContent += '</div>';
              orderInfoContent += '<div class="vcmitemf">';
              orderInfoContent += '<p>' + order.Date + ' ساعت ' + order.Hour + '</p>';
              orderInfoContent += '</div>';

              orderInfoContent += '<div class="iconbg">';
              orderInfoContent += '<i class="' + order.order_status_icon + ' "></i>';
              orderInfoContent += '</div>';

              orderInfoContent += '</div>';
            });
          } else {
            orderInfoContent += "اطلاعات دریافت نشد";
          }

          jQuery("#orderInfo").html(orderInfoContent);
          jQuery("#infoModal").modal("show");
        }
      },
      error: function () {
        alert('خطایی رخ داده است!');
      }
    });
  });
});