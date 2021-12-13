<?php 
// Grab file
//$input = file_get_contents('example-input.txt');
$input = file_get_contents('input.txt');

// calculate sum of left numbers in card (need to understand code below)
function calcAnswer($draw, $winningCard, $bingoArray) {
    $cardSum = 0;
    foreach ($bingoArray[$winningCard][0] as $row) {
        $cardSum += array_sum($row);
    }
    $answer = $cardSum * $draw;
    return $answer;
}

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
$inputArray = explode(" ", $input);
//print_r($inputArray);


/* -------------------------------------------------------------------------- */
/*                           the numbers to be drawn                          */
/* -------------------------------------------------------------------------- */

// turn first array field into a string
$drawString = $inputArray[0];
//echo $drawString;
// turn string back into an array, but divide by ","
$drawArray = explode(",", $drawString);
//print_r($drawArray);

/* -------------------------------------------------------------------------- */
/*                                  the cards                                 */
/* -------------------------------------------------------------------------- */

// remove first field (the draw numbers) from array
$inputArray = array_slice($inputArray, 1);

// create an array, each field equals one card
$cardsArray = array_chunk($inputArray, 25);
//print_r($cardsArray);

// prepare more arrays to be filled (row, column, complete game and winner)
$rowArray = array();
$colArray = array();
$bingoArray = array();
$winnerArray = array();

/* -------------------------------------------------------------------------- */


// more variables to indicate winner and card number
$bingo = false;
$cardNum = 0;

// loop through the cardsArray and create arrays of arrays for each card, with row and column
foreach ($cardsArray as $card) {
    // turn each cards row into a row array
    $rowArray = array_chunk($card, 5);
    
    for ($i = 0; $i < 5; $i++) {
        $p = $i;
        for ($o = 0; $o < 5; $o++) {
            $colArray[$i][$o] = $card[$p];
            $p += 5;            
        }
    }
    $bingoArray[$cardNum][0] = $rowArray;
    $bingoArray[$cardNum][1] = $colArray;
    $cardNum++;
}

// loop through the drawn numbers
foreach ($drawArray as $draw) {
    $cardNum = 0;
    // as long has no card has bingo yet
    
        // loop through the cards
        foreach ($bingoArray as $card) {
            $winner = false;
            // search for card number in winner array
            $winner = array_search($cardNum, $winnerArray);

            // as long as there is no winning card yet, do the following
            if ($winner === false) {
                $rowNum = 0;
                $colNum = 0;
                // search through the first index of each card - row
                foreach ($card[0] as $row) {
                    // search for drawn number in this row, $found is the key where the found number sits
                    $found = array_search($draw, $row);
                    // if the drawn number is found do the following
                    if ($found !== false) {
                        // search this row for entries
                        $cellsFound = count($bingoArray[$cardNum][0][$rowNum]);
                        // unset the found number from the row
                        unset($bingoArray[$cardNum][0][$rowNum][$found]);
                        // count how many numbers are left in this row
                        $cellsLeft = count($bingoArray[$cardNum][0][$rowNum]);

                        // when there are no numbers left == win!
                        if (!$cellsLeft) {
                            // execute function from above to calculate the sum of left over numbers in card
                            $answer = calcAnswer($draw, $cardNum, $bingoArray);
                            array_push($winnerArray, $cardNum);
                        }
                    }
                    $rowNum++;
                }

                //search through the second index of each card - column
                foreach ($card[1] as $col) {
                    // search for drawn number in this column, $found is the key where the found number sits
                    $found = array_search($draw, $col);
                    // if the drawn number is found do the following
                    if ($found !== false) {
                        // search this column for entries
                        $cellsFound = count($bingoArray[$cardNum][1][$colNum]);
                        // unset the found number from the column
                        unset($bingoArray[$cardNum][1][$colNum][$found]);
                        // count how many numbers are left in this column
                        $cellsLeft = count($bingoArray[$cardNum][1][$colNum]);

                        // when there are no numbers left == win!
                        if (!$cellsLeft) {
                            // execute function from above to calculate the sum of left over numbers in card
                            $answer = calcAnswer($draw, $cardNum, $bingoArray);
                            array_push($winnerArray, $cardNum);
                        }
                    }
                    $colNum++;
                }
            }
            $cardNum++;
        }
    
}


// Grab answer file and write final value
$output = 'part2-answer.txt';
file_put_contents($output, $answer);
?>