<?php


if (!file_exists('scans.json')) {
    file_put_contents('scans.json', json_encode([]));
}

$scans = json_decode(file_get_contents('scans.json'), true);

$scan_entry = [
    'target' => $target,
    'timestamp' => date('Y-m-d H:i:s'),
    'vulnerabilities' => $vulnerabilities
];

$scans[] = $scan_entry;

file_put_contents('scans.json', json_encode($scans, JSON_PRETTY_PRINT));
?>
