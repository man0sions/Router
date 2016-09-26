<?php
/**
 * Created by PhpStorm.
 * @author Luficer.p <81434146@qq.com>
 * Date: 16/9/23
 * Time: 下午2:04
 */

namespace LuciferP\ResponseData;


use LuciferP\Base\DataFormat;
use LuciferP\Response;

class JsonData extends DataFormat
{
    public function format(Response $response)
    {
        $data = json_encode($this->data);
        $response->setResponseContentType("text/json");
        $response->setResponseBody($data);
        return $data;
    }
}