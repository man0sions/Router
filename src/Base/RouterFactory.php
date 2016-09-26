<?php
/**
 * Created by PhpStorm.
 * @author Luficer.p <81434146@qq.com>
 * Date: 16/9/26
 * Time: 上午10:52
 */

namespace LuciferP\Base;


use LuciferP\Router;

class RouterFactory
{
    private static $router = null;

    public static function getRouter()
    {
        $request = new \LuciferP\Request();
        $response = new \LuciferP\Response();
        $reslove = new \LuciferP\ResloveRequest();

        if (self::$router == null) {
            self::$router = new Router($request,$response,$reslove);
        }
        return self::$router;
    }
}