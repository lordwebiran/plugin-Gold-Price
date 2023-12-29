<?php

defined('ABSPATH') || exit('No Access !!!');

class VC_Flash_Message
{

    const ERROR = 1;
    const SUCCESS = 2;
    const WARNING = 3;
    const INFO = 4;


    public static function add_message($message, $type = self::SUCCESS)
    {

        if (!isset($_SESSION['vc']['messages'])) {
            $_SESSION['vc']['messages'] = [];
        }

        $_SESSION['vc']['messages'][] = ['body' => $message, 'type' => $type];
    }


    public static function show_message()
    {

        if (isset($_SESSION['vc']['messages']) && !empty($_SESSION['vc']['messages'])) {

            foreach ($_SESSION['vc']['messages'] as $message) {
                echo '<div class="notice is-dismissable '. self::get_type($message['type']) .'">';
                echo '<p>';
                echo $message['body'];
                echo '</p>';
                echo '</div>';
            }

            self::empty_session();
        }
    }

    public static function get_type($type)
    {

        switch ($type) {

            case 2:
                return 'notice-success';
                break;
            case 1:
                return 'notice-error';
                break;
            case 3:
                return 'notice-warning';
                break;
            case 4:
                return 'notice-info';
                break;
        }
    }


    public static function empty_session()
    {
        $_SESSION['vc']['messages'] = [];
    }
}
