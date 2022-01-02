<?php
/*
DATABASE PHP
Imesh Nimsitha
ICS4UR-A Mr. Brown
*/

// FUNCTION: Log a message to the console
function clog($log_message){
    // Convert the array to an encoded string
    $log_msg = json_encode($log_message);
    // Log the encoded string using JS
    echo "<script>console.log($log_msg);</script>";
}

// FUNCTION: Quicksort an array of integers
function quicksort(&$arr, $l, $r){
    // Base case: the array must have multiple elements --> prevents stack overflow
    if(count($arr) <= 1){
        return;
    }
    // Temporary variables for left and right index
    $left = $l;
    $right = $r;
    // Finding the pivot element by using the middle index
    $middle = floor(($left + $right) / 2);
    $pivot = $arr[$middle];

    // While the left and right index are not at the pivot point
    while($left <= $right){
        // Left index element is on the correct side of the pivot (less than pivot)
        while($arr[$left] < $pivot){
            $left++;
        }
        // Right index element is on the correct side of the pivot (greater than pivot)
        while($arr[$right] > $pivot){
            $right--;
        }
        // At this point, an element from the left index and an element from the right index are both out of place
        // This means they must be swapped so they satisfy the pivot condition
        if($left <= $right) {
            // Swapping the elements
            $temp = $arr[$left];
            $arr[$left] = $arr[$right];
            $arr[$right] = $temp;
            // Keep the recursion going
            $left++;
            $right--;
        }
    }
    // If there are still elements to be sorted on the left side of the pivot
    if($l < $right){
        quicksort($arr, $l, $right);
    }
    // If there are still elements to be sorted on the right side of the pivot
    if($r > $left){
        quicksort($arr, $left, $r);
    }
}
