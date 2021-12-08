<?php 
// Grab file and turn into integer array
$input = file('input.txt');

// Initialize variables
$one_array = [];
$zero_array = [];
$gamma = "";
$epsilon = "";

// check each line of input, trim binary number and turn into digit-sized arrays
// then check each digit of each line and increment one_array or zero_array on the same position
for ($i = 0; $i < count($input); $i++) {
    $array = str_split(rtrim($input[$i]));
    for ($o = 0; $o <= count($array) - 1; $o++) {
        if ($array[$o] == 1) {
            $one_array[$o]++;
        } else {
            $zero_array[$o]++;
        }
    }
}

//go through both arrays and compare if 1 or 0 is bigger, write gamma and epsilon binary
for ($o = 0; $o <= count($array) - 1; $o++) {
    if ($one_array[$o] > $zero_array[$o]) {
        $gamma .= "1";
        $epsilon .= "0";
    } else {
        $gamma .= "0";
        $epsilon .= "1";
    }
}

//turn binaries into decimal and multiply them
$answer = bindec($gamma) * bindec($epsilon);

// Grab answer file and write the answer
$output = 'part1-answer.txt';
file_put_contents($output, $answer);
?>