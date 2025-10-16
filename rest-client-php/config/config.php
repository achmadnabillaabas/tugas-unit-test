<?php
function http_request_get($url) {
    // Persiapkan curl
    $ch = curl_init(); 

    // Set URL tujuan API
    curl_setopt($ch, CURLOPT_URL, $url);

    // Supaya hasilnya dikembalikan sebagai string, bukan langsung ditampilkan
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // Tambahkan user agent agar tidak diblok oleh server
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'); 

    // Tambahkan agar tidak error SSL di localhost
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Eksekusi curl
    $output = curl_exec($ch);

    // Jika ada error pada koneksi, tampilkan pesan error
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }

    // Tutup koneksi curl
    curl_close($ch);

    // Kembalikan hasil curl (string JSON)
    return $output;
}
?>