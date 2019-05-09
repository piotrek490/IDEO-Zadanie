<?php




function delKey($key, $polaczenie){  //funkcja wyszukująca i usuwająca rekord z bazy danych
		
		//TWOZE TABELE Z TABELAMI W NASZEJ BAZIE
		$zapytanie = 	"SELECT DISTINCT TABLE_NAME ".
						"FROM INFORMATION_SCHEMA.COLUMNS ".
						"WHERE COLUMN_NAME IN ('dataKey') ".
						"AND TABLE_SCHEMA='haszset';";
		$wynik =  mysqli_query($polaczenie, $zapytanie);
		
		while($wiersz = mysqli_fetch_assoc($wynik)){ //ITERUJE PRZEZ WSZYSTSKIE WARTOŚCI TABELI ($WIERSZ['TABLE_NAME'] TO NAZWY TABEL W HASZSET)
			$zapytanie_szukanie = "select * from ".$wiersz['TABLE_NAME']." where dataKey like \"".$key."\";";
			$wynik_szukania = mysqli_query($polaczenie,$zapytanie_szukanie); //jeśli wynik zawiera rekord to znaczy że to ten jedyny ^^
			
			$switch = mysqli_fetch_array($wynik_szukania, MYSQLI_ASSOC);
			
			if($switch){ //Jeśli jest wynik w tej tabeli
				echo "Wchodze!<br>"; 
				//Ustaw obiektowi poprzedniemu, valNext obiektu następnego:     [1]->[2]->[3]     na    [1]->[3]				
				$zapytanie_podmianka = 	"update ".$wiersz['TABLE_NAME'].
										" set valNext = (select * from (select valNext from ".$wiersz['TABLE_NAME']." where dataKey like \"".$key."\") as tab1)".
										" where valNext = (select * from (select val from ".$wiersz['TABLE_NAME']." where dataKey like \"".$key."\") as tab2);";
				$wynik_podmianka = mysqli_query($polaczenie,$zapytanie_podmianka);
				
				//Usuń niepotrzebny obiekt z bazy danych:     [1]->[3] [2]  usuń:  [2]	
				$zapytanie_usuniecie = "delete from ".$wiersz['TABLE_NAME'].
										" where dataKey like \"".$key."\";";
				$wynik_usuniecie = mysqli_query($polaczenie,$zapytanie_usuniecie);
				
				echo $zapytanie_podmianka."<br><br>";
				echo $zapytanie_usuniecie;
				
				return true;
			}
			else;
		
		}
}







	

$polaczenie=@mysqli_connect("localhost","root","","HaszSet");
if(!$polaczenie)
{
	echo "Problem polaczenia z baza danych";
	exit(1);
}

// Sprawdza czy istnieje taka tabela


	$zapytanie = "select * from ".$_GET['key']." limit 1;";
	$wynik =  mysqli_query($polaczenie, $zapytanie);

	if($wynik)
	{
		// Rozpoczynam usuwanie tabeli
		$zapytanie2 = "drop table ".$_GET['key'].";";
		$wynik2 =  mysqli_query($polaczenie, $zapytanie2);
		
		delKey($_GET['key'], $polaczenie);
	}
	else{
		// Rozpoczynam usuwanie rekordu key
		delKey($_GET['key'], $polaczenie);
	} 	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


?>