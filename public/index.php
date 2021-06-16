<?php
session_start();

require_once "../config/Base.php";

require_once  "../vendor/autoload.php";

use Framework\Authentication\Auth;
use Framework\Http\Middlewares\Middlewares;
use Framework\Http\Requests\Request;
use Framework\Http\Routes\Routes;
use Framework\Http\Status\Status;
use Firebase\JWT\ExpiredException;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

require "../routes/web.php";


//Comprobamos si hay cookie de sesion(Permanecer Conectado) y en ese caso se la asignamos a la sesión.
if (!isset($_SESSION['token'])) {
    if (isset($_COOKIE['session'])) {
        $_SESSION['token'] = $_COOKIE['session'];
    }
}


//Sistema de enrutamiento
$routes = Routes::$$method;

if (isset($routes[$uri])) {
    $classAndFunction = explode(".", $routes[$uri]);

    $namespaceClass = "Controllers\\" . $classAndFunction[0];

    $class = new $namespaceClass;
    $function = $classAndFunction[1];
}else{
    foreach ($routes as $route => $controllerAndMethod) {                   //vemos que rutas tienen al menos unos corchetes
        if(preg_match("/[{]+[\w]+[}]+\z/", $route)){
            $routesWithParams[$route] = $controllerAndMethod;               //almacenamos las rutas con corchetes en un array
        }
    }


    if (isset($routesWithParams)) {
        $uriArray = explode("/", $uri);      

        foreach ($routesWithParams as $route => $controllerAndMethod) {            
            $routeArray = explode("/", $route);                     //creamos un array de cada ruta con corchetes y separándola en sus distintas partes (igual que en la uri)
            
            if (count($uriArray) === count($routeArray)) {        //Si el número de elementos de la uri y el de uno de los arrays coinciden se almacenan esas rutas en un array
                $coincidentsRoutes[$route] = $controllerAndMethod;
            }
        }

        if (isset($coincidentsRoutes)) {
            foreach ($coincidentsRoutes as $route => $controllerAndMethod) {
                $routeArray = explode("/", $route);   

                $noVars = array();
                
                $noVars = preg_grep("/[^{]+[\w]+[^}]+\z/", $routeArray);

                foreach ($noVars as $noVar) {
                    $noVarsPositions[$noVar] = array_search($noVar, $routeArray);
                }

                foreach ($noVarsPositions as $noVar => $position) {
                    if ($routeArray[$position] == $uriArray[$position]) {
                        $sameNoVars = true;
                    }else{
                        $sameNoVars = false;
                        break;
                    }
                }

                if ($sameNoVars) {
                    $definitiveRoute = $controllerAndMethod;
                    break;
                }
            }

            if (isset($definitiveRoute)) {
                $parameters = preg_grep("/[{]+[\w]+[}]+\z/", $routeArray);

                $parametersPositions = array();

                foreach ($parameters as $parameter) {
                    $paramPos = array_search($parameter, $routeArray);
                    array_push($parametersPositions, $paramPos);
                }

                foreach ($parametersPositions as $position) {
                    $nameParameter = $routeArray[$position];  
                                                            
                    $nameParameter = str_replace("{", "", $nameParameter);
                    $nameParameter = str_replace("}", "", $nameParameter);
                                                                                    //Guardamos en un array el nombre de la variable y el valor obtenido en la uri de la siguiente manera:
                    $requestParams[$nameParameter] = $uriArray[$position];            //ej: $requestGet["name"] = "diego";
                }
                
                $requestParams = Request::setRequest($requestParams);         //Hacemos que request contenga las variables anteriores con los parámetros para usarlas en los controllers.
        
        
                $classAndFunction = explode(".", $definitiveRoute);
        
                $namespaceClass = "Controllers\\" . $classAndFunction[0];
        
                $class = new $namespaceClass;
                $function = $classAndFunction[1];
            }else{
                $error = new Status(404, "Not found", "No se pudo encontrar el recurso solicitado");
                return $error->redirectToErrorView();
            }
        }else{
            $error = new Status(404, "Not found", "No se pudo encontrar el recurso solicitado");
            return $error->redirectToErrorView();
        }
    }else{
        $error = new Status(404, "Not found", "No se pudo encontrar el recurso solicitado");
        return $error->redirectToErrorView();
    }
    
}


//Comprobamos los middlewares para saber si podemos acceder a la ruta especificada con nuestro usuario.
$middlewares = Middlewares::$middlewares;

if (isset($_SESSION['token'])) {
    try{
        $dataUser = Auth::GetData($_SESSION['token']);
    }catch(ExpiredException $e){
        session_destroy();
        header("location: /login");
    }


    if (isset($middlewares[$uri]) && !in_array($dataUser->role, $middlewares[$uri]['role'])) {
        $error = new Status(403, "Forbidden", "No posees los permisos requeridos para acceder a este apartado");
        return $error->redirectToErrorView();
    }
}else{
    if (isset($middlewares[$uri])) {
        $error = new Status(401, "Unauthorized", "Necesitas estar logueado para acceder a este apartado");
        return $error->redirectToErrorView();
    }
}

if (!isset($requestParams)) {
    $request = new Request();
}else{
    $request = $requestParams;
}

$class->$function($request);
