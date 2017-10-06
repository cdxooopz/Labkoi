<?php 
// Require the person class file
	require("../init.php");
   require(MODEL . DS . "menu.php");
	
// Instantiate the person class
   $person  = new Person();

/*
// Create new person
   $person->Firstname = "Kona";
   $person->Age  = "20";
   $person->Sex = "F";
   $creation = $person->Create();

// Update Person Info
   $person->id = "4";	
   $person->Age = "32";
   $saved = $person->Save(); 
*/

// Find person
   $person->menu_id = "1";		
   $person->Find();

   d($person, "Person->menu_component");

/*
// Delete person
   $person->id = "1";	
   $delete = $person->Delete();
*/

 // Get all persons
   $persons = $person->all();  

   // Aggregates methods 
   d($person->max('menu_sort'), "Max person age");
   d($person->min('menu_sort'), "Min person age");
   d($person->sum('menu_sort'), "Sum persons age");
   d($person->avg('menu_sort'), "Average persons age");
   d($person->count('menu_id'), "Count persons");
   d($person, "menu");


?>
