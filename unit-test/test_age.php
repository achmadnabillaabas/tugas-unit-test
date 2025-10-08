<?php
// File: test_age.php
require_once "Validator.php";

// Test Case 1: umur valid
try {
    $result = validateAge(25);
    echo "PASS: Umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL: Umur 25 tidak diterima. Error: " . $e->getMessage() . "\n";
}

// test case 2
try {
    $result = validateAge('tiga puluh');
    echo "PASS: Umur tiga puluh diterima\n";
} catch (Exception $e) {
    echo "FAIL: Umur tiga puluh tidak diterima. Error: " . $e->getMessage() . "\n";
}