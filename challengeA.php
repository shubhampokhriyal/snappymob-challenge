<?php
/**
 * Generates a random alphabetical string of a length between 1 and 20.
 *
 * The characters are shuffled and repeated, then a random substring of length
 * between 1 and 20 is taken.
 *
 * @return string
 */
function genAlphabetical() {
    $length = rand(1, 20);
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
}

/**
 * Generates a random real number with an integer part and a decimal part.
 *
 * The integer part is a random number between 0 and 1,000,000. The decimal part
 * is a random five-digit number, padded with leading zeros if necessary to ensure
 * it is always five digits.
 *
 * @return string The generated real number in string format.
 */
function genRealNumber() {
    $integerPart = rand(0, 1000000);
    $decimalPart = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    return $integerPart . '.' . $decimalPart;
}

/**
 * Generates a random integer as a string.
 *
 * The generated integer is a random number between 0 and PHP_INT_MAX.
 *
 * @return string The generated integer in string format.
 */
function genInteger() {
    return (string)rand(0, PHP_INT_MAX);
}

function genAlphanumeric() {
    $leadingSpaces = str_repeat(' ', rand(0, 10));
    $trailingSpaces = str_repeat(' ', rand(0, 10));
    $coreLength = rand(1, 20);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $core = '';
    for ($i = 0; $i < $coreLength; $i++) {
        $core .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $leadingSpaces . $core . $trailingSpaces;
}

// generate the 10MB file
$targetSize = 10 * 1024 * 1024; // 10MB
$file = fopen('output.txt', 'w');
$bytesWritten = 0;
$firstEntry = true;

while ($bytesWritten < $targetSize) {
    $generators = ['genAlphabetical', 'genRealNumber', 'genInteger', 'genAlphanumeric'];
    $selectedGenerator = $generators[array_rand($generators)];
    $object = $selectedGenerator();

    $formattedObject = $firstEntry ? $object : ",$object";
    $bytesToWrite = strlen($formattedObject);

    if ($bytesWritten + $bytesToWrite > $targetSize) break;

    fwrite($file, $formattedObject);
    $bytesWritten += $bytesToWrite;
    $firstEntry = false;
}

fclose($file);
echo "created output.txt ($bytesWritten bytes)\n";
?>