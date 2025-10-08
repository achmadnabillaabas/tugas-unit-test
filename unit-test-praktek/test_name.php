<?php
// File: test_name.php
require_once "Validator.php";

// Test Case 1: Nama valid (nama lengkap Anda)
try {
    $result = validateName("Azka Wildan");
    echo "PASS: Nama 'Azka Wildan' diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama 'Azka Wildan' tidak diterima. Error: " . $e->getMessage() . "<br>";
}

// Test Case 2: Nama tidak valid (mengandung angka)
try {
    $result = validateName("Azka123");
    echo "PASS: Nama 'Azka123' diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama 'Azka123' tidak diterima. Error: " . $e->getMessage() . "<br>";
}

// Test Case 3: Nama kosong
try {
    $result = validateName("");
    echo "PASS: Nama kosong diterima<br>";
} catch (Exception $e) {
    echo "FAIL: Nama kosong tidak diterima. Error: " . $e->getMessage() . "<br>";
}
