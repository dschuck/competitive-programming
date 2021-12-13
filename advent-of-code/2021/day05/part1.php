<?php 
// Grab file
//$input = file_get_contents('example-input.txt');
$input = file_get_contents('input.txt');

/*
// calculate sum of left numbers in card (need to understand code below)
function calcAnswer($draw, $winningCard, $bingoArray) {
    $cardSum = 0;
    foreach ($bingoArray[$winningCard][0] as $row) {
        $cardSum += array_sum($row);
    }
    $answer = $cardSum * $draw;
    return $answer;
}
*/
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


// remove arrow symbols in string
$input = str_replace(" -> ", " ", $input);
$input = str_replace(",", " ", $input);
//echo $input;

// turn input string into an array, divide on whitespace
$inputArray = explode(" ", $input);
//print_r($inputArray);



// create an array, each field equals one line
$linesArray = array_chunk($inputArray, 4);
//print_r($linesArray);

// prepare more arrays to be filled (row, column, complete game and winner)
$xArray = array();
$yArray = array();
$hydroArray = array();
$mapArray = array();

/* -------------------------------------------------------------------------- */


// more variables to indicate winner and card number
$lineNum = 0;
$maxX = 0;
$maxY = 0;

// loop through the cardsArray and create arrays of arrays for each card, with row and column
foreach ($linesArray as $line) {
    // turn each line row into an x and y array
    // only consider horizontal and vertical lines
    // x1 = x2 or y1 = y2
    if ($line[0] == $line[2] || $line[1] == $line[3]) {
        $xArray[0] = $line[0];
        $xArray[1] = $line[2];
        $yArray[0] = $line[1];
        $yArray[1] = $line[3];

        $hydroArray[$lineNum][0] = $xArray;
        $hydroArray[$lineNum][1] = $yArray;

        if (max($xArray) > $maxX) {
            $maxX = max($xArray);
        }
        if (max($yArray) > $maxY) {
            $maxY = max($yArray);
        }
    }
    $lineNum++;
}

$hydroArray = array_values($hydroArray);

for ($i = 0; $i <= $maxX; $i++) {
    $mapArray[$i] = array_fill(0, $maxY+1, 0);
}
//print_r($hydroArray);
//print_r($mapArray);

foreach ($hydroArray as $line) {
    
    // wenn x-werte gleich sind
    if ($line[0][0] == $line[0][1]) {
        //echo "X-Wert: " . $line[0][0] . "<br>";
        //echo "Von " . $line[1][0] . " bis " . $line[1][1] . "<br>";
        foreach (range($line[1][0], $line[1][1]) as $number) {
            //echo $number;
            $mapArray[$line[0][0]][$number]++;
        }
    // wenn y-werte gleich sind
    } else {
        //echo "Y-Wert: " . $line[1][0] . "<br>";
        //echo "Von " . $line[0][0] . " bis " . $line[0][1] . "<br>";
        foreach (range($line[0][0], $line[0][1]) as $number) {
            //echo $number;
            $mapArray[$number][$line[1][0]]++;
        }
    }
}

$answer = 0;
foreach($mapArray as $current) {
    foreach($current as $search) {
        if ($search >= 2) {
            $answer++;
        }
    }
    }

// Grab answer file and write final value
$output = 'part1-answer.txt';
file_put_contents($output, $answer);
