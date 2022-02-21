<?php 
	session_start();

	// // initialize all variables for database
	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "sekolah";

	// initialize all variables for database
	$servername = "localhost";
	$username = "id17301791_aaa";
	$password = "3!d6qb_}dR)d+!LT";
	$dbname = "id17301791_sekolah";

	// define variables and set to empty values
	$nama = $no_pelajar = $nama_penjaga = $tel_penjaga = $alamat_rumah = "";
	$tarikh_pulang_bermalam = $tarikh_balik_asrama = "";

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET["ralat"])) {
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Maklumat yang anda berikan salah. Sila cuba lagi.</strong> 
			</div>
			
			<script>
				$(".alert").alert();
			</script>';
		}
	}
	else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nama = test_input($_POST["nama"]);
		$no_pelajar = test_input($_POST["no_pelajar"]);
		$nama_penjaga = test_input($_POST["nama_penjaga"]);
		$tel_penjaga = test_input($_POST["tel_penjaga"]);
		$tarikh_pulang_bermalam = test_input($_POST["tarikh_pulang_bermalam"]);
		$tarikh_balik_asrama = test_input($_POST["tarikh_balik_asrama"]);
		$alamat_rumah = test_input($_POST["alamat_rumah"]);

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}
		#echo "Connected successfully";

		$sql4 = "SELECT * FROM pelajar WHERE nama='$nama' AND no_pelajar='$no_pelajar'";
		$result = $conn->query($sql4);

		if ($result->num_rows > 0) {
			// Inserting all details into database
			$sql = "INSERT INTO list_permohonan (nama_pelajar, no_pelajar, nama_penjaga, no_tel_penjaga, tarikh, alamat_rumah)
			VALUES ('$nama', '$no_pelajar', '$nama_penjaga', '$tel_penjaga', '$tarikh_pulang_bermalam-$tarikh_balik_asrama', '$alamat_rumah')";

			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";

				header("Location: index.php?berjaya=true");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else {
			header("Location: mohon_pulang.php?ralat=true");
		}
		
		// Close connection
		$conn->close();
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title><?php echo "Permohonan Balik Bermalam" ?></title>
  </head>
  <body>
		<br>
    <div class="container">
			<h1>Permohonan Untuk Balik Bermalam</h1>
			<br>
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
				<div class="form-group row">
					<label for="nama" class="col-sm-2 col-form-label">Nama</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="nama" name="nama" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="no_pelajar" class="col-sm-2 col-form-label">No Pelajar</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="no_pelajar" name="no_pelajar" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="nama_penjaga" class="col-sm-2 col-form-label">Nama Penjaga</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="nama_penjaga" name="nama_penjaga" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="tel_penjaga" class="col-sm-2 col-form-label">No Telefon Penjaga</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="tel_penjaga" name="tel_penjaga" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="tarikh_pulang_bermalam" class="col-sm-2 col-form-label">Tarikh Pulang Bermalam</label>
					<div class="col-sm-6">
						<input type="date" class="form-control" id="tarikh_pulang_bermalam" name="tarikh_pulang_bermalam" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="tarikh_balik_asrama" class="col-sm-2 col-form-label">Tarikh Balik Asrama</label>
					<div class="col-sm-6">
						<input type="date" class="form-control" id="tarikh_balik_asrama" name="tarikh_balik_asrama" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="alamat_rumah" class="col-sm-2 col-form-label">Alamat Rumah</label>
					<div class="col-sm-6">
						<textarea class="form-control" rows="5" id="alamat_rumah" name="alamat_rumah" required></textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-8 d-flex justify-content-end">
						<button type="submit" name="hantar" class="btn btn-primary">Hantar</button>
					</div>
				</div>
			</form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>