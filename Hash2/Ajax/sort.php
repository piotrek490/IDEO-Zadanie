<?php


function connect(){
	
	$polaczenie=@mysqli_connect("localhost","root","","HaszSet");
	if(!$polaczenie)
	{
		echo "Problem polaczenia z baza danych";
		exit(1);
	}
	return $polaczenie;
}


function sortList($key, $sortType){  //funkcja wyszukująca i modyfikująca rekord z bazy danych
		
		$polaczenie=connect();
		
		$size = listSize($key ,$polaczenie);
		
		echo "Size: ".$size;
		
		if(!$sortType){		//A-Z
			
			//echo valueIndex($key, 0)."<br/>".valueIndex($key, 1)."<br/>".valueIndex($key, 2)."<br/>";
			for($x=0; $x<$size-1; $x++){
				for($i=0; $i<$size-1; $i++){
					$iV1= valueIndex($key, $i);	$iV2= valueIndex($key, $i+1);
					
					if($iV1>$iV2){
						swap($key, $iV1, $iV2);
					}
				}
			}
			
		}
		
		
		else{				//Z-A
			
			for($x=0; $x<$size-1; $x++){
				for($i=0; $i<$size-1; $i++){
					$iV1= valueIndex($key, $i);	$iV2= valueIndex($key, $i+1);
					
					if($iV1<$iV2){
						swap($key, $iV1, $iV2);
					}
				}
			}
			
		}
		
		
}


function listSize($key, $polaczenie){
	
	$zapytanie_size =	"select count(val) as size from ".$key.";";
	$wynik_size = mysqli_query($polaczenie, $zapytanie_size);
	
	if($wiersz = mysqli_fetch_assoc($wynik_size)) return $wiersz['size'];
	
}


function valueIndex($key, $index) //Funckcja indexuje tablice od 0
{
	$polaczenie = connect();
	
	$zapytanie_pw = "select val, valNext from ".$key." where isFirst = 1;";
	$wynik = mysqli_query($polaczenie, $zapytanie_pw);
	if(!$wynik) {echo "Error: sort->valueIndex(0.1)"; exit(1);}
	
	$aktualnyIndex=0;
	
	while($wiersz = mysqli_fetch_assoc($wynik)) {
		if($aktualnyIndex == $index) return $wiersz['val'];
		
		else{
			$aktualnyIndex++;
			$zapytanie_next = "select val, valNext from ".$key." where val = ".$wiersz['valNext'].";";
			//echo "<br> Wykonuje: ".$zapytanie_next;
			$wynik = mysqli_query($polaczenie, $zapytanie_next);		//zastępuje aktualny wynik dla while
			if(!$wynik) {echo "Error: sort->valueIndex(0.2-While)"; exit(1);}
		}
	}
	
	
}



function swap($key, $value1, $value2){
	
	$polaczenie = connect();
	
	//Sprawdzamy czy value1 jest pierwszym elementem listy i notujemy to w zmiennej
	$zapytanie_pierwszy = "select * from ".$key." where val = ".$value1.";";
	$wynik_pierwszy = mysqli_query($polaczenie, $zapytanie_pierwszy);
	$czy_pierwszy = false; //true <=> Value1: isFirst=1 
	
	while($wiersz = mysqli_fetch_assoc($wynik_pierwszy)){
		if( $wiersz['isFirst'] == 1 ) $czy_pierwszy = true;
		else $czy_pierwszy = false;
	}
	
	$zapytanie_krok1 = 	"update ".$key." set ".	//Value1 zaczyna wskazywać na Value2->nextVal
						" valNext = (select * from (select valNext from ".$key." where val = ".$value2.") as tab)".
						" where val = ".$value1.";";
						
	$zapytanie_krok2 =	"update ".$key." set ".	//Jeśli Value1 nie jest isFirst => niech wartość z valNext=Value1 wskazuje na Value2
						" valNext = ".$value2.
						" where valNext = (select * from (select valNext from ".$key." where valNext = ".$value1.") as tab);";
	
	$zapytanie_krok3 = 	"update ".$key." set ".	//Value2 zaczyna wskazywać na Value1
						" valNext = ".$value1.
						" where val = ".$value2.";";
	
	$zapytanie_krok4 = 	"update ".$key." set ".  //Jeśli Value1 był isFirst => ustaw Value1 isFirst=0
						" isFirst = 0".
						" where val = ".$value1.";";
	
	$zapytanie_krok5 = 	"update ".$key." set ".  //Jeśli Value1 był isFirst => ustaw Value2 isFirst=1
						" isFirst = 1".
						" where val = ".$value2.";";
						
	$wynik_krok1 = mysqli_query($polaczenie, $zapytanie_krok1);
	if(!$wynik_krok1) {echo "Error: sort->swap(0.1)"; exit(1);}
	
	if(!$czy_pierwszy){
		
		$wynik_krok2 = mysqli_query($polaczenie, $zapytanie_krok2);
		if(!$wynik_krok2) {echo "Error: sort->swap(0.2)"; exit(1);}
		
	}
	
	$wynik_krok3 = mysqli_query($polaczenie, $zapytanie_krok3);
	if(!$wynik_krok3) {echo "Error: sort->swap(0.3)"; exit(1);}
	
	if($czy_pierwszy){
		
		$wynik_krok4 = mysqli_query($polaczenie, $zapytanie_krok4);
		if(!$wynik_krok4) {echo "Error: sort->swap(0.4)"; exit(1);}
	
		$wynik_krok5 = mysqli_query($polaczenie, $zapytanie_krok5);
		if(!$wynik_krok5) {echo "Error: sort->swap(0.5)"; exit(1);}
		
	}
}



	

	

	//Wywołanie funkcji wyszukującej i zmieniającej wartość "po kluczu"
	//sortList($_GET['key'],$_GET['type']);          //type: jeśli 1 to molejąco, a jeśli 0 to rosnąco
	
	$type = false;
	if($_GET['type']==1) $type = true; 
	
	sortList($_GET['key'], $type);
	
	



?>