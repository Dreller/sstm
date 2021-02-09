<?php  
header("Content-type: image/png");
$imh = 35;
$imw = 35;
$im = @imagecreatetruecolor($imh, $imw);

# Initiate Colors
$colors = Array();

# Function to add colors in the Color table
function addColor($hexBack, $hexFont){
    list($br, $bg, $bb) = sscanf($hexBack, "#%02x%02x%02x");
    list($fr, $fg, $fb) = sscanf($hexFont, "#%02x%02x%02x");

    $new = Array(
        "br" => $br,
        "bg" => $bg,
        "bb" => $bb,
        "fr" => $fr,
        "fg" => $fg,
        "fb" => $fb
    );
    return $new;
}

# Add color sets to the table
$new = addColor("#016936", "#FFFFFF"); # Green/White
$colors[] = $new;

$new = addColor("#FFD700", "#000000"); # Yellow/Black
$colors[] = $new;

$new = addColor("#0E6EB8", "#FFFFFF"); # Blue/White
$colors[] = $new;

# Random color
$max = count($colors)-1;
$token = rand(0, $max);

# Extract colors
$back_r = $colors[$token]["br"];
$back_g = $colors[$token]["bg"];
$back_b = $colors[$token]["bb"];
$font_r = $colors[$token]["fr"];
$font_g = $colors[$token]["fg"];
$font_b = $colors[$token]["fb"];

# Set colors
$back = imagecolorallocate($im, $back_r, $back_g, $back_b);
imagefill($im, 0, 0, $back);

$text = imagecolorallocate($im, $font_r, $font_g, $font_b);

# Text
$size = 5;
$literal = "A";
$font = "arial.ttf";
$len = strlen($literal);
$top = ($imh/2)-(imagefontheight($size)*$len)*(1/(1+$len));
$lft = ($imw/2)-(imagefontwidth($size)*$len)*(1/(1+$len));
imagestring($im, $size, $lft, $top, $literal, $text);

# Output image
imagepng($im);

# Cleanup
#imagedestroy($im);
