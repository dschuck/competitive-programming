<?php 
ini_set('memory_limit', '1024M');

// Grab file
//$input = file_get_contents('example-input.txt');
$input = file_get_contents('input.txt');

/* -------------------------------------------------------------------------- */
/*                             Prepare Input File                             */
/* -------------------------------------------------------------------------- */

// trim whitespace from beginning and end of input string
$input = trim($input);
//echo $input;
// replaces all new lines with one whitespace (\r\n seems windows specific)
$input = str_replace("\r\n", " ", $input);
//echo $input;
// replaces every occurence of one or more whitespaces with one whitespace
$input = preg_replace("!\s+!", " ", $input);
//echo $input;
// turn input string into an array, divide on whitespace
$fishArray = explode(",", $input);

/* -------------------------------------------------------------------------- */

// For Part1, a brute force method worked. Did not know, if we needed fish ages for every fish in this part.
// Now we know, we only need to parse the amount of fish on a given day. So we try to keep it more memory-sane with part 2.

// Create an Array that counts the amount of fishes at all ages
$fishAgesArray = array();  

// fill it with 0s on all ages first, to initialize
for ($i = 0; $i < 9; $i++) {
    $fishAgesArray[$i] = 0;
}
// go through the input and get the value of each fish (meaning the age) then add to the corresponding key of $fishAgesArray
foreach ($fishArray as $id => $fish) {
    $fishAgesArray[intval($fish)]++;
}

// so, now we go through each day, decrease the age of fishes, spawn new ones, etc
for ($day = 1; $day <= 256; $day++) {
    // this one saves the amount of fish that are 0 in the beginning of each day
    $rememberSetToSix = $fishAgesArray[0];
    // now set all fish one number lower
    for ($i = 1; $i < 9; $i++) {
        $fishAgesArray[$i-1] += $fishAgesArray[$i];
        $fishAgesArray[$i] = 0;
    }
    $fishAgesArray[8] = $rememberSetToSix;
    $fishAgesArray[0] -= $rememberSetToSix;
    $fishAgesArray[6] += $rememberSetToSix;
}
$answer = array_sum($fishAgesArray);

// Grab answer file and write final value
$output = 'part2-answer.txt';
file_put_contents($output, $answer);
