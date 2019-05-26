<?php
	interface IUser
	{
		public function read();
	}

	class User implements IUser
	{
		var $ime;
		var $prezime;
		var $email;
		var $spol;
		var $slika;
		var $zivotopis;

		function __construct($ime, $prezime, $email, $spol, $slika, $zivotopis)
		{
			$this->ime = $ime;
			$this->prezime = $prezime;
			$this->email = $email;
			$this->spol = $spol;
			$this->zivotopis = $zivotopis;

			$this->slika = substr($slika, 0, strpos($slika, '?'));//potrebno je sve prije ? iz xml
		}

		function read()
		{
			$data = array(
				'ime' => $this->ime,
				'prezime' => $this->prezime,
				'email' => $this->email,
				'spol' => $this->spol,
				'zivotopis' => $this->zivotopis,
				'slika' => $this->slika
			);
			return $data;
		}
	}
?>