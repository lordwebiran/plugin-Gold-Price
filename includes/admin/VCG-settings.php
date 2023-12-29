
<?php

if (class_exists('CSF')) {

  $prefix = 'VCG-settings';

  CSF::createOptions($prefix, array(
    'menu_title' => 'تنظیمات',
    'menu_slug'  => 'settings',
    'framework_title' => 'تنظیمات افزونه ثبت سفارش گلد <span>ورژن ' . VCG_VER . ' </span>',
    'footer_text' => '',
    'menu_hidden' => true,
  ));

  CSF::createSection($prefix, array(
    'title'  => 'تنظیمات سفارشی',
    'fields' => array(

      array(
        'id'        => 'VCA-font',
        'type'      => 'image_select',
        'title'     => 'انتخاب فونت',
        'options'   => array(
          'Vazir' => G_ASSETS_URL.'img/VCA-font/Vazir.png',
          'images' => 'http://codestarframework.com/assets/images/placeholder/80x80-2c3e50.gif',
        ),
        'default'   => 'Vazir'
      ),
      array(
        'id'        => 'VCA-font-Vazir',
        'type'      => 'image_select',
        'title'     => 'فونت وزیر',
        'options'   => array(
          'Vazir-en' => G_ASSETS_URL.'img/VCA-font/Vazir_en.png',
          'Vazir-fa' => G_ASSETS_URL.'img/VCA-font/Vazir_fa.png',
        ),
        'default'   => 'Vazir-fa',
        'dependency' => array('VCA-font', '==', 'Vazir')
      ),
      array(
        'id'     => 'color',
        'type'   => 'color',
        'title'  => 'رنگ متن طلایی',
        'output_important'  => true,
        'output'      => array('.vc-order .vc-item-row button.btn.btn-primary', '.vc-orders-admin .vc-header-row', '.vc-order .vc-header-row', '.vc-coler-gold'),
        'output_mode' => 'color',
        'default' => '#ba7809'
      ),
      array(
        'id'     => 'background-color',
        'type'   => 'color',
        'title'  => 'رنگ پس زمینه',
        'output_important'  => true,
        'output'      => array('.vc-body ', '.vc-heah', '.vc-footer', '.vc-hb', '.vc-body-b', '.vc-bf', '.vc-vc-orders-admin', '.vc-order .vc-header', '.vc-orders-admin .vc-header', '.vc-order .vc-header-row', '.vc-orders-admin .vc-header-row', '.vc-order .vc-item-row', '.vc-orders-admin .vc-item-row', '.vc-order .vc-item-row button.btn.btn-primary:hover', '.vc-order .vc-footer', '.vc-body-border button', '.vc-mitem', '.modal-content'),
        'output_mode' => 'background-color',
        'default' => '#000000'
      )
    )
  ));
}
