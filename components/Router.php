<?php

class Router
{
    
    //массив для хранения маршрутов
    private $routes;
    
    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }
    
    /**
    * Returns request string
    * @return string
    */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'],'/');
        }
         
    }
    
    public function run()
    {   
        // Получить строку запроса
        $uri = $this->getURI();                       
                                 
        // Проверить наличие запроса в routes
        foreach($this->routes as $uriPattern => $path){
            if (preg_match("~$uriPattern~", $uri)){
                
                // Получаем внутренний путь из внешнего согласно правилу.
                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                
                
                // Определяем Controller, action, parameters 
                
                $segments = explode('/', $internalRoute);
                array_shift($segments).'Controller'; // избавляемся от корня на локалке
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action'.ucfirst(array_shift($segments));
                
                $parameters = $segments;
            
                
                
                
                
                // Подключить файл класса контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                
                if (file_exists($controllerFile)){
                    include_once($controllerFile);
        
                }
                
                // Создать объект, вызвать метод (т.е action)
                
                

        
                $controllerObject = new $controllerName;
                
                $result = call_user_func_array(Array($controllerObject, $actionName), $parameters);
                
                if ($result != null){
                    break;
                }
                
            }
        }
    }
}



?>

