<!DOCTYPE html>
<html>
<head>
	<title>3</title>
	<?php include("class.php"); ?>
</head>
<style type="text/css">		
	.frame {
		border-style: solid;
		border-width: 5px;
		width: 40%;
		text-align: center;
		margin: 0;
	}
	.image{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
</style>
<body>
	<div>
		<?php
		$xmlData = simplexml_load_file("lv2.xml") or die ("Greška kod učitavanja xml dokumenta.");

		foreach ($xmlData->record as $data) 
		{
			//mapiranje
			$ime = $data->ime;
			$prezime = $data->prezime;
			$email = $data->email;
			$spol = $data->spol;
			$slika = $data->slika;
			$zivotopis = $data->zivotopis;

			//stvaranje objekta koristenjem mapiranih atributa
			$user = new User($ime, $prezime, $email, $spol, $slika, $zivotopis);

			//d je polje, u budućnosti polje tj lista objekata
			$d = array();
			$d = $user->read();

			//unistavanje kako bi u sljedecoj iteraciji nastao novi user
			unset($user);

			echo
			"
			<div class='frame'>
			<img class='image' width='150' height='150' src={$d['slika']}/>
			<p class='profile'>Ime: {$d['ime']}</p>
			<p class='profile'>Prezime: {$d['prezime']}</p>
			<p class='profile'>Email: {$d['email']}</p>
			<p class='profile'>Spol: {$d['spol']}</p>
			<p class='profile'>Zivotopis: {$d['zivotopis']}</p>
			</div>
			<br><br>
			";
		}
		?>
	</div>
</body>
</html>