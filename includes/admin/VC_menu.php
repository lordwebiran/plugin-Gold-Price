<?php 
if ( ! defined( 'ABSPATH' ) ) {exit;}


class VC_Menu extends Base_Menu{

    public function __construct(){
        $this->page_title = 'ثبت سفارش گلد';
        $this->menu_title = 'ثبت سفارش گلد';
        $this->menu_slug = 'VC_Gold';
        $this->icon = G_ASSETS_URL.'img/clipboard.png';
        $this->position = 7;
        $this->has_sub_menu = true;
        $this->sub_items =[
            'settings'=>[
                'page_title'=>'تنظیمات',
                'menu_title'=>'تنظیمات',
                'menu_slug' =>'settings',
                'callback'  =>'',
                'position'  => 10,
            ],
            'products'=>[
                'page_title'=>'محصولات',
                'menu_title'=>'محصولات',
                'menu_slug' =>'VC-products',
                'callback'  =>'VC_products',
                'position'  => 1,
            ],
            //'VC_purchase_type'=>[
            //    'page_title'=>'دسته بندی محصولات',
            //    'menu_title'=>'دسته بندی محصولات',
            //    'menu_slug' =>'purchase-type',
            //    'callback'  =>'VC_purchase_type',
            //    'position'  => 2,
            //],
            //'purchase_sale_type'=>[
            //    'page_title'=>'purchase sale type',
            //    'menu_title'=>'purchase sale type',
            //    'menu_slug' =>'sale-type',
            //    'callback'  =>'purchase_sale_type',
            //    'position'  => 3,
            //],
            'VC_order_status'=>[
                'page_title'=>'وضعیت سفارشات',
                'menu_title'=>'وضعیت سفارشات',
                'menu_slug' =>'order-status',
                'callback'  =>'VC_order_status',
                'position'  => 2,
            ],
            'orders'=>[
                'page_title'=>'سفارشات',
                'menu_title'=>'سفارشات',
                'menu_slug' =>'VC-orders',
                'callback'  =>'VC_orders',
                'position'  => 3,
            ]
        ];

        parent::__construct();
    }
    public function page(){
        echo '<h2>امکان شخسی سازی توسط توسعه دهنده با ذکر منبع</h2>';
    }
    public function VC_products(){
        $manager=new VC_products();
        $manager->page();
    }
    public function VC_purchase_type(){
        $manager=new VC_product_type_manager();
        $manager->page();
    }
    public function VC_purchase_sale_type(){
        $manager=new VC_purchase_sale_type();
        $manager->page();
    }
    public function VC_order_status(){
        $manager=new VC_order_status();
        $manager->page();
    }
    public function VC_orders(){
        $manager=new VC_Order_Manager_admin();
        $manager->page();
    }
    public function sale_m(){
        $manager=new VC_sale_m();
        $manager->page();
    }

} 