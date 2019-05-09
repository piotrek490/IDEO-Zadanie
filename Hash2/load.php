<?php

//=====LOGOWANIE DO BAZY DANYCH=====

include 'BaseFunction\loadBase.php';

//=====FUNKCJE BAZODANOWE=====

include 'BaseFunction\addData.php';
include 'BaseFunction\tableLoader.php';

//=====KLASY LISTY PHP=====

include 'PhpFunction\listClass.php';


$list = new LinkedList(1);   		//			TWORZENIE OBIEKTÓW:	                 (Jedynka w konstruktorze to przykładowa forma klucza rootListy)
$hashSet = new HashSet();	//				LISTY, HASHLISTY
$hashSet -> rootList($list);		// PRZYPISANIE GŁÓWNEJ LISTY DO OBIEKTU HASHSET		


$list = loadBase();



$list->iterPrint(); 


?>

