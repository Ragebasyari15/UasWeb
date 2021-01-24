<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "uasweb";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if(@$_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE obat set
											 	nama = '$_POST[tnama]',
												khasiat = '$_POST[tkhasiat]',
											 	stock = '$_POST[tstock]'
											 WHERE id_obat = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='Obat.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='Obat.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO obat (nama, khasiat, stock)
										  VALUES ( 
										  		 '$_POST[tnama]', 
										  		 '$_POST[tkhasiat]', 
										  		 '$_POST[tstock]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='Obat.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='Obat.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if(@$_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
			
				$vnama = $data['nama'];
				$vkhasiat = $data['khasiat'];
				$vstock = $data['stock'];
			}
		}
		else if (@$_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='Obat.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<title>Data Obat</title>
</head>
<body style="background-color: #e74c3c">
<div class="container">

	<h1 class="text-center">DATABASE OBAT</h1>
	<h2 class="text-center">Rumah Sakit</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Obat
	  </div>
	  <div class="card-body">
	    <form method="post" action="">

	    	<div class="form-group">
	    		<label>Nama Obat</label>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Obat!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Khasiat</label>
	    		<textarea class="form-control" name="tkhasiat"  placeholder="Input khasiat disini!"><?=@$vkhasiat?></textarea>
	    	</div>
	    		    	<div class="form-group">
	    		<label>Stock</label>
	    		<textarea class="form-control" name="tstock"  placeholder="Input sisa stock yang tersisa!"><?=@$vstock?></textarea>
	    	</div>
	    	

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Obat
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nama</th>
	    		<th>Khasiat</th>
	    		<th>Stock</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from obat order by id_obat desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nama']?></td>
	    		<td><?=$data['khasiat']?></td>
	    		<td><?=$data['stock']?></td>
	    		<td>
	    			<a href="Obat.php?hal=edit&id=<?=$data['id_obat']?>" class="btn btn-warning"> Edit </a>
	    			<a href="Obat.php?hal=hapus&id=<?=$data['id_obat']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->
	<a href="index.php" class="btn btn-warning">Data Dokter</a>
		<a href="Pasien.php" class="btn btn-warning">Data Pasien</a>
			<a href="Obat.php" class="btn btn-warning">Data Obat</a>
</div>
 <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>