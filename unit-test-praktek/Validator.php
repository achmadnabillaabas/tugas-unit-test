
<?php
// File: Validator.php

function validateAge($age) {
    if (!is_numeric($age)) {
        throw new InvalidArgumentException("Umur harus berupa angka");
    }
    if ($age < 0) {
        throw new InvalidArgumentException("Umur tidak boleh negatif");
    }
    return true;
}

// Fungsi baru: validateName()
// Menangani inputan nama mahasiswa
function validateName($name) {
    // Cek apakah kosong
    if (empty(trim($name))) {
        throw new InvalidArgumentException("Nama tidak boleh kosong");
    }

    // Cek apakah hanya huruf dan spasi
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        throw new InvalidArgumentException("Nama harus berupa huruf dan spasi saja");
    }

    return true;
}
