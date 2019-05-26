<?php 
if (isset($_POST['fetch']))
{
	try {
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$database = "test";
		$db = new mysqli($dbhost, $dbuser, $dbpass,$database) or die("Povezivanje nije uspjelo: %s\n". $conn -> error);//povezivanje na bazu

		$query = "SELECT * FROM slike";

		$results = mysqli_query($db, $query);
		while($row = mysqli_fetch_array($results))//dohvat slika
		{
		    echo '<div><a href="slike/'.base64_decode($row['slika']).'" download>'.$row['ime_slike'].'</a></div>';//kreiranje linka		    
		}
		mysqli_close($db);
	}
	catch (Exception $ex)
	{
		echo "Greska kod upisa u bazu: ", $e->getMessage(), "\n";
	}
}
?>