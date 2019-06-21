<?php




function modKey($key, $newValue, $polaczenie){  //funkcja wyszukująca i modyfikująca rekord z bazy danych
		
		//TWOZE TABELE Z TABELAMI W NASZEJ BAZIE
		$zapytanie = 	"SELECT DISTINCT TABLE_NAME ".
						"FROM INFORMATION_SCHEMA.COLUMNS ".
						"WHERE COLUMN_NAME IN ('dataKey') ".
						"AND TABLE_SCHEMA='haszset';";
		$wynik =  mysqli_query($polaczenie, $zapytanie);
		
		while($wiersz = mysqli_fetch_assoc($wynik)){ //ITERUJE PRZEZ WSZYSTSKIE WARTOŚCI TABELI ($WIERSZ['TABLE_NAME'] TO NAZWY TABEL W HASZSET)
			$zapytanie_szukanie = "select * from \"".$wiersz['TABLE_NAME']."\"' where dataKey like \"".$key."\";";
			$wynik_szukania = mysqli_query($polaczenie,$zapytanie_szukanie); //jeśli wynik zawiera rekord to znaczy że to ten jedyny ^^
			
			$switch = mysqli_fetch_array($wynik, MYSQLI_ASSOC);
			
			if($switch){ //Jeśli jest wynik w tej tabeli
			
				// Sprawdzam czy jest już w tabeli taka wartość  (Zabezpieczenie przed duplikacją wartości)

				$zapytanie_zabezpieczenie="select * from ".$wiersz['TABLE_NAME']." where val=".$newValue.";";
				$wynik_zabezpieczenie = mysqli_query($polaczenie, $zapytanie_zabezpieczenie);

				$bezpiecznik = mysqli_fetch_array($wynik_zabezpieczenie, MYSQLI_ASSOC);

				if($bezpiecznik) exit(1); //Jeśli jest już taka wartość -> "wyłączam" ten plik
			
				echo "Wchodze!<br>"; 
				//Ustaw obiektowi poprzedniemu, nową wartość valNext obiektu modyfikowanego:			
				$zapytanie_podmianka = 	"update ".$wiersz['TABLE_NAME'].
										" set valNext = ".$newValue.
										" where valNext = (select * from (select val from ".$wiersz['TABLE_NAME']." where dataKey like \"".$key."\") as tab);";
				echo $zapytanie_podmianka;
				$wynik_podmianka = mysqli_query($polaczenie,$zapytanie_podmianka);
				
				//Zmień wartość val = newValue dla wskazanego obiektu	
				$zapytanie_modyfikacja = "update ".$wiersz['TABLE_NAME'].
										 " set val = ".$newValue.
										 " where dataKey like \"".$key."\";";
				$wynik_modyfikacja = mysqli_query($polaczenie,$zapytanie_modyfikacja);
				
				return true;
			}
			else;
		
		}
}







	

include 'loadBase.php';

	//Wywołanie funkcji wyszukującej i zmieniającej wartość "po kluczu"
	modKey($_GET['key'],$_GET['value'], $polaczenie);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


?>