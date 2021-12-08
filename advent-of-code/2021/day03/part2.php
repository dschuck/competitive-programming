<?php 
// check each line of input, trim binary number and turn into digit-sized arrays
// then check each digit of each line and increment one_array or zero_array on the same position
for ($count = 0; $count <= 1; $count++) {
    
    $input = file('input.txt');
    foreach ($input as $sKey => $sValue) {
        $input[$sKey] = rtrim($sValue);
    }

    for ($o = 0; $o < 12; $o++) {
        $one = 0;
        $zero = 0;

        if (count($input) == 1) {
            break;
        }
        
        for ($i = 0; $i < count($input); $i++) {
            //echo "Hallo";
            $array = str_split($input[$i]);
            
            if ($array[$o] == 1) {
                $one++;
            } elseif ($array[$o] == 0) {
                $zero++;
            }
        }
        
        $wc = str_repeat(".", $o);
        //echo $wc;

    if ($count == 0) {
        if ($one > $zero) {
            $input = preg_grep('/^'.$wc.'1.*/', $input);
            $input = array_values($input);
            //echo count($input) . "<br>";
        } elseif ($one < $zero) {
            $input = preg_grep('/^'.$wc.'0.*/', $input);
            $input = array_values($input);
        } else {
            $input = preg_grep('/^'.$wc.'1.*/', $input);
            $input = array_values($input);
        }
    } else {
        if ($one < $zero) {
            $input = preg_grep('/^'.$wc.'1.*/', $input);
            $input = array_values($input);
        } elseif ($one > $zero) {
            $input = preg_grep('/^'.$wc.'0.*/', $input);
            $input = array_values($input);
        } else {
            $input = preg_grep('/^'.$wc.'0.*/', $input);
            $input = array_values($input);
        }
    }
    
    }
    if ($count == 0) {
        $answer_oxy = bindec($input[0]);
    } else {
        $answer_c02 = bindec($input[0]);
    }

}


$answer = $answer_oxy * $answer_c02;

// Grab answer file and write the answer
$output = 'part2-answer.txt';
file_put_contents($output, $answer);
?>