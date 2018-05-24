<?php
    //add router class
    include_once 'ROUTE.php';

    //using add addHookFunction
    ROUTE::addHookFunction(function($data){
        print_r($data);//show data
    });

    //example 1 : using html or php
    ROUTE::get('/login',function(){
        //your page
        echo '<h1>my login page</h1>';
    });

   //example 2 : include files
    ROUTE::go('get','/register',function(){
        include 'pages/register.php';
    });

    //example 3 : for both get and post methods
    ROUTE::go('get|post','/logout',function(){
        echo '<h1>logout page</h1>';
    });

    //example 4 : using regex
    ROUTE::go('get','/show/{id:^\d*$}',function($id){
        echo '<h1>your numeric id is : '.$id.'</h1>';
    });
    ROUTE::post('/show/{id:^\d*$}',function($id){
        echo '<h1>your numeric id is : '.$id.'</h1>';
    });

    //example 5 : change to asp page
    ROUTE::get('/login.aspx',function(){
        //your page
        echo '<h1>my login page</h1>';
    });
    
    //show 404 page if router cant match the request:
    if(!ROUTE::$founded){ 
        //here you return 404 view page (404.php for example) 
        echo '404 Page';
    }
        