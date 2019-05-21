<?php 

$config['cdn_url'] = 'https://rcp-fd0a.kxcdn.com/'; 

if ($_SERVER['SERVER_NAME'] == 'r.com') {

    $config['cdn_url'] = '/'; 
}

$config['cache_buster'] = '1.0.0'; 
