<?php

function keyGenerate(){
		$key="k";
		$key.= date("His");
		$key.=rand(1000, 9999);
		return $key;
	}

$polaczenie=@mysqli_connect("localhost","root","","HaszSet");
if(!$polaczenie)
{
	echo "Problem polaczenia z baza danych";
	exit(1);
}

// Sprawdzam czy jest już w tabeli taka wartość

$zapytanie="select * from ".$_GET['key']." where val=".$_GET['value'].";";
$wynik = mysqli_query($polaczenie, $zapytanie);

$switch = mysqli_fetch_array($wynik, MYSQLI_ASSOC);

if($switch) exit(1); //Jeśli jest już taka wartość -> "wyłączam" ten plik

// Rozpoczynam dodawanie rekordu do tabeli

$zapytanie="create table ".$_GET['key']." (val int(20),valNext int(20),dataKey text,isFirst int(1))CHARSET=utf8;"; //Tworzę tabele (jeśli nie istnieje!)	
$wynik = mysqli_query($polaczenie, $zapytanie);


$zapytanie="select * from ".$_GET['key']." where valNext is null limit 1;";	//sprawdam czy są już jakieś rekordy
$wynik = mysqli_query($polaczenie, $zapytanie);

//$lastVal=null; //bufor dla ostatniej wartości w tabeli (w celu dodania valNext do niej)

$switch = mysqli_fetch_array($wynik, MYSQLI_ASSOC);

if($switch){	//Jeśli jest wynik to oznacza że istnieje jakaś wartość z valNext = null
	//while($wiersz = mysql_fetch_assoc($wynik)){
	//	$lastVal=$wiersz['val'];	//Zapisuje do buforu wartość tego zapytania
	//}
	
	/*
	
		UWAGA! Tutaj dodać zapytanie które doda rekord z isFirst=0, a buforowi Val dodać valNext !!!!!!!!!!!!!
	
	*/
	
	$zapytanie2="update ".$_GET['key']." set valNext=".$_GET['value']." where valNext is NULL;";	//ustawiam wskańnik na ostatni element listy
	$wynik2 = mysqli_query($polaczenie, $zapytanie2);
	if(!$wynik2) {echo "Error: add.php (0.1)"; exit(1);}
	
	$zapytanie2="insert into ".$_GET['key']." values(".$_GET['value'].",NULL,\"".keyGenerate()."\",0);";	//tworzę ostatni elem. listy
	$wynik2 = mysqli_query($polaczenie, $zapytanie2);
	if(!$wynik2) {echo "Error: add.php (0.2)"; exit(1);}
	
}
else
{
	
	$zapytanie2="insert into  ".$_GET['key']." values(".$_GET['value'].",NULL,\"".keyGenerate()."\",1);";	//tworzę pierwszy elem. listy
	$wynik2 = mysqli_query($polaczenie, $zapytanie2);
	if(!$wynik2) {echo "Error: add.php (0.3)"; exit(1);}
	
}






?>