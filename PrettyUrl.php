<?php

/*
 * Pretty Url
 * http://cn.fdh.pw
 *
 * (c) Farlando Diengdoh
 * http://fdiengdoh.com
 *
 */
namespace Fdiengdoh\Purl;

class PrettyUrl
{
    //The array of safe pages
    # as of now this will be as variable
    # to be implemented using database
    var $safePages = [];
    var $homePage = [];
    var $errorPage = [];

    function getPageByUrl(){
        /* 
        * This function gets the url and look through the safe pages
        */
        $pages = $this->safePages;
        $request  = rtrim($_SERVER['REQUEST_URI'],'/');
        $_crumbs = explode ("/",$request);
        $request  = ltrim($request, '/');
        if(isset($_crumbs[1]) && (!empty($_crumbs[1]))) {
           $pages = $this->safePages[$_crumbs[0]]['topic'];
        }
        $home = $this->homePage;
        $data = [
            'file' => $home['file'],
            'crumb' => $home['url'],
            'title' => $home['title'],
            'active' => $home['url'],
            'paging' => [
                'prev' => [ 'href' => '/', 'class' => 'btn btn-secondary float-left'],
                'next' => [ 'href' => '/01', 'class' => 'btn btn-secondary float-right'],
            ],
            'url' => $_active_nav,
        ];
        //If request is not root, look for allowed pages
        if( isset($request) && (!empty($request))){
            $info = $this->searchByUrl('/'.$request, $this->safePages);
            if(isset($info[2])){
                $got = $this->safePages[$info[0]][$info[1]][$info[2]];
                $_parent = [ 
                    'title' => $this->safePages[$info[0]]['title'],
                    'sub-title' => $this->safePages[$info[0]]['sub-title'],
                    'url' => $this->safePages[$info[0]]['url']
                ];
            }else{
                $got = $this->safePages[$info[0]];
                $_parent = null;
            }
            $_file_name = $got['file'];
            $_title = $got['title'];
            $_active_nav = $got['url'];
            $_desc = $got['desc'];
    
            $data = [
                'parent' => $_parent,
                'file' => $_file_name,
                'crumb' => $_crumbs,
                'title' => $_title,
                'active' => $_active_nav,
                'key' => $info[0],
                'desc' => $_desc,
                'url' => $_active_nav,
            ];
        }
        return $data;
    }
    
    function searchByUrl($search_value, $array, $id_path = array()){
        if(is_array($array) && count($array) > 0) { 
        
            foreach($array as $key => $value) { 
      
                $temp_path = $id_path; 
                // Adding current key to search path 
                array_push($temp_path, $key); 
                // Check if this value is an array 
                // with atleast one element 
                if(is_array($value) && count($value) > 0) { 
                    $res_path = $this->searchByUrl($search_value, $value, $temp_path); 
                    if ($res_path != null) { 
                        return $res_path; 
                    } 
                } 
                else if($value == $search_value) { 
                    return $temp_path; 
                }
            } 
        } 
          
        return null; 
    }

    function generateCrumbs($data){
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
