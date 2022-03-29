<?php
    if(!defined('DS')){
        define('DS', DIRECTORY_SEPARATOR);
    }

    //domain protocol
    define('PROTOCOL', stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://');

    //public directory
    define('ROOT_PATH', PROTOCOL . $_SERVER['SERVER_NAME'] . DS . "public" . DS);

    //app directory
    define('APP_PATH', realpath(dirname(__FILE__)) . DS . '..' . DS);

    //views directory
    define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);

    //helpers directory
    define('HELPERS_PATH', APP_PATH . 'helpers' . DS);

    //template directory
    define('TPL_PATH', HELPERS_PATH . 'template' . DS);



    
    //global website info
    define('COMPANY__NAME', 'Coderdojo Helsingborg');
    define('COMPANY__LOGO', 'http://preview.quicklytorsby.se/images/svg/logo.svg');