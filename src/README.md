# Scanlly
Web App:
Frontend steps:
-	Create new angular project:
Ng new scanlly
-	Create new component category
Ng g c category
-	Create providers folder
Mkdir providers
-	Create postProvider service:
Ng g s post-provider
Import HttpClient, Observable
-	Set the connection to the backend APIs through post-provider service
-	Receive data in category component using post-provider
-	Create food-menu component 
Ng g c food-menu
-	Create routing module 
Ng g m app-routing --flat –module=app
-	Import all components to app-routing module, RouterModule, and Routes 
-	Create constant routes type of Routes, and add paths into it
-	Using the method forRoots in the import array
-	Export the RouterModule
-	Add angular material to the app:
o	Ng add @angular/material
o	Ng g m material
o	Import modules to it
o	Create const materialComponent and add each added module to it 
o	Add the const to the import, export array
o	Import material module in the app module 
o	Add it to the import array
o	Create custom dialog component 
Ng g c dialog-temp
o	In food menu:
	Import MatDialog service 
	Inject it in the constructor 
	Make openDialog function to open the dialog on a specific event
-	Create food-details component 
ng g c food-details
-	Add food-details to routing module


