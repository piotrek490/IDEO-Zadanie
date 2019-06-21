<?php



function tableVaccine($tableName){
	include 'loadBase.php';
	 
	/*$zapytanie = 	" DELIMITER $$".
						" create trigger ".$tableName."_Vacc before insert on ".$tableName.
						" FOR EACH ROW ".
						" BEGIN ".
						"	if EXISTS (select val from ".$tableName." where val = NEW.val) THEN ".
						"	SIGNAL SQLSTATE '45000' ".
						"	SET MESSAGE_TEXT = 'Nie mozna dodac rekordu'; ".
						" END IF; ".
						" END$$ ";*/
						
		$zapytanie = " DELIMITER //

							 create trigger k0929234192_chck before insert on k0929234192
							 FOR EACH ROW
							 BEGIN
							 if EXISTS (select val from k0929234192 where val = NEW.val) THEN
							 SIGNAL SQLSTATE '45000'
							 SET MESSAGE_TEXT = 'You can not insert record';
							 END IF;
							 END//";
						
						
	$wynik = mysqli_query($polaczenie, $zapytanie);
	
	if(!$wynik){
		echo "Nie mo¿na zaszczepiæ tabeli: ".$zapytanie; exit(1);
	}
}



?>
