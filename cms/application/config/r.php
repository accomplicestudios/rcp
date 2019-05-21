<?php 

if (strstr($_SERVER['SERVER_NAME'], 'rebecca')) {

    $config['MAIN_SITE_URL'] = 'https://rebeccacamacho.com/';
}
else {

    $config['MAIN_SITE_URL'] = 'http://r.com/';
}

$config['SITE_TITLE'] = 'RebeccaCamachoPresents | Content Management System';