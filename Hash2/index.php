<?php 

//=====LOGOWANIE DO BAZY DANYCH=====

include 'BaseFunction\loadBase.php';

//=====FUNKCJE BAZODANOWE=====

include 'BaseFunction\addData.php';
include 'BaseFunction\tableLoader.php';

//=====KLASY LISTY PHP=====

include 'PhpFunction\listClass.php';



///////////////////////////TO DO LIST////////////////////////////////
/*
	DODAWANIE								[V]	(!) Metody typu Insert/addSubListIndex itp.
	EDYCJA									[V]	(!) Metoda editValue/moveTo itp.
	USUWANIE								[V]	(!) Metody typu delete
	SORTOWANIE								[V]	(!) Metoda Sort
	PRZENOSZENIE WĘZŁÓW						[V]	(!) Metoda moveTo
	ROZWIJANIE STRUKTURY					[V]
	ZABEZPIECZENIA							[V]	(!) Zabezpieczenie polaga na zablokowaniu opcji dodawania tych samych wartości do węzła
	WYPISYWANIE                          	[V]	
	BAZA DANYCH								[V]
	
	FUNKCJE UŻYTKOWNIKA						[V]
	UPROSZCZENIE BAZY DANYCH				[X]
	STYLE ODDZIELNIE						[V]



//TWORZNIE GŁÓWNEJ LISTY MENU

$list = new LinkedList(1);   		//			TWORZENIE OBIEKTÓW:	                 (Jedynka w konstruktorze to przykładowa forma klucza rootListy)
$hashSet = new HashSet();	//				LISTY, HASHLISTY
$hashSet -> rootList($list);		// PRZYPISANIE GŁÓWNEJ LISTY DO OBIEKTU HASHSET		


$list = loadBase();

*/
?>	





<!DOCTYPE html>
<html>


<head>
<meta charset="utf-8"/>
<title></title>
<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script type="text/javascript" src="Ajax/ajax.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css" />	
</head>


<body>
	
	<?php 
	/*																										
	
	$list->insertFirst(3);  //Umieszczam elementy do głównej listy w drzewku
	$list->insertFirst(2);
	$list->insertFirst(9);
	$list->insertFirst(2);  //Tego nie wprowadzi! ZABEZPIECZENIE! Nie może być dwuch takich samych wartości na jednej liście!
	
	
	//$list->printList();        //Pierwsze wypisanie listy
	
	
	$hashSet->sortList($list,false);		//Sortowanie naszej listy $list
	
	
	
	$hashSet->addSubListElem($list,2,4);	//Dodanie wartości do Sublisty elementu 2 (głównej listy)
	$hashSet->addSubListElem($list,2,5);	
	$hashSet->addSubListElem($list,2,8);	
	
	$hashSet->addSubListElem($list,3,2);	//Dodanie wartości do Sublisty elementu 3 (głównej listy)
	$hashSet->addSubListElem($list,3,42);
	
	$hashSet->addSubListElem($list,9,0);	//Dodanie wartości do Sublisty elementu 9 (głównej listy)
	
	$hashSet->addSubListIndex($list->getIndex(0),10);    //Dodanie wartości do Sublisty elementu 9 (głównej listy) (W tym przypadku element jest wskazanu swoim indexem)
	$hashSet->addSubListIndex($list->getIndex(0),14);
	$hashSet->addSubListIndex($list->getIndex(0),5);
	
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1),1);  //Dodanie wartości do Sub-Sublisty elementu 9->14
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1),2);
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1),3);
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1),100);
	
	
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1)->data->getIndex(2),100); //Dodanie wartości do Sub-Sub-Sublisty elementu 9->14->3
	$hashSet->addSubListIndex($list->getIndex(0)->data->getIndex(1)->data->getIndex(2),200);
	
	$hashSet->sortList($list->getIndex(2)->data,false); //Sortowanie Sublisty elementu o indexie 2 (licząc od zera) (głównej listy)
	
	/*
	echo "|  KeyList: ".$list->getIndex(0)->data->keyList."   |";
	echo "|  KeyList: ".$list->getIndex(0)->data->getIndex(1)->data->keyList."   |";
	
	
	echo $list->getIndex(0)->key;
	$list->getElem(2)->data->printList();
	
	echo $list->size(); 
	*/
	
	
	/*
	$list->iterPrint();  //Wypisanie listy

	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	$hashSet->moveTo($list->getIndex(0)->data->getIndex(1)->data   , 0 ,   $list->getIndex(0)->data->getIndex(1)->data->getIndex(2)->data);	//Test metody moveTo
	//$hashSet->moveTo($list->getIndex(0)->data->getIndex(1)->data   , 2 ,   $list->getIndex(0)->data->getIndex(1)->data->getIndex(0)->data);                      // Coś usuwa 100 gdy daje do 2
	$list->iterPrint();   //Wypisanie listy
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	$list->deleteIndex(0);  //Usunięcie elementu o indexie 0 z głównej listy
	*/
	//$list->iterPrint();  //Wypisanie listy
	?>
	
	<div id="mainOption">Main List
		<button onclick="addData('MainTableData')" class="addBtn">+</button>
		<button onclick="childSort('MainTableData')" class="sortBtn">S</button>
	</div>
	
	
	<div id="legendDiv"><b>Legenda:</b> &nbsp; &nbsp;
		<button class="addBtn">+</button> Dodaj &nbsp;
		<button class="remBtn">-</button> Usuń &nbsp;
		<button class="modBtn">M</button> Modyfikuj &nbsp;
		<button class="sortBtn">S</button> Sortuj &nbsp;
	</div>
	
	<div id="TS"></div>
	
</body>


</html>