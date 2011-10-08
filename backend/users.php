<?php
require_once("view.php");
require_once("config.php");
require_once("functions.php");
require_once("PFBC/Form.php");
require_once("databaseoperation.php");


if (!checkValidSession()){
        redirectHomePagePANIC();
} else {
        if  ($_REQUEST['action'] == 'edituser' ) {
            $uinfo= GetUserInfobyId( $_SESSION['userID']); 
            showEditUserForm($uinfo);
        } elseif ($_REQUEST['action'] == 'editpref' )  {
            $preference_Info= GetPrefInfobyId( $_SESSION['userID']);
            showUserPrefForm($preference_Info);
        } elseif($_REQUEST['action'] == 'logo') {
            GetLogo($_SESSION['userID']);
        }
}
 

 




function showEditUserForm($uinfo){
	$form = new PFBC\Form("edituser", 400);
    $form->configure(array(
     "action" => formProcessPath("edituser") ,
    )); 
	$form->addElement(new PFBC\Element\Hidden("form", "edituser"));
	$form->addElement(new PFBC\Element\Textbox("Email:", "email", array(
        "value" => $uinfo['email'] ,
        "required" => 1,
		"validation" => array(
			new PFBC\Validation\Required,
			new PFBC\Validation\Email
		),
		"description" => "Valid E-mail please, you will need it to log in!"
	)));

	$form->addElement(new PFBC\Element\Textbox("First name:", "fname", array(
        "value" => $uinfo['fname'] ,
        "required" => 1,
		"description" => "Your first name "
	)));
    
    $form->addElement(new PFBC\Element\Textbox("Last name:", "lname", array(
        "value" => $uinfo['lname'] ,
        "required" => 1,
		"description" => "Your last name "
	)));

	$form->addElement(new PFBC\Element\Password("Old Password:", "OldPassword", array(
        "required" => 1,
		"description" => "to change user settings please enter your old password"
	)));

	$form->addElement(new PFBC\Element\Password("New Password:", "NewPassword", array(
        "required" => 1,
		"description" => "If you want to change your current password fill in this section"
	)));

$form->addElement(new PFBC\Element\Button("Update settings"));
	$form->render();
}
# EOF