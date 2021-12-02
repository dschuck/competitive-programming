<?php 

// Grab file and turn into integer array
$input = array_map('intval', file('input.txt'));

// Initialize counter
$i_count = 0;

// check each three-measurement-window, when lower than next three-measurement-window, increment counter by 1
for ($i = 0; $i < count($input) - 1; $i++) {
    if ($i + 3 <= count($input) - 1) {
        if ($input[$i] + $input[$i + 1] + $input[$i + 2] < $input[$i + 1] + $input[$i + 2] + $input[$i + 3]) {
            $i_count++;
        }
    }
    
}

// Grab answer file and write number of increasement
$output = 'part2-answer.txt';
file_put_contents($output, $i_count);
?>