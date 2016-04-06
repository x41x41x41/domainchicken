<?php
error_reporting(-1);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$results['seeurl'] = 'http://wck2.companieshouse.gov.uk//companysearch';
$post = array(
    'cname' => $_GET['domain'],
    'cnumb' => '',
    'stype' => 'S',
    'live' => 'on',
    'cosearch.x' => '18',
    'cosearch.y' => '12',
    'cosearch' => '1'
);

$cookiefilename = 'cookie'.time().md5(rand(0,9999)).'.txt';
fopen("/var/www/vhosts/server.mozzbiz.co.uk/mozzbiz/domain/api/endpoints/other/tmp/".$cookiefilename, "w");
$cookiejar = '/var/www/vhosts/server.mozzbiz.co.uk/mozzbiz/domain/api/endpoints/other/tmp/'.$cookiefilename;
/*echo $cookiejar.'<br/><br/><br/>';

if (! file_exists($cookiejar) || ! is_writable($cookiejar)){
    if (! file_exists($cookiejar) ) {
        echo 'Cookie file missing';
    }
    if (! is_writable($cookiejar) ) {
        echo 'Cookie file not writable.';
    }
    
    exit;
} else {
    echo 'Cookie file is writable and exists';
}*/


$ch = curl_init('http://wck2.companieshouse.gov.uk/');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://mozzbiz.co.uk');
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
$step1 = curl_exec($ch);
curl_close($ch);

//echo '<h1>step0</h1>';
//echo $step1;

$ch = curl_init('http://wck2.companieshouse.gov.uk//wcframe?name=accessCompanyInfo');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://mozzbiz.co.uk');
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
$step1 = curl_exec($ch);
curl_close($ch);

//echo '<h1>step1</h1>';
//echo $step1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://wck2.companieshouse.gov.uk//companysearch');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, 'http://mozzbiz.co.uk');
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));
$step2=curl_exec($ch);
curl_close($ch);
//echo '<h1>step2</h1>';
//echo $step2;

$result = strpos($step2, 'The company name is not currently registered.');

if($result !== false) {
   $results['resultbinary'] = '1';
   $results['resulttext'] = 'Company name Available';  
    
} else {
   $results['resultbinary'] = '-1';
   $results['resulttext'] = 'Company name not available'; 
   $results['resultdetails'] = array();
}

unlink($cookiejar);