<?php

namespace LuciferP;

/**
 * Class Request
 * @package LuciferP
 * @author Luficer.p <81434146@qq.com>
 */
class Request implements \IteratorAggregate, \ArrayAccess
{
    private $get;
    private $post;
    private $cookies;
    private $env;
    private $server = [];
    private $requests = [];
    private $homeUrl;
    private $url;
    private $uri;

    /**
     * Request constructor.
     */
    function __construct()
    {

        $this->get = $this->filter($_GET);
        $this->post = $this->filter($_POST, INPUT_POST);
        $this->cookies = $this->filter($_COOKIE, INPUT_COOKIE);
        $this->env = $this->filter($_ENV, INPUT_ENV);
        $this->server = $this->filter($_SERVER, INPUT_SERVER);
        $this->homeUrl = $this->getHomeUrl();
        $this->url = $this->getUrl();
        $this->uri = $this->server['REQUEST_URI'];
        $this->requests['get'] = $this->get;
        $this->requests['post'] = $this->post;
        $this->requests['cookies'] = $this->cookies;
        $this->requests['url'] = $this->url;
        $this->requests['uri'] = $this->uri;
        $this->requests['homeUrl'] = $this->homeUrl;
        $this->requests['method'] = $this->server['REQUEST_METHOD'];
//        $this->requests['server'] = $this->server;

    }

    /**
     * @return string
     */
    private function getUrl()
    {
        return $this->getHomeUrl() . $this->server['REQUEST_URI'];
    }

    /**
     * @return string
     */
    private function getHomeUrl()
    {
        $prfix = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
//        $dir = preg_replace("#index\.php#", "", $this->server['SCRIPT_NAME']);
        $url = $prfix . $this->server['HTTP_HOST'];

        return $url;

    }

    /**
     * @param $params
     * @param int $type
     * @return array
     */
    private function filter($params, $type = INPUT_GET)
    {
        $ret = [];
        foreach ($params as $key => $param) {
            $ret[$key] = filter_input($type, $key, FILTER_DEFAULT);
        }
        return $ret;
    }

    /**
     * @param $get
     */
    public function setGetParams($get){
        $this->get = $get;
        $this->requests['get'] = $get;

    }
    function getIterator()
    {
        return new \ArrayIterator($this->requests);
    }


    function offsetExists($offset)
    {
        return isset($this->requests[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->requests[$offset];
    }

    function offsetSet($offset, $value)
    {
        throw new \Exception("can't set this value:{$value}");
    }

    function offsetUnset($offset)
    {
        throw new \Exception("can't unset this offset:{$offset}");
    }

}