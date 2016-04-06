<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Show list of available parameters
$domain = trim($_GET['domain']);
$network = trim($_GET['type']);

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

switch ($_GET['type']) {

    case 'chouse' :

        require_once('other/companieshouse.php');

        break;
    
    case 'charity' :

        require_once('other/charitycommision.php');

        break;

}