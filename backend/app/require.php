<?php
    //require libraries from folder libraries
    require_once 'libraries/Core.php';
    require_once 'libraries/Controller.php';
    require_once 'config/config.php';

    //Instantiate core class
    $init = new Core();
    $init->dispatch();
