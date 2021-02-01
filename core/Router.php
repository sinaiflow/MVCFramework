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

    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();
        $path = preg_replace('~MVCFramework/~','',$path); //in my case, if you have single site in localhost - remove this
        if (!isset($this->routes[$method][$path]))
        {
            $this->response->setStatusCode(404);
            return 'Not found';
        }
        $callback = $this->routes[$method][$path];
        if (is_string($callback))
        {
            return $this->renderView($callback);
        }
        return call_user_func($callback);
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}',$viewContent,$layoutContent);
        include_once Application::$ROOT_DIR . "/views/$view.php";
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}