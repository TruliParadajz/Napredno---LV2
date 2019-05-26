<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "practice";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Povezivanje nije uspjelo: %s\n". $conn -> error);

$dir = "backup/$db";

//postoji li direktorij
if(!file_exists($dir)) {
	mkdir($dir, 0755, true) or
		die ("Ne moze stvoriti direktorij\r\n");
} else {
	printf("Direktorij vec postoji.\r\n");
}

$time = time();

$row = mysqli_query($conn, 'SHOW TABLES');

if(mysqli_num_rows($row) > 0) {
	 printf("Backup za bazu podataka $db.\r\n");
	while(list($table) = mysqli_fetch_array($row, MYSQLI_NUM)) {
		$query = "SELECT * FROM $table";
		$rows = mysqli_query($conn, $query);
		$names = mysqli_query($conn, $query);

		$counter = 0; 
		$fields = array(); //prazna polja kao pomocna varijabla za upisivanje imena stupaca
		$nm = ""; // string u koji se upisuju sva imena stupaca

		while($n = mysqli_fetch_field($names)) { //sluzi za dohvacanje imena stupaca
			$fields[] = $n->name; // spremanje pojedinog naziva stupca u polje fields
			$counter += 1; // brojac za odredivanje velicine polja
		}

		 //petlja za unos naziva stupaca tablice
		for($i = 1; $i < $counter; $i++){
			if($i == $counter-1) {
				$nm .= $fields[$i] . "";
			}
			else {
				$nm .= $fields[$i] . "," . " ";
			}
		}

		if(mysqli_num_rows($rows) > 0) {

			if($fp = gzopen("$dir/{$table}_{$time}.sql.gz", 'w9')) {
				while($currentRow = mysqli_fetch_array($rows, MYSQLI_NUM)) {
					$curNum = 0; // inicijalizacija, reset brojaca
					gzwrite($fp, "INSERT INTO $table ($nm)\r\n"); // unos teksta za insert za svaki red u tablici
					gzwrite($fp, "VALUES (");
					foreach ($currentRow as $value) {
						$curNum++; // brojac za brojanje vrijednosti u tablici, ako je zadnji element da se ne stavi ,
	
						if($curNum == $counter){
							gzwrite($fp, "'$value'");	
						} 
						else if ($value != $value[0]) { // provjera da se ne unosi prvo polje (ID iz tablice)
							gzwrite($fp, "'$value',");
						}
	
					}
					gzwrite($fp, ");");
				//novi red
					gzwrite($fp, "\r\n");
				}//zatvaranje datoteke

				gzclose($fp);
			} else {
				printf("Datoteka $dir/{$table}_{$time}.txt se ne moze otvoriti.\r\n");
				break;
			} // kraj gzopen

		} // kraj provjere redova (rows)

 	}  //kraj while petlje za dohvacanje podataka (fetch)
}
else {
	printf("Baza skladiste ne sadrzi tablice.\r\n");
} 

?>