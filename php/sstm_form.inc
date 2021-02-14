<?php 

/**
 * buildInput - Construct the input
 */
function buildInput($in){

# Set Arrays to divide builders
    $basics = Array('text');
    

# Construct BASIC inputs
    $wip = "";
    if( in_array($in['type'], $basics, TRUE) ){
        $wip = "<input type='{$in['type']}' id='{$in['name']}' name='{$in['name']}' value='{$in['value']}'>";
    }

# Send the constructed input
return $wip;
}

?>