<?php

$input = file_get_contents('input.txt');


function calculateWinner($draw, $markedCard, $gameArray)

{

    $cardSum = 0;

    foreach ($gameArray[$markedCard][0] as $row) {

        $cardSum += array_sum($row);
    }

    return $cardSum;
}

$input = trim($input);

$input = str_replace("\r\n", " ", $input);

$input = preg_replace("!\s+!", " ", $input);

$inputArray = explode(" ", $input);

$drawString = $inputArray[0];

$drawArray = explode(",", $drawString);

$inputArray = array_slice($inputArray, 1);

$cardsArray = array_chunk($inputArray, 25);

$rowArray = array();

$colArray = array();

$gameArray = array();

$winnerArray = array();

$bingo = false;

$cardNum = 0;

foreach ($cardsArray as $card) {

    $rowArray = array_chunk($card, 5);

    $colArray[0][0] = $card[0];

    $colArray[0][1] = $card[5];

    $colArray[0][2] = $card[10];

    $colArray[0][3] = $card[15];

    $colArray[0][4] = $card[20];

    $colArray[1][0] = $card[1];

    $colArray[1][1] = $card[6];

    $colArray[1][2] = $card[11];

    $colArray[1][3] = $card[16];

    $colArray[1][4] = $card[21];

    $colArray[2][0] = $card[2];

    $colArray[2][1] = $card[7];

    $colArray[2][2] = $card[12];

    $colArray[2][3] = $card[17];

    $colArray[2][4] = $card[22];

    $colArray[3][0] = $card[03];

    $colArray[3][1] = $card[8];

    $colArray[3][2] = $card[13];

    $colArray[3][3] = $card[18];

    $colArray[3][4] = $card[23];

    $colArray[4][0] = $card[4];

    $colArray[4][1] = $card[9];

    $colArray[4][2] = $card[14];

    $colArray[4][3] = $card[19];

    $colArray[4][4] = $card[24];

    $gameArray[$cardNum][0] = $rowArray;

    $gameArray[$cardNum][1] = $colArray;

    $cardNum++;
}

foreach ($drawArray as $draw) {

    $cardNum = 0;

    if (!$bingo) {

        foreach ($gameArray as $card) {

            $winner = false;

            $winner = array_search($cardNum, $winnerArray);

            if ($winner === false) {

                $rowNum = 0;

                $colNum = 0;

                foreach ($card[0] as $row) {

                    $found = array_search($draw, $row);

                    if ($found !== false) {

                        $cellsFound = count($gameArray[$cardNum][0][$rowNum]);

                        unset($gameArray[$cardNum][0][$rowNum][$found]);

                        $cellsLeft = count($gameArray[$cardNum][0][$rowNum]);

                        if (!$cellsLeft) {

                            $bingo = true; // used for part 1

                            echo "Bingo!<br>Winning card: $cardNum<br>";

                            echo "Sum: " . calculateWinner($draw, $cardNum, $gameArray) . "<br>";

                            echo "Draw: " . $draw . "<br>";

                            array_push($winnerArray, $cardNum);
                        }
                    }

                    $rowNum++;
                }

                foreach ($card[1] as $col) {

                    $found = array_search($draw, $col);

                    if ($found !== false) {

                        $cellsFound = count($gameArray[$cardNum][1][$colNum]);

                        unset($gameArray[$cardNum][1][$colNum][$found]);

                        $cellsLeft = count($gameArray[$cardNum][1][$colNum]);

                        if (!$cellsLeft) {

                            $bingo = true; // used for part 1

                            echo "Bingo!<br>Winning card: $cardNum<br>";

                            echo "Sum: " . calculateWinner($draw, $cardNum, $gameArray) . "<br>";

                            echo "Draw: " . $draw . "<br>";

                            array_push($winnerArray, $cardNum);
                        }
                    }

                    $colNum++;
                }
            }

            $cardNum++;
        }
    }
}
