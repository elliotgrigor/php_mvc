<?php

class Router
{
    private const REGEX_NAMED_ROUTE = '/:[a-z-_]*/i';

    private static $request;
    private static $response;

    private static $validRoutes = [
        'GET'  => array(),
        'POST' => array(),
    ];

    public static function __constructStatic() {
        self::$request = new Request();
        self::$response = new Response();
    }

    public static function get($route, $callback, $route_name = null) {
        // save as [route] => callback
        self::$validRoutes['GET'][$route] = $callback;

        if (!is_null($route_name) && !empty($route_name)) {
            // associate route name to uri
            $GLOBALS['routes'][$route_name] = $route;
        }
    }

    public static function notFound() {
        http_response_code(404);
        return self::$response->view('errors/404');
    }

    public static function requestHandler() {
        if (self::$request->method === 'GET') {
            self::GETHandler();
        }
        else if (self::$request->method === 'POST') {
            // self::POSTHandler();
        }
    }

    private static function GETHandler() {
        // look for requested route in GET array, return its callback if found
        foreach (self::$validRoutes['GET'] as $route => $callback) {
            // route must match but not contain a named route
            if (self::$request->route === $route
                && !preg_match(self::REGEX_NAMED_ROUTE, $route))
            {
                // call associated controller method
                return call_user_func_array(
                    $callback,
                    [self::$request, self::$response]
                );
            }
            // if a dynamic route (named route)
            else if (preg_match(self::REGEX_NAMED_ROUTE, $route)) {
                // create regular expression of dynamic route
                $regex_route = self::generateRegexString($route);

                // if the requested route matches regex pattern
                if (preg_match($regex_route, self::$request->route)) {
                    // split declared route, e.g. '/product/:id' -> ['product', ':id']
                    $declared_route_array = explode('/', $route);
                    $declared_route_array = array_splice($declared_route_array, 1);

                    // split requested route, e.g. '/product/3' -> ['product', '3']
                    $request_route_array = explode('/', self::$request->route);
                    $request_route_array = array_splice($request_route_array, 1);

                    // associate named routes to values, e.g. [':id' => 3]
                    $named_route_values = self::mapNamedRoutesToValues(
                        $declared_route_array,
                        $request_route_array
                    );

                    // save the request arguments
                    self::$request->args = $named_route_values;
                    
                    // call associated controller method
                    return call_user_func_array(
                        $callback,
                        [self::$request, self::$response]
                    );
                }
            }
        }
        
        // not found in GET array, 404
        return self::notFound();
    }

    private static function mapNamedRoutesToValues(
        $declared_route_array,
        $request_route_array
    ) {
        $regex_typed_named_route = '/:[a-z-_]*\|int/i';
        $regex_type_declaration  = '/\|[a-z]*/i';

        $named_routes = array();

        foreach ($declared_route_array as $i => $key) {
            // skip static routes
            if ($key !== $request_route_array[$i]) {
                // if the named route has a type declaration e.g. ':id|int'
                if (preg_match($regex_typed_named_route, $key)) {
                    // save type declaration -> '|int'
                    preg_match_all($regex_type_declaration, $key, $m);
                    $type_requirement = $m[0][0];

                    // remove type declaration e.g. ':id|int' -> ':id'
                    $key = preg_replace($regex_type_declaration, '', $key);
                }

                if ($type_requirement === '|int') {
                    if (is_numeric($request_route_array[$i])) {
                        // cast to integer if numeric string
                        $named_routes[$key] = (int) $request_route_array[$i];
                    } else {
                        $type_given = gettype($request_route_array[$i]);

                        throw new TypeError(
                            "Datatype requirement not met for named route $key.
                            Given $type_given, int required"
                        );
                    }
                } else {
                    $named_routes[$key] = $request_route_array[$i];
                }
            }
        }

        return $named_routes;
    }

    private static function generateRegexString($route) {
        $route_array = explode('/', $route);
        $route_array = array_splice($route_array, 1);

        // start of regex string
        $regex_route = '/\/';

        foreach ($route_array as $i => $route_name) {
            // if a named route
            if ($route_name[0] === ':') {
                $regex_route .= '[a-z0-9_-]*'; // dynamic route value lookup
            } else {
                $regex_route .= $route_name; // static route
            }

            // if the last route
            if ($i === array_key_last($route_array)) {
                $regex_route .= '$/i'; // finish the regex string
            } else {
                $regex_route .= '\/'; // append a slash
            }
        }

        return $regex_route;
    }
}

// creates request and response objects
Router::__constructStatic();