<?php

namespace LuciferP;

/**
 * 该类的目的是实现客户端自定义uri并映射到解析器
 * Class Router
 * @package LuciferP
 * @author Luficer.p <81434146@qq.com>
 */
class Router
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var
     */
    private $response;
    /**
     * @var null
     */
    private $resloveRequest;

    /**
     * @var array
     */
    private $routers = [];
    /**
     * @var array
     */
    private $isRouter = false;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request, Response $response, ResloveRequest $resloveRequest)
    {
        $this->request = $request;
        $this->response = $response;
        $this->resloveRequest = $resloveRequest;
    }


    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     *
     */
    public function run()
    {


        foreach ($this->routers as $key => $router) {
            $valid = $this->resloveRequest->resloveRequest($this, $key, $router);
            if ($valid) {
                $router($this->request, $this->response);
                $this->isRouter = true;
                break;
            }
        }

        if (!$this->isRouter) {
            $this->response->status(404)->send("not found");
        }

    }


    /**
     * @param $path
     * @param \Closure $closure
     */
    public function get($path, \Closure $closure)
    {

        $this->doRouter(__METHOD__, $path, $closure);

    }

    /**
     * @param $path
     * @param \Closure $closure
     */
    public function post($path, \Closure $closure)
    {
        $this->doRouter(__METHOD__, $path, $closure);

    }

    /**
     * @param $path
     * @param \Closure $closure
     */
    public function all($path, \Closure $closure)
    {
        $this->doRouter(__METHOD__, $path, $closure);

    }

    /**
     * @param $path
     * @param \Closure $closure
     * @param array $user
     */
    public function auth($path, \Closure $closure, $user = ['name' => 'admin', 'passwd' => 'admin'])
    {

        $name = $_SERVER['PHP_AUTH_USER'];
        $passwd = $_SERVER['PHP_AUTH_PW'];
        if (!($name == $user['name'] && $passwd == $user['passwd'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        } else {

            $this->doRouter(__METHOD__, $path, $closure);
        }
    }

    private function doRouter($method, $path, $closure)
    {
        $params = $method . '###' . $path;
        $this->routers[$params] = $closure->bindTo($this, __CLASS__);
    }
}