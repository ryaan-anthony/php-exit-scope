<?php

$filename = dirname(__FILE__).'/vendor/autoload.php';

file_exists($filename) or exit('Run `composer dump-autoload` to generate autoload files.'.PHP_EOL);

include $filename;

$app = new App(function(Scope $scope){

    echo "Start".PHP_EOL;

    $scope->onExit(function(){
        echo "Exit".PHP_EOL;
    });

    $scope->onSuccess(function(){
        echo "Success".PHP_EOL;
    });

    $scope->onFail(function(){
        echo "Fail".PHP_EOL;
    });

    // PHP Notice:  Undefined variable
    $foo = $bar;

    // PHP Fatal error, Call to a member function bar() on a non-object
    $foo->bar();

    echo "End".PHP_EOL;

});
$app->run();
