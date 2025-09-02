<?php
// Konfigurasi: path root yang berisi folder-folder dengan aggregated.json
$baseDir = __DIR__ . '/as'; 

// File output
$outputFile = __DIR__ . '/asn_list.txt';

// Cari semua file aggregated.json di bawah baseDir
$files = glob($baseDir . '/*/aggregated.json');

if (!$files) {
    die("Tidak ada file aggregated.json ditemukan.\n");
}

$result = [];

foreach ($files as $file) {
    $json = file_get_contents($file);
    if ($json === false) continue;

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) continue;

    // Ambil asn dan description
    $asn = $data['asn'] ?? null;
    $desc = $data['description'] ?? null;

    if ($asn && $desc) {
        $result[] = $asn . " - " . $desc;
    }
}

// Simpan ke file text
file_put_contents($outputFile, implode(PHP_EOL, $result));

echo "Data berhasil digabung. Hasil disimpan di: $outputFile\n";
