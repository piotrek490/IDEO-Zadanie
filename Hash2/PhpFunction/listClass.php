<?php

class tableData{     //Klasa danych w naszym "drzewie"

	public $data, $value; //Zawiera swoją wartość i dane, czyli podrzędną Linked Liste
	public $next; //NEXT wskazuje na następny obiekt listy
	public $key; //Klucz to unikalna wartość dla każdego Obiektu. To pod niego przypisane są dane w Bazie danych
	
	function __construct($value){
		$this->value = $value;
		$this->data = null;
		$this->key = $this->keyGen();
	}
	
	function update($value, $next, $key){
		$this->value = $value;
		$this->next = $next;
		$this->key = $key;
	}
	
	function setData($data){
		$this->data = $data;
	}
	
	private function keyGen(){
		$key="k";
		$key.= date("His");
		$key.=rand(1000, 9999);
		return $key;
	}
	
	
	function printData(){     //Funkcja służy do prostego wypisywania wartości i danych zawartych w obiekcie
		echo "<div class=\"dataDiv\">";
		echo $this->value."<br>";
		if($this->data!=null){
			for($i=0;$i<$this->data->size();$i++) $this->data->getIndex($i)->printData();
		}
		echo "<button onclick=\"addData('$this->key')\" class=\"addBtn\">+</button>";
		echo "<button onclick=\"remData('$this->key')\" class=\"remBtn\">-</button>";
		echo "<button onclick=\"modData('$this->key')\" class=\"modBtn\">M</button>";
		echo "<button onclick=\"childSort('$this->key')\" class=\"sortBtn\">S</button>";
		echo "</div>";
	}

}

//===================================================================

class LinkedList{  //Klasa do zarządzania Linked Listą utworząną z powyższej klasy danych
	private $first;   //Zmienna first zawiera obiekt, który jest pierwszy w naszej liście
	public $keyList;  
	private $mainList;
	
	function __construct($keyList){
		$this->first = null;      //Domyślnie po utworzeniu listy, nie zawiera ona obiektu first
		$this->mainList=false;
		$this->keyList=$keyList;
	}
	
	function setMainList($boolean){
		$this->mainList=$boolean;
	}
	
	function getMainList(){
		return $this->mainList;
	}
	
	
	function isEmpty(){        //Funkcja służy do sprawdzania czy istnieje obiekt first
		if($this->first==null) return true;
			else return false;
	}
	
	function getFirst(){      //Getter firsta
		return $this->first;
	}
	
	
	function setFirst($first){ //Setter firsta
		$this->first=$first;
	}
	
	function setFirstNext($next){  //Setter first -> next-a
		$this->first->next=$next;
	}
	
	function insertFirst($value){ //Metoda tworzy obiekt z podaną wartością i umieszcza go na pierwszym miejscu listy
		if($this->searchElem($value)) return false;
			$newData = new tableData($value);
			$newData->next=$this->first;			
			$this->first=$newData;
			if($this->mainList) {
				if($this->first->next!=null) {
					bdMainData($this->first->value, $this->first->next->value, $this->first->key, 1);
					bdMainSetFirst($this->first->key);
				}
				if($this->first->next==null) {
					bdMainData($this->first->value, 'null', $this->first->key, 1);
					bdMainSetFirst($this->first->key);
				}
			}else{
				if(bdSubExist($this->keyList)){  
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1);                 
				}else{
					bdAddData($this->keyList);
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1);   
				}
			}
		return true;
	}
	
	function insertLast($value){ //Jak wyżej tylko umieszcza na końcu :D
		if($this->searchElem($value)) return false;
			$newData = new tableData($value);
			if($this->first==null) $this->first=$newData;
			else{
				$current=$this->first;
				$previous = null;
				while($current!=null)
				{
					$previous=$current;
					$current=$current->next;
				}
				$previous->next=$newData;
				
				if($this->mainList) {
					bdMainData($newData->value, 'null', $newData->key, 0);
				}else{
				if(bdSubExist($this->keyList)){  
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1);
				}else{
					bdAddData($this->keyList);
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1); 
				}
			}
			}
		return true;
	}
	
	
	function insertFirstObj($object){   	   //   <----------  Tutaj dwie metody które działają na obiekcie a nie na zmiennej value 		
		if($this->searchObject($object)) return false;
			$object->next=$this->first;
			$this->first=$object;
			if($this->mainList) {
				if($this->first->next!=null) {
					bdMainData($this->first->value, $this->first->next->value, $this->first->key, 1);
					bdMainSetFirst($this->first->key);
				}
				if($this->first->next==null) {
					bdMainData($this->first->value, 'null', $this->first->key, 1);
					bdMainSetFirst($this->first->key);
				}
			}else{
				if(bdSubExist($this->keyList)){  
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1);                
				}else{
					bdAddData($this->keyList);
					if($newData->next!=null) bdSubData($this->keyList, $newData->value, $newData->next->value, $newData->key, 1);
						else bdSubData($this->keyList, $newData->value, 'null', $newData->key, 1);  
				}
			}
		return true;
	}
	
	function insertLastObj($object){      	//  <----------
		if($this->searchObject($object)) return false;
			if($this->first==null){
				 $this->first=$object;
				 $object->next=null;
			}
			else{
				$current=$this->first;
				$previous = null;
				while($current!=null)
				{
					$previous=$current;
					$current=$current->next;
				}
				$previous->next=$object;
				$object->next=null;
				if($this->mainList) {
					bdMainData($object->value, 'null', $object->key, 0);
				}else{
				if(bdSubExist($this->keyList)){  
					if($object->next!=null) bdSubData($this->keyList, $object->value, $object->next->value, $object->key, 1);
						else bdSubData($this->keyList, $object->value, 'null', $object->key, 1);                  
				}else{
					bdAddData($this->keyList);
					if($object->next!=null) bdSubData($this->keyList, $object->value, $object->next->value, $object->key, 1);
						else bdSubData($this->keyList, $object->value, 'null', $object->key, 1);        
				}
			}
			}
		return true;
	}
	
	function insertLastObject($object){      	//  <---------- to co powyżej bez bazy danych
		if($this->searchObject($object)) return false;
			if($this->first==null){
				 $this->first=$object;
				 $object->next=null;
			}
			else{
				$current=$this->first;
				$previous = null;
				while($current!=null)
				{
					$previous=$current;
					$current=$current->next;
				}
				$previous->next=$object;
				$object->next=null;
				
			}
		return true;
	}
	
	function deleteFirst(){	//Usuwa pierwszy element listy (jeśli isnieje)             			     (Zwraca True/False)
		if($this->isEmpty()){
			return false;
		}
		
		$buffer = $this->first->next;
		$this->first = $buffer;
		return true;
	}
	
	function deleteElem($val){ 	//Usuwa element listy o podanej wartości (jeśli isnieje)  	(Zwraca True/False)
		if($this->isEmpty()){
			return false;
		}
		
		$current = $this->first;
        $previous = null;
		
		while ($current->value != $val)
        {
            if ($current->next == null) return null; //Nie znalazl elementu
            else
            {
                $previous = $current;     // Przechodzimy do następnego elementu
                $current = $current->next;
            }
        }
		
		//Mam już element. Teraz zacznę go usuwać
		
		if ($previous == null)  // jeżeli jest to pierwszy element...
        {
            $this->first = $this->first->next; // ...zmieniamy pole first
        }
        else                  // jeżeli nie jest to pierwszy
        {
            $previous->next = $current->next;   // Usuwamy aktualny element przez jego pominiecie
        }

        return $current; //Zwracamy usuniety element
	}
	
	
	function deleteIndex($index){	//Usuwa element listy o podanym indexie  	(Zwraca usunięty obiekt)
		if($this->isEmpty()){
			return null;
		}
		
		
		$toReturn = $this->getIndex($index);
		
		
		if($index==0){
			$this->first=$this->getIndex($index)->next;
			return $toReturn;
		}
		
		if($index>0){
			$this->getIndex($index-1)->next=$this->getIndex($index)->next;
			return $toReturn;
		}
		
		return null;
	}
	
	
	function getElem($elem)     // Pobieranie elementu po jego zawartości
    {

        $current = $this->first;  // Rozpoczynamy od pierwszego elementu
		if($current==null) return null;  //Gdyby nie było elementów na liście
        while ($current->value != $elem)
        {
            if ($current->next == null) return null;
            else
                $current = $current->next;
        }
		return $current;

    }
	
	function getIndex($index)     // Pobieranie elementu po jego indexie      element FIRST to index 0!         Jeśli podany index nie istnieje: zwracam NULL
    {
		if($this->first==null) return null;
        $current = $this->first;  // Rozpoczynamy od pierwszego elementu
        
		for($i=0; $i<$index;$i++){
			if($current->next==null) return null;
			$current = $current->next;
		}
		return $current;

    }
	
	function getByKey($key)     // Pobieranie elementu po jego kluczu  Jeśli podany klucz nie istnieje: zwracam NULL     Metoda przeszukuje wszystkie węzły
    {
		if($this->first==null) return null;
        $current = $this->first;  // Rozpoczynamy od pierwszego elementu
        
		for($nr=0; $nr<$this->size();$nr++){
			if($current->key==$key) return $current;
			else if ($currnet->data!=null) $buffered = $currnet->data->getByKey($key);
			if($buffered->key==$key) return $buffered;
		}
		return null;

    }
	
	function editValue($index,$newValue)  //Metoda do zmiany wartości elementu listy
	{
		if(!$this->searchElem($newValue)){ 			//Zabezpieczenie edycji wartości na taką, która już istnieje na liście
			$this->getIndex($index)->value = $newValue;   
			return true;
		}else return false;
    }
	
	
	function printList()   //Print list służy do wypisywania listy (w celach testowych :D)
    {
		$current = $this->first;
        while ($current!=null)      // Dopóki nie koniec listy...
        {
            echo $current->value." ";
			$current=$current->next;
        }
    }
	
	function size(){   //Zwraca ilość elementów/obiektów w danej liście
		$elems=0;
		if($this->first==null) return 0;
		
		$current = $this->first;
        while ($current!=null)      // Dopóki nie koniec listy...
        {
            $elems++;
			$current=$current->next;
        }
		
		return $elems;
		
	}
	
	
	function iterPrint(){  //Iteruje liste w celu wywołania metody printData() dla każdej danej
		for($nr=0; $nr<$this->size();$nr++){
			$this->getIndex($nr)->printData();
		}
	}
	
	
	function searchElem($elem){ //Metoda do wyszukiwania elementu/wartości (CEL: Zabezpieczenia)  (Zwraca Boolean    False/True)
		if($this->getElem($elem)!=null) return true;
			else false;
	}
	
	function searchObject($object){ //Metoda do wyszukiwania elementu/obiektu (CEL: Zabezpieczenia)  (Zwraca Boolean    False/True)
		if($this->getElem($object->value)!=null) return true;
			else false;
	}
	
	
	function bdUpdateFirst(){    //Jeśli tableKey == 1  funkcja operuje na głównej liście
		if($this->mainList){
			bdMainSetFirst($this->first->key);
		}
		else{
			bdSetFirst($this->keyList,$this->first->key);
		}
	
   }
   
 }

//===================================================================

class HashSet{  //Obiekt stworzony testowo dla Hash Listy

	private $rootList;   //Główna lista Hash Listy
	
	function __construct(){
		$this->rootList = null;
	}
	
	function rootList($list){
		$this->rootList=$list; 
		$list->setMainList(true);
	}
	
	function addSubList($target){           //Tworzy Linked Liste w Data obiektu            //Target wyznacza obiekt (a nie jego date!)
		if($target->data==null) $target->data=new LinkedList($target->key);
	}
	 
	function addSubListElem($supList,$supElem,$subElem){           //Dodaje Element do SubListy (Danych zawartych w obiekcie Listy)   (Element znajduje po wartości)
		if($supList->getElem($supElem)->data==null) $supList->getElem($supElem)->data=new LinkedList($supList->getElem($supElem)->key);
		$supList->getElem($supElem)->data->insertLast($subElem);
	}
	
	function addSubListIndex($supElem,$subElem){           			//Dodaje Element do SubListy (Danych zawartych w obiekcie Listy) 	  (Element znajduje po indexie)
		if($supElem->data==null) $supElem->data=new LinkedList($supElem->key);
		$supElem->data->insertLast($subElem);
	}
	
	function addSubListKey($key,$subElem){    //Dodaje Element do SubListy (Danych zawartych w obiekcie Listy) 	  (Element znajduje po kluczu)
		if($this->rootList->getByKey($key)->data==null) $this->rootList->getByKey($key)->data=new LinkedList($key);
		$this->rootList->getByKey($key)->data->insertLast($subElem);
	}
	
	
	
	function sortList($supList, $minMax){    //Funkcja sortowania oparta na Bubble Sort
		
		$sizeList = $supList->size();	
		
		for($x=0; $x < $sizeList-1; $x++){
			
			for($y=0; $y < $sizeList-1; $y++) 		//true - od Min do Max             false - od Max do Min
			{
					if($minMax){
						if($supList->getIndex($y)->value >= $supList->getIndex($y+1)->value) 
						{
							$this->swap($supList,$y,($y+1));
						}
					}
					
					if(!$minMax){
						if($supList->getIndex($y)->value <= $supList->getIndex($y+1)->value)  
						{
							$this->swap($supList,$y,($y+1));
						}
					}
			}
		
		}
		
		$supList->bdUpdateFirst();
	}
	
	
	function swap($supList,$index1,$index2){         //Metoda zamienia sąsiadów
		
		//JEśli index1 wskazuje na zmienną first                   
		if($index1==0 && $index2==1){        //Będzie zamieniał tylko pierwszy z drugim
			$goToFirst = $supList->getIndex($index2);
			
			$supList->getIndex($index1)->next=$goToFirst->next;
			$goToFirst->next=$supList->getIndex($index1);
			
			$supList->setFirst($goToFirst);
		}
		
		
		if($index1>0){ 
			$index1Next=$supList->getIndex($index1)->next;
			$index2Next=$supList->getIndex($index2)->next;
			$index1_1Next=$supList->getIndex($index1-1)->next;
			
			$supList->getIndex($index2)->next=$index1_1Next;
			$supList->getIndex($index1)->next=$index2Next;
			$supList->getIndex($index1-1)->next=$index1Next;
		}
		
	}
	
	
	
	function moveTo($list,$indexToMove,$toList){    	//Metoda przenosi element listy do innej listy
		if($toList==null) $toList=new LinkedList();
		if($toList->searchObject($list->getIndex($indexToMove))) return false;  //Metoda nie przeniesie objektu jeśli miałby on kolidować z innym objektem o tej samej wartości
			$movingObject=$list->getIndex($indexToMove);
			$list->deleteIndex($indexToMove);		
			$toList->insertLastObj($movingObject);
		return true;	
	}
	
	
	
}

?>