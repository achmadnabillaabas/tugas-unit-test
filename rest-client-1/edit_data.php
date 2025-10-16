<?php
	//memasukan file config
	include("config.php");

	//cek apakah ada parameter ID
	if(isset($_GET['id']) && !empty($_GET['id'])) {
		//ambil parameter ID dar URL
		$id=$_GET['id'];

		//url untuk lihat data berdasarkan id yang dipilih
		$url="http://localhost/PPL-anindyap/rest-api/tampil_data.php?id=".$id;

		//menyimpan hasil dalam variabel
		$data=http_request_get($url);

		//konversi data json ke array
		$hasil=json_decode($data,true);
		
		//cek apakah data berhasil diambil
		if($hasil && isset($hasil['id'])) {
			$row = $hasil; //jika API mengembalikan object tunggal
			$data_found = true;
		} elseif($hasil && is_array($hasil) && count($hasil) > 0) {
			$row = $hasil[0]; //jika API mengembalikan array
			$data_found = true;
		} else {
			$data_found = false;
			$error_message = "Data tidak ditemukan";
		}
	} else {
		$data_found = false;
		$error_message = "ID tidak ditemukan dalam URL";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data dengan cURL</title>
</head>
<body>
	<h1>Ubah Data Pengurus</h1>
	
	<p><a href="tampil_data.php">Kembali ke Data</a></p>
	
	<?php if($data_found): ?>
	<form method="POST" action="ubah_data.php">
		<table>
			<tr>
				<td>ID</td>
				<td><input type="text" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" readonly></td>
			</tr>
			<tr>
				<td>NAMA</td>
				<td><input type="text" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>"></td>
			</tr>
			<tr>
				<td>ALAMAT</td>
				<td><textarea name="alamat"><?php echo htmlspecialchars($row['alamat']); ?></textarea></td>
			</tr>
			<tr>
				<td>GENDER</td>
				<td>
				<select name="gender">
					<option value="L" <?php echo ($row['gender'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
					<option value="P" <?php echo ($row['gender'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
				</select>
				</td>
			</tr>
			<tr>
				<td>GAJI</td>
				<td><input type="number" name="gaji" value="<?php echo htmlspecialchars($row['gaji']); ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" name="ubah">UBAH</button>
					<button type="reset">BATAL</button>
				</td>
			</tr>
		</table>
	</form>
	<?php else: ?>
	<p style="color: red;"><?php echo $error_message; ?></p>
	<?php endif; ?>

</body>
</html>