<?php

    require_once './vendor/autoload.php';

    //Init RNJesus
    function make_seed()
    {
      list($usec, $sec) = explode(' ', microtime());
      return (float) $sec + ((float) $usec * 100000);
    }
    mt_srand(make_seed());

    $scenario = new \Doomsday\Scenario();

    echo '<html><head>';
    echo '<link rel="stylesheet" media="all" href="style.css">';
    echo '</head><body>';
    echo $scenario->run();
    echo '</body></html>';


    // echo '<hr>';
    // var_dump($result);
    // echo '<hr>';
    // echo '<pre>';
    // print_r($history);

 ?>