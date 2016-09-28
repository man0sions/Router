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
 * $res->status() 设置返回码[默认200] 200,404,500 ...
 * $res->type()   设置返回类型[默认 text/html] text/json...
 * $res->json()   在页面输出json
 * $res->jsonp()  在页面输出jsonp
 * $res->render() 把数据渲染到指定的页面
 */

$router->get('/home', function (\LuciferP\Request $req, \LuciferP\Response $res) {

//  $res->status(200)->send(json_encode($req));
//  $res->type('text/json')->send(json_encode($req));
//  $res->json(['hello'=>'world']);
//  $res->jsonp(['hello'=>'world']);
//  $res->redirect("http://baidu.com");
    $res->status(200)->type('text/html')->render(BASE_PATH . "/../views/view.php", ['name' => 'zhangsan', 'age' => 20]);
});

/**
 * 1.1: get参数
 */

$router->get('/hello/:name', function ($req, $res) {
    $query = $req['get'];
    $res->json($query);
});

/**
 * 1.2 post参数
 */

$router->post('/hello', function ($req, $res) {
    $query = $req['post'];
    $res->json($query);
});

/**
 * 2:高级用法
 *
 */

/**
 * 2.1 auth
 * 用户名密码默认为:admin,admin
 */
$router->auth("/auth", function ($req, $res) {

    $res->send("欢迎回来");


}, ['name' => 'admin', 'passwd' => 'admin']);


/**
 * 2.2 格式化response
 * html---\LuciferP\ResponseData\HtmlData
 * json---\LuciferP\ResponseData\JsonData
 * xml----\LuciferP\ResponseData\XmlData
 */
$router->get('/name/:name/age/:age', function ($req, $res) {
    $query = $req['get'];
    $xml = $res->dataformat(new \LuciferP\ResponseData\XmlData($query));
    $res->type("text/xml")->send($xml);
});


/**
 * 2.3 指定所有[get,post]请求 "/"
 */
$router->all("/", function ($req, $res) {
    $res->send("all page");
});


$router->run();