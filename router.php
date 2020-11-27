<?php

/**
 * This is an example of a front controller for a flat file PHP site. Using a
 * Static list provides security against URL injection by default. See README.md
 * for more examples.
 * https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/appengine/php72/front-controller
 */
# [START gae_simple_front_controller]
// switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
//     case '/':
//         require 'index.php';
//         break;
//     case '/avion_index':
//         require 'avion_index.php';
//         break;
//     case '/avion_create':
//         require 'avion_create.php';
//         break;
//     case '/avion_edit':
//         require 'avion_edit.php';
//         break;
//     case '/avion_eliminar':
//         require 'avion_eliminar.php';
//         break;
//     default:
//         http_response_code(404);
//         exit('Not Found');
// }
# [END gae_simple_front_controller]






#----------------------------------------------------------------------
# otra forma de redireccionar-------------------------------------------
if(@parse_url($_SERVER['REQUEST_URI'])['path'] == "/" || @parse_url($_SERVER['REQUEST_URI'])['path'] == "/index.php")
{
    require 'index.php';
    return;
}

// en la siguiente lista no poner el archivo router
$routes = [    
    'avion_index',
    'avion_create',
    'avion_edit',
    'avion_eliminar',
    'aeropuerto_index',
    'cliente_create',
    'cliente_edit',
    'cliente_eliminar',
    'cliente_index',
    'vueloprog_create',
    'vueloprog_edit',
    'vueloprog_eliminar',
    'vueloprog_index',
];

$regex = '/\/(' . join($routes, '|') . ')\.php/'; #para los enlaces que terminan en .php
$regexNoPHP = '/\/(' . join($routes, '|') . ')/'; #para los enlaces que no terminan en .php

#para los enlaces que terminan en .php
if (preg_match($regex, $_SERVER['REQUEST_URI'], $matches)) {
    $file_path = __DIR__ . $matches[0];    // esto es un:    /file.php
    if (file_exists($file_path)) {
        require($file_path);
        return;
    }
}

#para los elaces que no terminan en .php
else{
    if (preg_match($regexNoPHP, $_SERVER['REQUEST_URI'], $matches)) {
        $file_path = __DIR__ . $matches[0] . '.php';
        if (file_exists($file_path)) {
            require($file_path);
            return;
        }
    }
    http_response_code(404);
    exit('Not Found');
}