<?php
error_reporting(-1);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$results['seeurl'] = 'http://apps.charitycommission.gov.uk/Showcharity/RegisterOfCharities/registerhomepage.aspx';
$post = array(
    'ctl00$ctl00$txtSearchTerm' => 'BRITISH HEART FOUNDATION'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://opencharities.org/charities/term/british+heart');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://mozzbiz.co.uk');
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));
$step2=curl_exec($ch);
curl_close($ch);
echo '<h1>step2</h1>';
echo $step2;

die();
$result = strpos($step2, 'The company name is not currently registered.');

if($result !== false) {
   $results['resultbinary'] = '1';
   $results['resulttext'] = 'Company name Available';  
    
} else {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'Company name not available'; 
   $results['resultdetails'] = array();
}
