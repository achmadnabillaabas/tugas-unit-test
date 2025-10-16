<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Include konfigurasi database
include("config.php");

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Cek apakah ada parameter ID (untuk edit data)
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // Query untuk mengambil data berdasarkan ID
            $query = "SELECT * FROM tb_pengurus WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            // Kolom id bertipe VARCHAR, gunakan parameter string
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                echo json_encode($data);
            } else {
                echo json_encode(array('error' => 'Data tidak ditemukan'));
            }
        } else {
            // Query untuk mengambil semua data
            $query = "SELECT * FROM tb_pengurus ORDER BY id ASC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                echo json_encode($data);
            } else {
                echo json_encode(array('error' => 'Tidak ada data'));
            }
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO tb_pengurus (nama, jabatan, alamat, no_telp) VALUES 
                ('{$data['nama']}', '{$data['jabatan']}', '{$data['alamat']}', '{$data['no_telp']}')";
        if(mysqli_query($conn, $sql)) {
            echo json_encode(array("message" => "Data berhasil ditambahkan"));
        } else {
            echo json_encode(array("error" => "Error: " . mysqli_error($conn)));
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $sql = "UPDATE tb_pengurus SET 
                nama = '{$data['nama']}',
                jabatan = '{$data['jabatan']}',
                alamat = '{$data['alamat']}',
                no_telp = '{$data['no_telp']}'
                WHERE id = {$data['id']}";
        if(mysqli_query($conn, $sql)) {
            echo json_encode(array("message" => "Data berhasil diupdate"));
        } else {
            echo json_encode(array("error" => "Error: " . mysqli_error($conn)));
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $sql = "DELETE FROM tb_pengurus WHERE id = $id";
        if(mysqli_query($conn, $sql)) {
            echo json_encode(array("message" => "Data berhasil dihapus"));
        } else {
            echo json_encode(array("error" => "Error: " . mysqli_error($conn)));
        }
        break;
}

// Tutup koneksi
mysqli_close($conn);
?>