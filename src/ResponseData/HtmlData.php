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

class HtmlData extends DataFormat
{
    public function format(Response $response)
    {
        if(!is_string($this->data))
            $this->data = var_export($this->data);

        return $this->data;
    }
}