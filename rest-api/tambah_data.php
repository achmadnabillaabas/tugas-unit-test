<?php
    // Include konfigurasi database
    include("config.php");
    
    // Set header untuk JSON
    header('Content-Type: application/json');
    
    // Cek method POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari POST
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $gaji = isset($_POST['gaji']) ? $_POST['gaji'] : null;
        
        // Validasi data
        if (empty($id) || empty($nama) || empty($alamat) || empty($gender) || empty($gaji)) {
            echo json_encode(array('response' => 400, 'pesan' => 'Semua field harus diisi'));
            exit;
        }
        
        // Cek apakah ID sudah ada
        $check_query = "SELECT id FROM pengurus WHERE id = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "i", $id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($check_result) > 0) {
            echo json_encode(array('response' => 409, 'pesan' => 'ID sudah ada'));
            exit;
        }
        
        // Insert data
        $query = "INSERT INTO pengurus (id, nama, alamat, gender, gaji) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isssi", $id, $nama, $alamat, $gender, $gaji);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(array('response' => 200, 'pesan' => 'Data berhasil Masuk'));
        } else {
            echo json_encode(array('response' => 500, 'pesan' => 'Gagal menambahkan data'));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(array('response' => 405, 'pesan' => 'Method tidak diizinkan'));
    }
    
    // Tutup koneksi
    mysqli_close($conn);
?>