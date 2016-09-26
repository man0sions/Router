<?php
/**
 * Created by PhpStorm.
 * @author Luficer.p <81434146@qq.com>
 * Date: 16/9/23
 * Time: 下午2:03
 */

namespace LuciferP\Base;


use LuciferP\Response;

abstract class DataFormat
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function format(Response $response);
}