<?php 
    class Router {

        /**
        * (string) Given url
        */
        private static $url;

        /**
        * (array) Array of known routes
        */
        private static $routes = array();

        /**
        * (array) Array of named route
        */
        private static $namedRoute = array();

        /**
        * Initialise the class with the requested url
        * @param (string) url : requested url
        */
        public static function init($url){
            self::$url = $url;
        }

        /**
        * Declare a route using get request method
        * @param (string) path : Path to the route
        * @param (closure | string) callable : Function to be called as callback
        * @param (string) name : Name of the route
        * @return (Route) The created route
        */
        public static function get($path, $callable, $name = null){
            return self::add($path, $callable, $name, 'GET');
        }

        /**
        * Declare a route using post request method
        * @param (string) path : Path to the route
        * @param (closure | string) callable : Function to be called as callback
        * @param (string) name : Name of the route
        * @return (Route) The created route
        */
        public static function post($path, $callable, $name = null){
            return self::add($path, $callable, $name, 'POST');
        }

        /**
        * Declare a route using put request method
        * @param (string) path : Path to the route
        * @param (closure | string) callable : Function to be called as callback
        * @param (string) name : Name of the route
        * @return (Route) The created route
        */
        public static function put($path, $callable, $name = null){
            return self::add($path, $callable, $name, 'PUT');
        }

        /**
        * Declare a route using delete request method
        * @param (string) path : Path to the route
        * @param (closure | string) callable : Function to be called as callback
        * @param (string) name : Name of the route
        * @return (Route) The created route
        */
        public static function delete($path, $callable, $name = null){
            return self::add($path, $callable, $name, 'DELETE');
        }

        /**
        * Declare a route using specified request method
        * @param (string) path : Path to the route
        * @param (closure | string) callable : Function to be called as callback
        * @param (string) name : Name of the route
        * @param (string) method : Specified request method
        * @return (Route) The created route
        */
        public static function add($path, $callable, $name, $method){
            $route = new Route($path, $callable);
            self::$routes[$method][] = $route;

            if(is_string($callable) && $name === null)
                $name = $callable;

            if($name)
                self::$namedRoute[$name] = $route;

            return $route;
        }

        /**
        * Try to apply the url to known routes with specified request method
        * @return (closure) Route callback function if known 
        */
        public static function run(){

            if(!isset(self::$routes[$_SERVER['REQUEST_METHOD']]))
                throw new RouterException("Request method does not exist");

            foreach (self::$routes[$_SERVER['REQUEST_METHOD']] as $route){
                if($route->match(self::$url)){
                    if($route->execMiddlewares())
                        return $route->call();
                    return;
                }
            }

            throw new RouterException("No matching route");
        }

        /**
        * Try to apply the url to known routes with specified request method
        * @param (string) name : Route name
        * @param  (array) params : Route params
        * @return (string) Url corresponding to the given name filled with given params
        */
        public static function url($name, $params = array()){
            if(!isset(self::$namedRoute[$name]))
                throw new RouterException("No route matches " . $name);

            return self::$namedRoute[$name]->getUrl($params);
        }
    }
?>