<?php


function getMaxAndMin (int $digit) {

    $lenghOfDigits = strlen($digit);

    $chunkOfDigits = str_split($digit);

    $sumOfChunks = array_sum($chunkOfDigits);

    $result = [];

    for ($i=$lenghOfDigits-1; $i <= $lenghOfDigits; $i++) { 

        $myLimit[] = 1 . str_repeat('0' , $i);
    }

    if ($lenghOfDigits == 1)
        $myLimit = [0,10]; 

    for ($i=$myLimit[0]; $i < $myLimit[1]; $i++) { 

        $chunks = str_split($i);
  
        $sum = array_sum($chunks);

        if ($sum == $sumOfChunks) 
            $result[] = $i;  
    }

    return [max($result) , min($result)];
}

