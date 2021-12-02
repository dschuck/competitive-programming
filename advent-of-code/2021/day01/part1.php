<?php 
// Grab file and turn into integer array
$input = array_map('intval', file('input.txt'));

// Initialize counter
$i_count = 0;

// check each line of input, when lower than next line, increment counter by 1
for ($i = 0; $i < count($input) - 1; $i++) {
    if ($input[$i] < $input[$i + 1]) {
        $i_count++;
    }
}

// Grab answer file and write number of increasement
$output = 'part1-answer.txt';
file_put_contents($output, $i_count);
?>