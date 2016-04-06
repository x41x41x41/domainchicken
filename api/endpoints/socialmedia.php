<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Show list of available parameters
$domain = trim($_GET['domain']);
$network = trim($_GET['network']);

$results = Array(
    'success' => '1',
    'error_number' => '',
    'error_message' => '',
    'url' => curPageURL(),
    'domain' => $domain,
    'network' => $network,
    'resultbinary' => '',
    'resulttext' => ''
);

switch ($_GET['network']) {

    case 'facebook' :

        require_once('networks/facebook.php');

        break;

    case 'twitter' :

        require_once('networks/twitter.php');

        break;
    
    case 'gplus' :

        require_once('networks/gplus.php');

        break;
    
    case 'instagram' :

        require_once('networks/instagram.php');
        
        break;
        
    case 'youtube' :

        require_once('networks/youtube.php');

        break;
}