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
	$dbname = "id17301791_sekolah";;

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	#echo "Connected successfully";

	$sql = "SELECT * FROM list_permohonan WHERE NOT status=0";
	$result = $conn->query($sql);

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

    <title>Semakan Permohonan Pelajar Untuk Balik Bermalam</title>
  </head>
  <body>
		<br>
    <div class="container">
			<div class="form-group d-flex justify-content-between">
				<h2 class="">Senarai Pelajar Yang Pernah Memohon Untuk Balik Bermalam</h1>
				<a class="btn btn-dark btn-lg" href="semak_permohonan.php" role="button">Kembali</a>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nama</th>
						<th scope="col">No Pelajar</th>
						<th scope="col">Nama Penjaga</th>
						<th scope="col">No Tel Penjaga</th>
						<th scope="col">Tarikh</th>
						<th scope="col">Alamat Rumah</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if ($result->num_rows > 0) {
							$count = 1;
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo "<tr>";
								echo "<th scope='row'>$count</th>";
								echo "<td>" . $row["nama_pelajar"] . "</td>";
								echo "<td>" . $row["no_pelajar"] . "</td>";
								echo "<td>" . $row["nama_penjaga"] . "</td>";
								echo "<td>" . $row["no_tel_penjaga"] . "</td>";
								echo "<td>" . $row["tarikh"] . "</td>";
								echo "<td>" . $row["alamat_rumah"] . "</td>";
								
                if ($row["status"] == 1) {
                  echo '<td>Permohonan diterima</td>';
                }
                else if ($row["status"] == 2) {
                  echo '<td>Permohonan ditolak</td>';
                }

								echo "</tr>";
								$count++;
							}
						} else {
							echo "0 results";
						}
						$conn->close();
					?>
				</tbody>
			</table>
			<br>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>