<?php

namespace iafm\LevenshteinSimilarity;

class LevenshteinSimilarity
{
    public static function calculate($str1, $str2){
        $distance = self::calculateLevenshteinDistance($str1, $str2);
        $max_length = max(strlen($str1), strlen($str2));

        if ($max_length === 0) {
            return 100.0; // Both strings are empty, so they are considered 100% similar.
        }

        $similarity_percentage = (1 - ($distance / $max_length)) * 100.0;

        return $similarity_percentage;
    }

    private static function calculateLevenshteinDistance($str1, $str2)
    {
        $len1 = strlen($str1);
        $len2 = strlen($str2);

        $dp = array();

        for ($i = 0; $i <= $len1; $i++) {
            $dp[$i][0] = $i;
        }

        for ($j = 0; $j <= $len2; $j++) {
            $dp[0][$j] = $j;
        }

        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($str1[$i - 1] != $str2[$j - 1]) ? 1 : 0;
                $dp[$i][$j] = min(
                    $dp[$i - 1][$j] + 1,        // Deletion
                    $dp[$i][$j - 1] + 1,        // Insertion
                    $dp[$i - 1][$j - 1] + $cost // Substitution
                );
            }
        }

        return $dp[$len1][$len2];
    }
}
