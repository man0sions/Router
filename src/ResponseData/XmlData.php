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
use Spatie\ArrayToXml\ArrayToXml;

class XmlData extends DataFormat
{
    public function format(Response $response)
    {
        if(!is_array($this->data))
            $this->data = (array)($this->data);
        $xml = ArrayToXml::convert($this->data);
        $response->setResponseContentType("text/xml");
        $response->setResponseBody($xml);
        return $xml;
    }
}