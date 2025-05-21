<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = (int) $_POST['index'];
    $scans = json_decode(file_get_contents('scans.json'), true);

    if (isset($scans[$index])) {
        unset($scans[$index]);
        $scans = array_values($scans); // Reindex
        file_put_contents('scans.json', json_encode($scans, JSON_PRETTY_PRINT));
    }
}

header('Location: dashboard.php');
exit;
