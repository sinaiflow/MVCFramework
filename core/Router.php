<?php
namespace app\core;

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
            return$this->renderView('_404');
        }
        $callback = $this->routes[$method][$path];
        if (is_string($callback))
        {
            return $this->renderView($callback);
        }
        if (is_array($callback))
        {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        return call_user_func($callback,$this->request);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value)
        {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

}