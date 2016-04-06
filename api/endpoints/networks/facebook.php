<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//https://graph.facebook.com/stolenbikesuk

$results['seeurl'] = 'https://www.facebook.com/'.$domain;
$return = json_decode(generalAccess('https://graph.facebook.com/'.$domain));

if($return->error->code == 803) {
   $results['resultbinary'] = '1';
   $results['resulttext'] = 'URL Available';   
} elseif ($return->error->code == 100) {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'URL Taken, Page Unpublished'; 
   $results['resultdetails'] = array(
       'likes' => '?',
       'talking' => '?',
       'website' => '?'
    );
} elseif($return->likes) {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'URL Taken, Page Published';
   $results['resultdetails'] = array(
       'likes' => $return->likes,
       'talking' => $return->talking_about_count,
       'website' => $return->website
    );
} else {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'URL Taken, Facebook User';
}

