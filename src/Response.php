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
        $length = mb_strlen($this->responseBody);
        header("HTTP/1.1 {$this->responseCode}");
        header("Content-type: {$this->responseContentType}");
        header("Content-length:{$length}");
    }

    /**
     * @param $code
     */
    public function setResponseCode($code)
    {
        $this->responseCode = $code;
    }

    /**
     * @param $type
     */
    public function setResponseContentType($type)
    {
        $this->responseContentType = $type;
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