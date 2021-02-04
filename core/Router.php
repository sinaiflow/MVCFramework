<?php
namespace app\core;

use app\core\exception\NotFoundException;

class Router
{

    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path,$callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $path = preg_replace('~MVCFramework/~','',$path); //in my case, if you have single site in localhost - remove this
        if (!isset($this->routes[$method][$path]))
        {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }
        $callback = $this->routes[$method][$path];
        if (is_string($callback))
        {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback))
        {
            /** @var Controller $controller */
            $controller= new $callback[0]();

            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = Application::$app->controller;

            foreach ($controller->getMiddlewares() as $middleware)
            {
                $middleware->execute();
            }
        }
        return call_user_func($callback,$this->request, $this->response);
    }

}