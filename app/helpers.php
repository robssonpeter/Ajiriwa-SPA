<?php

function getFileName($fileName, $attachment)
{
    $fileNameExtension = $attachment->getClientOriginalExtension();
    $newName = $fileName.'-'.time();

    return $newName.'.'.$fileNameExtension;
}

function greet(){
    $hour = \Carbon\Carbon::now()->format('H');
    if ($hour < 12) {
        return 'Good morning';
    }
    if ($hour < 17) {
        return 'Good afternoon';
    }
    return 'Good evening';
}

function makeSlug($text, $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function unitSeparator($product_id, $quantity){

    $output_array = [];
    $unitRelations = [
        'carton' => 20,
        'nusu-carton' => 10,
        'robo-carton' => 5,
        'pc' => 1,
    ];
    // define a remainder and assign the initial value as the quantity
    $remainder = $quantity;
    $keys = array_keys($unitRelations);
    $x = 0;
    while($remainder > 0){
        $current_unit = $unitRelations[$keys[$x]];
        // excute the below if only the remainder is greater or equal to the current unit
        if($remainder >= $current_unit){
            $current_qty = (int) ($remainder/$current_unit);
            $remainder = $remainder % $current_unit;
            // if the current qty is greater than 0 add it to the output array
            if($current_qty){
                $output_array[] = $current_qty." ".$keys[$x];
            }
        }
        $x++;
    }
    return implode(' ', $output_array);
}
