# 一个简单性感的php router



## Install
```
composer require lucifer_p/router

```

## useage

### 1:简单用法
```

$router = \LuciferP\Base\RouterFactory::getRouter();


$router->get('/hello',function(){
   return "hello";
});

$router->run();


```

### 1.1 参数解析
```
//get
$router->get('/hello/:name', function () {
    $query = $this->request['get'];
    return json_encode($query);
});

//post
$router->post('/hello', function () {
    $query = $this->request['post'];
    return json_encode($query);
});

```
### 2:高级用法

```
/**
 * 2.1 格式化response
 * html---\LuciferP\ResponseData\HtmlData
 * json---\LuciferP\ResponseData\JsonData
 * xml----\LuciferP\ResponseData\XmlData
 */
$router->get('/user/:name/age/:age', function () {
    $query = $this->request['get'];
    return $this->response->dataformat(new \LuciferP\ResponseData\XmlData($query));
});


/**
 * 2.2 自定义response headers
 * 详细使用方法查看\LuciferP\Response
 */

$router->get("/404", function () {
    $body = "404 not found";
    $this->response->setResponseCode(404);
    $this->response->setResponseBody($body);
    $this->response->sendHeader();
    return $body;
});
```
### 3.最后别忘了加上 $router->run();

```
$router->run();

```