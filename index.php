<?php
$data = <<<'EOD'
    X, -9\\\10\100\-5\\\0\\\\, A
    Y, \\13\\1\, B
    Z, \\\5\\\-3\\2\\\800, C
EOD;

$lines = array_filter(array_map('trim', explode("\n", $data)));

$numbers = [];

foreach ($lines as $line) {
    [$firstPart, $secondPart, $thirdPart] = array_map('trim', explode(',', $line));
    $valueParts = array_filter(array_map('trim', explode('\\', $secondPart)), 'strlen');

    foreach ($valueParts as $valuePart) {
        $numbers[] = [$firstPart, $valuePart, $thirdPart];
    }
}

usort($numbers, function ($a, $b) {
    return $a[1] <=> $b[1];
});

$counts = [];

foreach ($numbers as $item) {
    $key = $item[0] . ', ' . $item[2];
    $counts[$key] = isset($counts[$key]) ? $counts[$key] + 1 : 1;
    echo implode(', ', $item) . ', ' . $counts[$key] . "\n";
}
