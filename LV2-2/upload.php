<?php
if (isset($_POST['upload']))
{
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$database = "test";
	$db = new mysqli($dbhost, $dbuser, $dbpass,$database) or die("Povezivanje nije uspjelo: %s\n". $conn -> error);

	$map = "slike/".basename($_FILES['image']['name']); //definiranje putanje gdje ce se spremati slika

	$n = $_FILES['image']['name']; 
	$name = substr($n, 0, strpos($n, '.'));//ime bez ekstenzije
	$image = $_FILES['image']['name']; // sama slika s ekstenzijom
	
	$image = base64_encode($image); // kodiranje u base64 format

	try 
	{
		$query = "INSERT INTO slike (ime_slike, slika) VALUES ('$name', '$image')";
		mysqli_query($db, $query);

		if(move_uploaded_file($_FILES['image']['tmp_name'], $map))//lokalno spremanje
		{
			echo "Upload slike uspjesan";
		}
		else
		{
			throw $exp;
		}
	} 
	catch(Exception $ex)
	{
		echo "Greska kod upisa u bazu: ", $e->getMessage(), "\n";
	}
	mysqli_close($db);	
}
?>