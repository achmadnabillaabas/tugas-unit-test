<?php
// File: test_name.php
require_once "Validator.php";

// Test Case 1: Nama valid (nama lengkap Anda)
try {
    $result = validateName("Achmad Nabilla");
    echo "PASS: Nama 'Achmad Nabilla' diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama 'Ahmad Nabilla' tidak diterima. Error: " . $e->getMessage() . "<br>";
}

// Test Case 2: Nama tidak valid (mengandung angka)
try {
    $result = validateName("Achmad445566");
    echo "PASS: Nama 'Achmad123' diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama 'Achmad445566' tidak diterima. Error: " . $e->getMessage() . "<br>";
}

// Test Case 3: Nama kosong
try {
    $result = validateName("");
    echo "PASS: Nama kosong diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama kosong tidak diterima. Error: " . $e->getMessage() . "<br>";
}
