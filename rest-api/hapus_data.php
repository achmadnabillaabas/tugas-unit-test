<?php
    // Include konfigurasi database
    include("config.php");
    
    // Set header untuk JSON
    header('Content-Type: application/json');
    
    // Cek apakah ada parameter ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$id) {
        echo json_encode(array('response' => 400, 'pesan' => 'ID tidak boleh kosong'));
        exit;
    }
    
    // Cek apakah data ada
    $check_query = "SELECT id FROM pengurus WHERE id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) == 0) {
        echo json_encode(array('response' => 404, 'pesan' => 'Data tidak ditemukan'));
        exit;
    }
    
    // Hapus data
    $query = "DELETE FROM pengurus WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(array('response' => 200, 'pesan' => 'Data berhasil Dihapus'));
    } else {
        echo json_encode(array('response' => 500, 'pesan' => 'Gagal menghapus data'));
    }
    
    mysqli_stmt_close($stmt);
    
    // Tutup koneksi
    mysqli_close($conn);
?>