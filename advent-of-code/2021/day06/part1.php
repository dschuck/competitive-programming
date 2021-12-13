<?php 
// Grab file
$input = file_get_contents('example-input.txt');
//$input = file_get_contents('input.txt');

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

// loop through the cardsArray and create arrays of arrays for each card, with row and column

for ($i = 0; $i < 80; $i++) {
    for ($fishNum = 0; $fishNum < count($fishArray); $fishNum++) {
        if ($fishArray[$fishNum] == 0) {
            array_push($fishArray, "9");
            $fishArray[$fishNum] = "6";
        } else {
            $fishArray[$fishNum] = $fishArray[$fishNum] -1;
        }   
    }    
}
$answer = count($fishArray);

// Grab answer file and write final value
$output = 'part1-answer.txt';
file_put_contents($output, $answer);
