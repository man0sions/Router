<?php

namespace LuciferP;

/**
 * 该类的作用是
 * 1:校验uri请求是否合法
 *
 * 2:解析uri参数
 * 例如: /name/zhangsan/age/20 解析为 ['name'=>'zhangsan','age'=>20]
 * Class ResloveRequest
 * @package LuciferP
 * @author Luficer.p <81434146@qq.com>
 */

class ResloveRequest
{
    private $request;

    /**
     * 校验uri合法性及解析uri参数
     *
     * @param Router $router
     * @param $path
     * @param \Closure $closure
     * @return bool
     */
    public function resloveRequest(Router $router, $path, \Closure $closure)
    {
        $this->request = $router->getRequest();
        if (!$this->checkRequestIsValid($router,$path)) {
            return false;
        }

        preg_match_all("#([0-9a-zA-Z]+)/:([0-9a-zA-Z]+)#", $path, $match);

        if ($match[0]) {
            return $this->parseWidthParams($match);
        }
        if ($this->request['uri'] != $path) {
            return false;
        }
        return true;

    }

    /**
     * 根据客户端中Router::get(),Router::post(),Router::all() 中定义的uri 校验uri合法性
     * 例如 Router::get("/user/:id");
     *
     * @param $path
     * @return bool
     */
    private function checkRequestIsValid($router,$path)
    {
        if(preg_match("#all#",$router->getRequestType($path)))
            return true;

        if(!preg_match("#:[0-9a-zA-Z_]+#",$path))
            return true;
        $pattern = preg_replace("#:[0-9a-zA-Z_]+#", "[0-9a-zA-Z_]+", $path);
        preg_match("#" . $pattern . "#", $this->request['url'], $m);
        if ($m) {
            return true;
        }
        return false;
    }

    /**
     * 解析uri中的参数 例如 /name/zhangsan/age/20  => ['name'=>'zhangsan','age'=>20]
     * @param $match
     * @return bool
     */
    private function parseWidthParams($match)
    {
        $keys = $match[1];
        $ret = [];
        foreach ($keys as $key => $val) {
            preg_match("#" . $val . "/([0-9a-zA-Z]+)#", $this->request['url'], $param);
            if (isset($param[1])) {
                $ret[$val] = $param[1];
            }
        }
        if ($ret) {
            $this->request->setGetParams($ret);
            return true;
        }
        return false;

    }


}