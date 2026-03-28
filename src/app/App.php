<?php

namespace AntonBezmelnitsin\ExplainHub;

use Illuminate\View\Factory as ViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\Events\Dispatcher;

class App
{
    private ViewFactory $view;
    private array $routes = [];

    public function __construct()
    {
        $this->initView();
        $this->initRoutes();
    }

    protected function initView(): void
    {
        $config = require dirname(__DIR__) . "/../config/view.php";

        $filesystem = new Filesystem();
        $resolver = new EngineResolver();

        $bladeCompiler = new BladeCompiler($filesystem, $config["compiled"]);
        $resolver->register("blade", function () use ($bladeCompiler) {
            return new CompilerEngine($bladeCompiler);
        });

        $finder = new FileViewFinder($filesystem, $config["paths"]);

        $this->view = new ViewFactory($resolver, $finder, new Dispatcher());
    }

    protected function initRoutes(): void
    {
        $this->routes["GET"]["/"] = function () {
            return $this->view->make("auth.login")->render();
        };
        $this->routes["GET"]["/login"] = function () {
            return $this->view->make("auth.login")->render();
        };
        $this->routes["GET"]["/register"] = function () {
            return $this->view->make("auth.register")->render();
        };
    }

    public function run(): void
    {
        $request = Request::createFromGlobals();
        $method = $request->getMethod();
        $path = $request->getPathInfo();

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler) {
            $content = $handler($request);
            $response = new Response($content);
        } else {
            $response = new Response("404 Not Found", 404);
        }

        $response->send();
    }
}