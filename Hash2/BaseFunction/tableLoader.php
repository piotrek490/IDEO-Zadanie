<?php

function loadBase(){ 		//funkcja zwraca liste główną $list
	$polaczenie=@mysqli_connect("localhost","root","","HaszSet");
	if(!$polaczenie)
	{
		echo "Problem polaczenia z baza danych";
		exit(1);
	}

	$list = new LinkedList(1); 
	
	$pierwszy=null;
	$zapytanie="select * from MainTableData where isFirst=1;";  //Wyznaczam pierwszy element (isFirst) aby przez valNext wysnaczać następne
	$wynik = mysqli_query($polaczenie, $zapytanie);
	
	if(!$wynik){
		echo "Problem funkcji loadBase => loadBase(); (0.1)";
	}
	
	while($wiersz=mysqli_fetch_assoc($wynik)){
		$data = new tableData($wiersz['val']); //tworzę obiekt z danymi do listy
		$data->update($wiersz['val'],$wiersz['valNext'],$wiersz['dataKey']);
		if(bdSubExist($wiersz['dataKey'])) $data->setData(loadSubBase($wiersz['dataKey']));  //Jeśli klucz tabeli danych nie jest pusty to wczytaj tabele danych
		$list->insertLastObject($data); //dodaje obiekt na koniec listy $list
		
		if($wiersz['valNext']==null) break; //jeśli nie ma następnej wartości następuje wyjście z pętli
		
		$zapytanie="select * from MainTableData where val=".$wiersz['valNext'].";";
		$wynik = mysqli_query($polaczenie, $zapytanie);
		if(!$wynik){
			echo "Problem funkcji loadBase => loadBase(); (0.2)";
		}
	}
	
	
	return $list;
	/*			SELECT * FROM `maintabledata` where `val`=(SELECT `valNext` FROM `maintabledata` WHERE `valNext`=`val`)
		wymyśl zapytanie które wyświetli odpowiednio rekordy w kolejności
	*/
}


function loadSubBase($dataKey){ 		//funkcja zwraca liste główną $list
	$polaczenie=@mysqli_connect("localhost","root","","HaszSet");
	if(!$polaczenie)
	{
		echo "Problem polaczenia z baza danych";
		exit(1);
	}

	$dataList = new LinkedList(1); 
	
	$pierwszy=null;
	$zapytanie="select * from ".$dataKey." where isFirst=1;";  //Wyznaczam pierwszy element (isFirst) aby przez valNext wysnaczać następne
	$wynik2 = mysqli_query($polaczenie, $zapytanie);
	
	if(!$wynik2){
		echo "Problem funkcji loadBase => loadSubBase(); (0.1)";
	}
	
	while($wiersz2=mysqli_fetch_assoc($wynik2)){
		$data = new tableData($wiersz2['val']); //tworzę obiekt z danymi do listy
		$data->update($wiersz2['val'],$wiersz2['valNext'],$wiersz2['dataKey']);
		if(bdSubExist($wiersz2['dataKey'])) $data->setData(loadSubBase($wiersz2['dataKey']));
		$dataList->insertLastObject($data); //dodaje obiekt na koniec listy $list
		
		if($wiersz2['valNext']==null) break; //jeśli nie ma następnej wartości następuje wyjście z pętli
		
		$zapytanie="select * from ".$dataKey." where val=".$wiersz2['valNext'].";";
		$wynik2 = mysqli_query($polaczenie, $zapytanie);
		if(!$wynik2){
			echo "Problem funkcji loadBase => loadSubBase(); (0.2)";
		}
	}
	
	
	return $dataList;
	/*			SELECT * FROM `maintabledata` where `val`=(SELECT `valNext` FROM `maintabledata` WHERE `valNext`=`val`)
		wymyśl zapytanie które wyświetli odpowiednio rekordy w kolejności
	*/
}


?>