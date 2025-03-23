<?php
/**
 * Classifies a given object string into one of several categories.
 *
 * This function trims the input string and checks its format to classify it 
 * as 'alphabetical', 'alphanumeric', 'integer', 'real', or 'unknown'.
 *
 * Classification is performed in the following order:
 * 1. If the trimmed string consists only of alphabetic characters, it is classified as 'alphabetical'.
 * 2. If the string contains spaces and the trimmed string is alphanumeric, it is classified as 'alphanumeric'.
 * 3. If the string is a digit-only string with no spaces, it is classified as 'integer'.
 * 4. If the string matches the pattern of a real number (digits.digits), it is classified as 'real'.
 * 5. Finally, if the trimmed string is alphanumeric without spaces, it is classified as 'alphanumeric'.
 * 
 * If none of the above conditions are met, the string is classified as 'unknown'.
 *
 * @param string $object The input object string to classify.
 * @return array An array containing the cleaned object string and its classification type.
 */

function classifyObject($object) {
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