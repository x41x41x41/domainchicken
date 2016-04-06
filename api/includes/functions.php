<?php
    
    function removeUnwantedChrs($frame) {
        return str_replace(array(':',' ','-','#','*'), '', $frame);
    }

    function is_valid_callback($subject)
    {
            $identifier_syntax
              = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';

            $reserved_words = array('break', 'do', 'instanceof', 'typeof', 'case',
              'else', 'new', 'var', 'catch', 'finally', 'return', 'void', 'continue', 
              'for', 'switch', 'while', 'debugger', 'function', 'this', 'with', 
              'default', 'if', 'throw', 'delete', 'in', 'try', 'class', 'enum', 
              'extends', 'super', 'const', 'export', 'import', 'implements', 'let', 
              'private', 'public', 'yield', 'interface', 'package', 'protected', 
              'static', 'null', 'true', 'false');

            return preg_match($identifier_syntax, $subject)
                    && ! in_array(mb_strtolower($subject, 'UTF-8'), $reserved_words);
    }

    function curPageURL() {
             $pageURL = $_SERVER["REQUEST_URI"];
             return $pageURL;
    }
    
    // must set $url first. Duh...


    function httpStatus($url) {
        global $http;
        global $siteurl;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $http.$siteurl);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $http_status;
    }
    
    function generalAccess($url) {
        global $http;
        global $siteurl;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $http.$siteurl);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        $result=curl_exec($ch);
        return $result;
    }

    function postAccess($url,$post) {
        global $http;
        global $siteurl;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $http.$siteurl);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        $result=curl_exec ($ch);
        if (FALSE === $result) {
                return "Error: ".curl_error($ch)." Number:".curl_errno($ch);
        }
        return $result;
    }

    function preparePostFields($array) {
      $params = array();
      foreach ($array as $key => $value) {
        $params[] = urlencode($key) . '=' . urlencode($value);
      }
      return implode('&', $params);
    }
