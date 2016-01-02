<?php
abstract class Widget_BaseModel
{
    protected static $_front_controller = null;

    /**
     * 获取前端控制器
     *
     * @return RThink_Controller_Front
     */
    protected static function getFrontController()
    {
        // Used cache version if found
        if (null === self::$_front_controller) {
            class_exists('RThink_Controller_Front', false) || require 'RThink/Controller/Front.php';
            self::$_front_controller = RThink_Controller_Front::getInstance();
        }

        return self::$_front_controller;
    }

}