<?php
namespace app\core;

class Router
{

    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $path = preg_replace('~FrameworkMVC/~','',$path);

        $callback = $this->routes[$method][$path];
        if (!$callback)
        {
            return 'Not found';
            exit();
        }
        echo call_user_func($callback);
    }

}