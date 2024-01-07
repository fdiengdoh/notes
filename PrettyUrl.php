<?php

/*
 * Pretty Url
 * http://cn.fdh.pw
 *
 * (c) Farlando Diengdoh
 * http://fdiengdoh.com
 *
 */
namespace Farlando;

 class PrettyUrl
{
    //The array of safe pages
    var $safePages = [
        //Home Page
        'home' => [ 'url' => '/', 'file' => APP_PATH . '/home.php', 'title' => 'Home | Learn with FD'],
        //Chapter 1
        '01' => [ 'url' => '/01','file' => APP_PATH . '/01/page.md', 'title' => 'Basic Concepts' ],
        '01/concept-of-hybridisation-of-atomic-orbitals-and-its-application-on-simple-organic-molecules' => [ 'url' => '01']

        //'about/documentation' => [ 'url' => '/about/documentation', 'file' => 'documentation.php', 'title' => 'Documentation of OSIC' ],
    ];

    function getPageByUrl($url){
        /* 
        * Testing Application
        */
        #remove the directory path we don't want
        $request  = ltrim($url,'/');
        $_crumbs = explode ("/",$request);
        $request  = rtrim($request, '/');

        return $request;
    }   
    
    //Code to generate a url
    function generateUrl($string, $wordLimit = 0){ 
        $separator = '-'; 
         
        if($wordLimit != 0){ 
            $wordArr = explode(' ', $string); 
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit)); 
        } 
     
        $quoteSeparator = preg_quote($separator, '#'); 
     
        $trans = array( 
            '&.+?;'                 => '', 
            '[^\w\d _-]'            => '', 
            '\s+'                   => $separator, 
            '('.$quoteSeparator.')+'=> $separator 
        ); 
     
        $string = strip_tags($string); 
        foreach ($trans as $key => $val){ 
            $string = preg_replace('#'.$key.'#iu', $val, $string); 
        } 
     
        $string = strtolower($string . ".html"); 
     
        return trim(trim($string, $separator));
    }
}

?>
