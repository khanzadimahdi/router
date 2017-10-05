![dependencies none](https://img.shields.io/badge/Dependencies-none-brightgreen.svg)
![PHP 5.6+](https://img.shields.io/badge/PHP-5.6+-green.svg)
[![WebSite tarhche.com](https://img.shields.io/badge/WebSite-Tarhche.com-yellow.svg)](http://tarhche.com)
[![GPLv3 license](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://github.com/khanzadimahdi/router/blob/master/LICENSE)

# router
a simple php Router made by 

## how to use
we have 3 important files here
<ol>
    <li>htaccess: redirects all requests to home.php</li>
    <li>home.php : you can manage all requests in this file</li>
    <li>ROUTE.php : this is ROUTE lib you need to manage requests in home.php</li>
</ol>
<p>we add ROUTE.php in home.php and then we use it to manage requests:<p>

```php
<?php 
    //add router class
    include_once 'ROUTE.php';
?>
```

<p>we have 4 functions in order to manage requests:</p>
<ul>
    <li><b>get:</b> manage GET (method) requests.</li>
    <li><b>post:</b> manage POST (method) requests for example forms and etc.</li>
    <li><b>go:</b> manage both GET and POST requests</li>
    <li><b>addHookFunction:</b>doing some actions before any routing</li>
</ul>
<p>here we have some examples:</p>

```php

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
?>
```
you can match URLs using REGEX.<br>
here is an example of addHookFuncion :
```php
    //using add addHookFunction
    ROUTE::addHookFunction(function($data){
        print_r($data);//show data
    });
```
you can use $data variable in addHookFunction to access requests.<br>
<b>note:</b> addHookFuncion must be written before any routes an home.php to work correctly.<br>
<b>Iranian people can [visit here](www.tarhche.ir/?p=2466) for persian tutorials about this router.<b>
## License
This project is licensed under the GPL-3.0 License - see the [LICENSE.md](LICENSE.md) file for details
##help
help me to develop this router.