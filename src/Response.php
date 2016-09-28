<?php

namespace LuciferP;


use LuciferP\Base\Data;
use LuciferP\Base\DataFormat;

/**
 * Class Response
 * @package LuciferP
 * @author Luficer.p <81434146@qq.com>
 */
class Response
{
    private $responseCode = 200;
    private $responseContentType = 'text/html';
    private $responseBody = '';

    public function __construct()
    {
    }

    /**
     * 设置头信息
     */
    public function sendHeader()
    {
        $length = strlen($this->responseBody);
        header("HTTP/1.1 {$this->responseCode}");
        header("Content-type: {$this->responseContentType}");
        header("Content-length:{$length}");
        header("Powered-by: Lucifer.p");
    }

    /**
     * @param $code
     * @return $this
     */
    public function status($code)
    {
        $this->responseCode = $code;
        return $this;
    }

    /**
     * @param $string
     */
    public function send($string)
    {
        $this->setResponseBody($string);
        $this->sendHeader();
        echo $string;
        exit();
    }


    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->responseContentType = $type;
        return $this;
    }

    /**
     * @param array $arr
     */
    public function json(array $arr)
    {
        $this->type("text/json");
        $this->send(json_encode($arr));
    }

    /**
     * @param array $arr
     */
    public function jsonp(array $arr, $cb = 'callback')
    {
        $this->type("text/jsonp");
        $body = sprintf('%s(%s)', $cb, json_encode($arr));
        $this->send($body);
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header("location:$url");
        exit();
    }

    /**
     * @param $tpl
     * @param $data
     * @throws \Exception
     */
    public function render($tpl, $data)
    {
        if (!file_exists($tpl)) {
            throw new \Exception("tpl not exists !");
        }
        extract($data);
        ob_start();
        require $tpl;
        $content = ob_get_contents();
        ob_end_clean();

        $this->send($content);

    }

    /**
     * @param $body
     */
    public function setResponseBody($body)
    {
        $this->responseBody = $body;
    }

    /**
     * @param DataFormat $dataFormat
     * @return mixed
     */
    public function dataformat(DataFormat $dataFormat)
    {
        $data = $dataFormat->format($this);
        $this->sendHeader();
        return $data;
    }




}