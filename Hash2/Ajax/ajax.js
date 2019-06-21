window.onload = ajaxInit;
window.onload = baseLoad;

/*
		===TO DO LIST===
			
			OBIEKTY:
DODAWANIE OBIEKTÓW			[-] <- dodać przycisk to MainListy   <- zabezpieczenie żeby można było dodać tylko liczbe
USUWANIE OBIEKTÓW			[V]
MODYFIKOWANIE OBIEKTÓW		[V]
SORTOWANIE OBIEKTÓW			[V]

			WIDOK:
ODŚWIEŻANIE TABELI			[X]
*/

function ajaxInit(){
	var XHR = null;
	
	try{
		XHR = new XMLHttpRequest();
	}
	catch(ex){
		try{
			XHR = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(ex2){
			try{
				XHR = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(ex3){
				alert("Twoja przeglądarka nie obsługuje AJAXa");
			}
		}
	}
	
	return XHR;
	
}


function addData(key){
	var XHR = ajaxInit();
	var query, val;
	
	if(XHR != null){
		
		do{
			val=prompt("Podaj wartość do dodania","");
		}while(val==null)
			
		if(val == null) return null;
		
		if(parseInt(val) > 9223372036854775807){
			alert("Zbyt duża wartość do dodania");
			return null;
		}
		if(parseInt(val)  < -9223372036854775807){
			alert("Zbyt mała wartość do dodania");
			return null;
		}
		
		query = "key="+key+
				"&value="+val;
		XHR.open("GET", "Ajax/add.php?"+query, false);
		
		XHR.send(null);
		baseLoad();
	}
	
}


function remData(key){
	var XHR = ajaxInit();
	var query;
	
	if(XHR != null){
		
		if(confirm('Czy na pewno chcesz usunąć obiekt wraz z jego dziećmi?')){
			
			query = "key="+key;
			XHR.open("GET", "Ajax/rem.php?"+query, false);
			
			XHR.send(null);
			baseLoad();
		}
		else;
	}
	
}



function modData(key){
	var XHR = ajaxInit();
	var query, val;
	
	if(XHR != null){
		
		val=prompt("Podaj nową wartość dla elementu: ","");
		
		if(parseInt(val)  > 9223372036854775807){
			alert("Zbyt duża wartość do dodania");
			return null;
		}
		if(parseInt(val)  < -9223372036854775807){
			alert("Zbyt mała wartość do dodania");
			return null;
		}
		
			query = "key=" + key +
					"&value=" + val;
			XHR.open("GET", "Ajax/mod.php?"+query, false);
			
			XHR.send(null);
			baseLoad();

	}
	
}


function childSort(key){
	var XHR = ajaxInit();
	var query,type = null;
	
	if(XHR != null){
		
		do{
			type=prompt("Wybierz typ sortowania:\n0: A-Z \n1: Z-A","");
		}while(type<0 || type>1)
		
		if(type == null) return false;
	
		if(confirm('Czy na pewno chcesz sortować dzieci obiektu?')){
			
			query = "key=" + key+
					"&type=" + type; //type: jeśli 1 to molejąco, a jeśli 0 to rosnąco
			XHR.open("GET", "Ajax/sort.php?"+query, false);
			
			XHR.send(null);
			baseLoad();
		}
		else;
	}
	
}


function baseLoad(){
	var XHR = ajaxInit();
	
	if(XHR != null){
		
			XHR.open("GET", "load.php", true);
			
			XHR.onreadystatechange = function(){
				if(XHR.readyState == 4){
				
					if(XHR.status == 200){
						document.getElementById("TS").innerHTML = XHR.responseText;
					}
					else alert("Wystąpił błąd: "+ XHR.status);
				}
			}
				
			
			XHR.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			
			XHR.send(null);
	}
	
}
