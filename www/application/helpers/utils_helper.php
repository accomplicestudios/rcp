<?php 

function get_flex_attributes($image) {
    
    $flex_grow = ''; 
    $flex_basis = ''; 
    $padding_bottom = ''; 

    $file = $image->choices['default'];
    $path = 'images/exhibitions/sahar-khoury-holding/profile/' . $file; 
    
    $attributes = getimagesize($path); 
    $width = $attributes[0] ?? 0; 
    $height = $attributes[1] ?? 0; 

    $flex_grow = ($width / $height) * 100; 
    $flex_basis = $width * 240 / $height; 
    $padding_bottom = ($height / $width) * 100.0; 

    $flex_basis .= 'px'; 
    $padding_bottom .= 'px';

    return [$flex_grow, $flex_basis, $padding_bottom];
}
function dump($var) {

    echo '<pre>'; 
    var_dump($var); 
    exit;
}

function fractions($text) {

    $reps = [
        " 1/4 " => " ¼ ", 
        " 1/2 " => " ½ ", 
        " 3/4 " => " ¾ " 
    ]; 

    return str_replace(array_keys($reps), $reps, $text); 
}

function _r($data, $base_url, $info = NULL, $seq_no = NULL) {

    static $seq = 1; 

    $breakpoints = [320, 768, 1024, 1440]; 

    $ret = []; 
    $ret[] = '<picture>'; 

    foreach($breakpoints as $i => $b) {

        $image = isset($data[$b]) 
            ? $data[$b]
            : $data['default']; 

        $url = _cdn($base_url . '/' . $image); 

        $media = '(min-width: ' . $b . 'px)'; 

        if (isset($breakpoints[$i+1])) {

            $media = '(max-width: ' . ($breakpoints[$i+1] - 1) . 'px)'; 
        }

        $ret[] = '<source srcset="' . $url . '" media="' . $media  .'" >';
    }

    $attr_info = !empty($info) ? ' data-info="' . htmlentities(fractions($info), ENT_COMPAT | ENT_HTML5) . '" ' : '';  
    $attr_seq_no  = 'data-seq-no="' . $seq++ . '" ' ; 

    $ret[] = '<img src ="'  . _cdn('/' . $base_url . '/' . $data['default']) . '" alt="" ' . $attr_info . $attr_seq_no . ' />';
    $ret[] = '</picture>'; 

    return implode(PHP_EOL, $ret);
}

function _cdn($uri) {

    $uri = ltrim($uri, '/'); 
    $uri = str_replace('//', '/', $uri); 
    // $uri = str_replace('?v1', '', $uri);

    return get_instance()->config->item('cdn_url') . $uri;
}

function _cache_buster($uri) {

    return $uri . '?' . config_item('cache_buster');
}

function show_about_text($str, $glue = ', ') {

    $tmp = explode('</p>', $str);
    $final = []; 

    foreach($tmp as $k => $v) {

        $tokens = explode(',', $v); 

        if (count($tokens) > 1) {

            $tokens[1] = '<span>' . trim($tokens[1]) . '</span>';
            $final[] = implode($glue, $tokens);
        }
        else {

            $final[] = $v; 
        }
    }
    
    $final = implode('</p>', $final);
    return $final;
}

function get_up_cls($items) {

    $ret = NULL; 

    switch(count($items)) {

        case 1: $ret = 1; break;
        case 2: $ret = 2; break;
        default: $ret = 4; break; 
    }

    return $ret; 
}