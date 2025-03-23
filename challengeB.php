<?php

/**
 * Classifies a given string object into categories based on its content.
 *
 * The function trims the input string and checks for the following categories:
 * 1. Alphabetical: If the trimmed string consists only of alphabetic characters.
 * 2. Alphanumeric with spaces: If the trimmed string differs from the original and
 *    consists of alphanumeric characters.
 * 3. Integer: If the original string is composed entirely of digits.
 * 4. Real number: If the string is in the format of digits followed by a decimal point
 *    and more digits.
 * 5. Alphanumeric without spaces: If the trimmed string consists of alphanumeric characters.
 *
 * If none of the above conditions are met, the string is classified as 'unknown'.
 *
 * @param string $object The input string to be classified.
 * @return array An array containing the trimmed version of the object and its classification type.
 */

function classifyObject(string $object):array {
    $trimmed = trim($object);

    // 1. Check if the trimmed string is purely alphabetical
    if (ctype_alpha($trimmed)) {
        return [$trimmed, 'alphabetical'];
    }

    // 2. Alphanumeric check (with spaces)
    if ($trimmed !== $object && ctype_alnum($trimmed)) {
        return [$trimmed, 'alphanumeric'];
    }

    // 3. Check integer (no spaces)
    if (ctype_digit($object)) {
        return [$object, 'integer'];
    }

    // 4. Check real number (format: digits.digits)
    if (preg_match('/^\d+\.\d+$/', $object)) {
        return [$object, 'real'];
    }

    // 5. Final check for alphanumeric without spaces (e.g., "abc123")
    if (ctype_alnum($trimmed)) {
        return [$trimmed, 'alphanumeric'];
    }

    return [$object, 'unknown'];
}

// Read command-line arguments
$inputFile = $argv[1] ?? 'output.txt';
$content = file_get_contents($inputFile);
$objects = $content ? explode(',', $content) : [];

foreach ($objects as $object) {
    [$cleanedObject, $type] = classifyObject($object);
    echo "$cleanedObject: $type\n";
}
?>