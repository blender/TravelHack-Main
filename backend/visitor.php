<?php
require_once("view.php");
require_once("config.php");
require_once("functions.php");
require_once("PFBC/Form.php");
require_once("databaseoperation.php");


if (isset($_REQUEST['action'])){
    if ($_REQUEST['action'] == 'registration') {
        showRegistrationForm();
    }elseif ($_REQUEST['action'] == 'forgetpassword') { 
        showFogetPasswordForm();
    }elseif ($_REQUEST['action'] == 'login') { 
        showLoginForm();
    }elseif ($_REQUEST['action'] == 'logout') { 
        session_destroy();
        redirectHomePagePANIC();
    }
}


function showRegistrationForm(){
	$form = new PFBC\Form("registration", 400);
    $form->configure(array(
     "action" => formProcessPath("registration") ,
    )); 
	$form->addElement(new PFBC\Element\Hidden("form", "registration"));
	$form->addElement(new PFBC\Element\Textbox("Email:", "Email", array(
		"validation" => array(
			new PFBC\Validation\Required,
			new PFBC\Validation\Email
		),
		"description" => "Valid E-mail please, you will need it to log in!"
	)));

	$form->addElement(new PFBC\Element\Textbox("Login name:", "LoginName", array(
		"validation" => array(
			new PFBC\Validation\Required,
			new PFBC\Validation\AlphaNumeric
		),
		"description" => "Choose a login name. Alphabet, numbers"
	)));

	$form->addElement(new PFBC\Element\Password("Password:", "Password", array(
        "required" => 1,
		"description" => "Choose a secure password. At least 5 characters: letters, numbers"
	)));
	$options = array("I have read and accept the Terms of Use");
	//$form->addElement(new PFBC\Element\Captcha("Captcha:"));
	$form->addElement(new PFBC\Element\Checkbox(returnLink("Term Of Use" , createURL("static", "term")) , "Checkbox", $options, array(
        "required" => 1,
		"description" => "Read the term of use carefully "
	)));

	$form->addElement(new PFBC\Element\Button("Register"));
	$form->render();
}

function showForgetPasswordForm(){
	$form = new PFBC\Form("forgetpassword", 400);
    $form->configure(array(
     "action" => formProcessPath("forgetpassword") ,
    )); 
	$form->addElement(new PFBC\Element\Hidden("form", "forgetpassword"));
	$form->addElement(new PFBC\Element\Textbox("Email / Login name:", "emailORLoginname", array(
        "required" => 1,
		"description" => "Your email address or your login name"
	)));

	//$form->addElement(new PFBC\Element\Captcha("Captcha:"));

	$form->addElement(new PFBC\Element\Button("Send"));
	$form->render();
}

function showLoginForm($returnHtml= FALSE){

	$form = new PFBC\Form("login", 200);
    $form->configure(array(
     "action" => formProcessPath("login") ,
    )); 
	$form->addElement(new PFBC\Element\Hidden("form", "login"));
	$form->addElement(new PFBC\Element\Textbox("Email / Login name:", "emailORLoginname", array(
        "required" => 1,
		"description" => "Your email address or your login name"
	)));

	$form->addElement(new PFBC\Element\Password("Password:", "Password", array(
        "required" => 1,
	)));

	$form->addElement(new PFBC\Element\Button("Login"));
    if ($returnHtml) {
        return $form->render(TRUE);
        }
	$form->render();

}
# EOF
