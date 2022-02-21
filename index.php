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

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	$tajuk = "Permohonan Balik Bermalam";

	// define variables and set to empty values
	$nama = $password = "";

	// cek sama ada page ini terima sebarang data drpd method GET,
	if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["berjaya"])) {
		if ($_GET["berjaya"] == "true") {
			echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<strong>Permohonan anda telah diterima dan disimpan.</strong>
			</div>';
		}
	}
	// cek sama ada page ini terima sebarang data drpd method GET,
	else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nama = test_input($_POST["nama"]);
		$kata_laluan = test_input($_POST["kata_laluan"]);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT * FROM pengajar WHERE nama='$nama' AND kata_laluan='$kata_laluan'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$_SESSION["nama"] = $nama;
			header("Location: semak_permohonan.php");
			exit;
		}
		else {
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

	// tapis data yang diterima sebelum data tersebut digunakan dalam sistem ini
	// untuk mengelakkan penceroboh (hacker) drpd mengeksploitasi sistem ini
	// merupakan salah satu feature iaitu adanya security
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

  	<title><?php echo $tajuk ?></title>
  </head>
  <body>
    <br>
  	<div class="container">
			<div class="jumbotron">
				<h2>Selamat Datang ke <br/>Daftar Permohonan Balik Bermalam<br/>Pelajar Asrama SMK A Tun Ahmadshah</h2>
				<p class="lead">Sila tekan Mohon untuk pelajar yang ingin memohon untuk balik bermalam.</p>
				<p class="lead">
					<a class="btn btn-primary btn-lg" href="mohon_pulang.php?tajuk=<?php echo $tajuk?>" role="button">Mohon</a>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#signin-warden">Khas untuk warden sahaja</button>
				</p>
			</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>


<!-- Modal untuk Warden Sign In -->
<div class="modal fade" id="signin-warden" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Isikan details anda</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
					<div class="form-group row">
						<label for="nama" class="col-sm-2 col-form-label">Nama</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="nama" name="nama" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="kata_laluan" class="col-sm-2 col-form-label">Kata Laluan</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="kata_laluan" name="kata_laluan" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-primary">Masuk</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>