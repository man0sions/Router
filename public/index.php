<?php
/**
 * Created by PhpStorm.
 * @author Luficer.p <81434146@qq.com>
 * Date: 16/9/22
 * Time: 下午3:29
 */
define("BASE_PATH", __DIR__);
require BASE_PATH . '/../vendor/autoload.php';

$router = \LuciferP\Base\RouterFactory::getRouter();

/**
 * 1:简单用法
 */

$router->get('/hello',function(){
   return "hello";
});

/**
 * 1.1: get参数
 */

$router->get('/hello/:name', function () {
    $query = $this->request['get'];
    return json_encode($query);
});

/**
 * 1.2 post参数
 */

$router->post('/hello', function () {
    $query = $this->request['post'];
    return json_encode($query);
});

/**
 * 2:高级用法
 *
 */

/**
 * 2.1 格式化response
 * html---\LuciferP\ResponseData\HtmlData
 * json---\LuciferP\ResponseData\JsonData
 * xml----\LuciferP\ResponseData\XmlData
 */
$router->get('/user/:name/age/:age', function () {
    $query = $this->request['get'];
    return $this->response->dataformat(new \LuciferP\ResponseData\XmlData($query));
});

/**
 * 2.2 自定义response headers
 * 详细使用方法查看\LuciferP\Response
 */

$router->get("/404", function () {
    $body = "404 not found";
    $this->response->setResponseCode(404);
    $this->response->setResponseBody($body);
    $this->response->sendHeader();
    return $body;
});




$router->all("/",function(){
    return "welcome";
});



$router->run();