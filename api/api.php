<?php

require_once('includes/config.php');

$check = $_GET['check'];

/* Using the *switch* construct to deal with different methods */
switch ($_GET['method']) {

    case 'social' :

        require_once('endpoints/socialmedia.php');

        break;

    case 'domain' :

        require_once('endpoints/domains.php');

        break;
    
    case 'other' :

        require_once('endpoints/other.php');

        break;
}

/*OUTPUTS*/
/* Using the *switch* again, this time to deal with output formats */
//@header ("content-type: text/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("content-type: text/json; charset=utf-8");

if(isset($_GET['callback']) && is_valid_callback($_GET['callback'])) {
        $callback = $_GET['callback'];
        /* Printing the JSON Object */
        echo $callback.'('.json_encode($results).')';
} else {
        echo json_encode($results);
}