<?php 
// Grab file
$input = file('input.txt');

// Initialize directional values
$horizontal = 0;
$depth = 0;
$aim = 0;

// check each line of input, filter by direction and increment by found value
for ($i = 0; $i < count($input); $i++) {
   
    $explode = explode(" ", $input[$i]);
    $direction = $explode[0];
    $value = $explode[1];

    if ($direction == "forward") {
        $horizontal += $value;
        $depth += ($aim * $value);
    } elseif ($direction == "down") {
        $aim += $value;
    } else {
        $aim -= $value;
    }
}

// multiply horizontal and depth value to get final answer
$answer = $horizontal * $depth;

// Grab answer file and write final value
$output = 'part2-answer.txt';
file_put_contents($output, $answer);
?>