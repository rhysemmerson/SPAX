<?php

namespace spaxTest;

define('SPAX_Test_DIR', __DIR__);
define('SPAX_BASE_SRC_DIR', __DIR__ . '/../src');

//spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register(function($class) {
            if (strpos($class, 'spaxTest\\') === 0)
                require_once SPAX_Test_DIR . '/' . $class . '.php';
            elseif (strpos($class, 'Spax\\') === 0)
                require_once SPAX_BASE_SRC_DIR . '/' . $class . '.php';
        });