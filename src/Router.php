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
    private $requestType = [];

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request, Response $response,ResloveRequest $resloveRequest)
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


        foreach ($this->routers as $path => $router) {
            $request = $this->resloveRequest->resloveRequest($this, $path, $router);


            if ($request && preg_match("/" . $this->request['method'] . "/i", $this->requestType[$path])
            ) {
                $body = $router();

                echo $body;
                exit();
            }
            if (preg_match("#all#", $this->requestType[$path])) {
                $body = $router();
                echo $body;
                exit();
            }

        }
    }

    /**
     * @param $path
     * @return null
     */
    public function getRequestType($path)
    {
        return isset($this->requestType[$path]) ? $this->requestType[$path] : null;

    }

    /**
     * @param $path
     */
    public function redirect($path)
    {
        header("location:$path");
        exit();
    }

    /**
     * @param $path
     * @param \Closure $closure
     */
    public function get($path, \Closure $closure)
    {
        $this->requestType[$path] = __METHOD__;

        $this->routers[$path] = $closure->bindTo($this, __CLASS__);
    }

    /**
     * @param $path
     * @param \Closure $closure
     */
    public function post($path, \Closure $closure)
    {
        $this->requestType[$path] = __METHOD__;

        $this->routers[$path] = $closure->bindTo($this, __CLASS__);

    }

    /**
     * @param $path
     * @param \Closure $closure
     */
    public function all($path, \Closure $closure)
    {
        $this->requestType[$path] = __METHOD__;
        $this->routers[$path] = $closure->bindTo($this, __CLASS__);
    }
}