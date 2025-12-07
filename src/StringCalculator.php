<?php

namespace App;

use Exception;

class StringCalculator
{
    public function add(string $numbersString): int
    {
         if ($numbersString === "") {
            return 0;
        }

       $delimiter = "/,|\n/";
        $numbersPart = $numbersString;

        if (str_starts_with($numbersString, "//")) {
             $parts = explode("\n", $numbersString, 2);
            
            $customDelimiter = substr($parts[0], 2);
            
            $delimiter = "/" . preg_quote($customDelimiter, '/') . "/";
            
            $numbersPart = $parts[1];
        }

        $numbers = preg_split($delimiter, $numbersPart);
        
         $numbers = array_filter($numbers, fn($n) => $n !== "");

        $sum = 0;
        $negatives = [];

        foreach ($numbers as $number) {
            $val = (int)$number;

            if ($val < 0) {
                $negatives[] = $val;
            }

            if ($val <= 1000) {
                $sum += $val;
            }
        }

        if (!empty($negatives)) {
            throw new Exception("Negatives not allowed: " . implode(", ", $negatives));
        }

        return $sum;
    }
}