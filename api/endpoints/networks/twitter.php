<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$results['seeurl'] = 'https://twitter.com/'.$domain;
$http_status = httpStatus($results['seeurl']);

if($http_status == 404) {
   $results['resultbinary'] = '1';
   $results['resulttext'] = 'Username Available';   
} elseif ($http_status == 200) {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'Username Taken'; 
   $results['resultdetails'] = array(
       'followers' => '',
       'created' => '',
       'lastactive' => '',
       'website' => ''
    );
} else {
   $results['resultbinary'] = 'E';
   $results['resulttext'] = 'Error';
}