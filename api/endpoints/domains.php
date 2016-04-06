<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Get the framenumber to check
$domain = trim($_GET['domain']);

$results = Array(
    'success' => '1',
    'error_number' => '',
    'error_message' => '',
    'url' => curPageURL(),
    'domain' => $domain,
    'resultbinary' => '',
    'resulttext' => ''
);

$results['seeurl'] = 'http://'.$domain;

if ( gethostbyname($domain) != $domain ) {
    $results['resultbinary'] = '-1';
    $results['resulttext'] = 'DNS found, domain unavailable';
} else {
    $service = new HelgeSverre\DomainAvailability\AvailabilityService(true);
    $available = $service->isAvailable($domain);
    if($available) {
        $results['resultbinary'] = '1';
        $results['resulttext'] = 'No DNS found, domain likely available';
    } else {
        $results['resultbinary'] = '-1';
        $results['resulttext'] = 'DNS found, domain unavailable';
    }
}