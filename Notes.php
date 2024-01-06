<?php

/*
 * Notes
 * http://cn.fdh.pw
 *
 * (c) Farlando Diengdoh
 * http://fdiengdoh.com
 */

 class Notes
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
}

?>
