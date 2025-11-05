<?php
// Function to check if a number is prime
function isPrime($num) {
    if ($num < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

// Generate and print all prime numbers below 100
echo "Prime numbers below 100 are:<br>";
for ($n = 2; $n < 100; $n++) {
    if (isPrime($n)) {
        echo $n . " ";
    }
}
?>
