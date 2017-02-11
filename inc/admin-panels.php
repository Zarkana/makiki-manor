<?php	
// Create panels for specific pages

switch($page){
	case "index.php":
		make_panel("Change Banner Photo", "main-photo-edit", "#main-photo", null, null);
		break;
	case "about.php":
		make_panel("Edit Section", "edit-section-learn", "#learn-paragraph", null, "page-panel");
		make_panel("Edit Section", "edit-section-location", "#location-paragraph", null, "page-panel");
		make_panel("Edit Section", "edit-section-parking", "#parking-paragraph", null, "page-panel");
		break;
	case "forms.php":		
		make_panel("Edit Forms", "edit-section-forms-about", "#forms-about", null, "page-panel");
		make_panel("Upload New Form", "add-form-file", "#faux-target", null, null);
		break;
	case "documents.php":
		make_panel("Edit Documents", "edit-section-documents-about", "#documents-about", null, "page-panel");
		make_panel("Upload New Document", "add-document-file", "#faux-target", null, null);
		break;
	case "owner-rules.php":
		make_panel("Edit Owner Rules", "edit-section-owner-rules-about", "#owner-rules-about", null, "page-panel");
		make_panel("Upload New Owner Rule", "add-owner-rule-file", "#faux-target", null, null);
		break;
	case "contact.php":
		make_panel("Edit Section", "edit-section-board", "#board-paragraph", null, "page-panel");
		make_panel("Edit Section", "edit-section-get-in-touch", "#get-in-touch-paragraph", null, "page-panel");
		break;
	case "gallery.php":
		make_panel("Add Photo", "add-photo", "#gallery", null, null);
		break;
}

// Create panels for every page
make_panel("Settings", "main-settings", null, null, "page-panel");

/*Open announcements main panel*/
if(isset($_GET["ann"])){
	make_panel("Announcements", "main-announcements", null, "appear", "page-panel");
}else{
	make_panel("Announcements", "main-announcements", null, null, "page-panel");
}

/*Open user main panel*/
if(isset($_GET["user"])){
	make_panel("Users", "main-user", null, "appear", "page-panel");
}else{
	make_panel("Users", "main-user", null, null, "page-panel");
}

/*USERS*/

if(isset($_GET["edit_user"])){
	make_panel("Edit User", "edit-user", null, "appear", "page-panel");
}else if(isset($_GET["user_edit_confirmation"])){
	make_panel("Database Confirmation", "confirmation-user-edit", null, "appear", null);
}

if(isset($_GET["add_user"]) && !isset($_GET["user_add_confirmation"])){
	make_panel("Add User", "add-user", null, "appear", "page-panel");
}else if(isset($_GET["user_add_confirmation"])){
	make_panel("Database Confirmation", "confirmation-user-add", null, "appear", null);
}

/*ANNOUNCEMENTS*/

if(isset($_GET["edit_ann"])){
	make_panel("Edit Announcement", "edit-ann", null, "appear", "page-panel");
}

if(isset($_GET["add_ann"])){
	make_panel("Add Announcement", "add-ann", null, "appear", "page-panel");
}

/*TODO: not called correctly*/
if(isset($_GET["action"]) && $_GET["action"] == "deleted"){
	make_panel("Deletion Confirmation", "confirmation-user-delete", null, "appear", null);
}


?>
