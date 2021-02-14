<?php 

function extr($what, $from, $default = ''){
    $wip = $default;
    if( isset($from[$what]) ){
        $wip = $from[$what];
    }
    return $wip;
}

/**
 * buildInput - Construct the input
 */
function buildInput($in){
    $type = extr('type', $in, 'text');
    $f = "build" . ucwords($type);

    # If the builder don't exists
    if( !function_exists($f) ){
        return "(SSTM) Error: Builder for type '$type' not found!";
    }

    return call_user_func($f, $in);
}

function buildText($in){
    $type = extr('type', $in, 'text');
    $name = extr('name', $in);
    $value = extr('value', $in);
    
    $wip = "<input id='$name' type='$type' name='$name' value='$value'>";
    return $wip;
}

function buildSelect($in){
    global $db;
    $table = extr('table', $in);
    $default = extr('default', $in);
    $sqlPrefix = '';

    switch($table){
        case 'version':
            $sqlPrefix  = 'ver';
            break;
        case 'environment':
            $sqlPrefix = 'env';
            break;
        case 'package':
            $sqlPrefix = 'pack';
            break;
        case 'application':
            $sqlPrefix = 'app';
            break;
    }

    $cols = Array($sqlPrefix.'ID', $sqlPrefix.'Name');
    $db->orderBy($sqlPrefix.'Name', 'asc');
    $items = $db->get($table, null, $cols);
    
    $options = '';
    foreach($items as $item){
        $selected = '';
        if( $item[$sqlPrefix.'ID']==$default ){
            $selected = ' selected';
        }
        $options .= "<option value='{$item[$sqlPrefix."ID"]}'>{$item[$sqlPrefix."Name"]}</option>";
    }

    $name = extr('name', $in);
    $wip = "<select id='$name' class='ui search dropdown' name='$name'>$options</select>";
    return $wip;
}

?>