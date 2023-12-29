<?php

if (!defined('ABSPATH')) {
    exit;
}


abstract class Base_Menu
{
    protected $page_title;
    protected $menu_title;
    protected $capability;
    protected $menu_slug;
    protected $icon;
    protected $position;
    protected $has_sub_menu = false;
    protected $sub_items;

    public function __construct()
    {
        $this->capability = 'manage_options';
        add_action('admin_menu', [$this, 'create_menu']);
    }

    public function create_menu()
    {

        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$this, 'page'],
            $this->icon,
            $this->position,
        );
        if ($this->has_sub_menu) {
            foreach ($this->sub_items as $item) {

                add_submenu_page(
                    $this->menu_slug,
                    $item['page_title'],
                    $item['menu_title'],
                    $this->capability,
                    $item['menu_slug'],
                    [$this, $item['callback']],
                    $item['position']
                );
            }
        }
        remove_submenu_page($this->menu_slug, $this->menu_slug);
    }

    abstract public function page();
}
