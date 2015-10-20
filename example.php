<?php

$filename = dirname(__FILE__).'/vendor/autoload.php';

file_exists($filename) ? require $filename : exit('Run composer install'.PHP_EOL);

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

    $foo = $bar;

    $foo->bar();

    echo "End".PHP_EOL;

});
$app->run();
