<?php
require_once("config.php");
require_once("functions.php");
include("databaseoperation.php");
include("PFBC/Form.php");

// TODO : check referrer and hacking attempts 

//if(isset($_REQUEST["form"])) {
    //if(PFBC\Form::isValid($_REQUEST["form"]))
    {
		if ($_REQUEST["form"] == 'registration') {
            $uid= RegisterUser($_POST["LoginName"], $_POST["Email"], $_POST["Password"]) ;
            redirect (createURL("user" ),  "Your account is successfully created" , 3000, "success");
			//authenticate and register User on the system automatically 
            // TODO : send welcome message
		} elseif ($_REQUEST["form"] == 'forgetpassword') {
            sendResetInformationToEmail($_POST["emailORLoginname"]) ;
			//send the password to the email
		} elseif ($_REQUEST["form"] == 'login') {
			//check authentiation 
            $uid = authenticate($_POST["emailORLoginname"], $_POST["Password"]);
            if ($uid > 0){
                $_SESSION['userID'] = $uid ;
                $_SESSION['info'] = GetUserInfoById($uid); 
                // Remove the salt and password from session
                $_SESSION['info']['password'] = ''; 
                $_SESSION['info']['salt'] = ''; 

                redirectHomePagePANIC();
                }else {
                unset($_SESSION['loggedinID']) ; 
                redirect (createURL("visitors" , "login") ,  "The user name or password is incorrect, Please check them and try again" , 3000, "error");
                }
		} elseif ( checkValidSessionAndDIE()  and $_REQUEST["form"] == 'edituser') {
            if(!Authenticate($_SESSION['info'] ['loginname'], $_POST['OldPassword'] )){
                    redirect (createURL("visitors" , "login") ,  "Your old password is incorrect, Please check it and try again" , 3000, "error");
                } else {
                    UpdateUserById($_SESSION['userID'], 
                        array(
                            "email" => $_POST["email"] ,
                            "fname" => $_POST["fname"],
                            "lname" => $_POST["lname"],
                            "password" => $_POST['NewPassword'],
                            )
                    ) ;
                    redirect (createURL("user" ) ,  "Your old password is incorrect, Please check it and try again" , 3000, "error");
                }
        }elseif (checkValidSessionAndDIE() and $_REQUEST["form"] == 'joinride') {
                joinride($_SESSION['userID'] , $_REQUEST['rideid']) ;
                if (@$_REQUEST['output']=='json' ) {
                        echo (json_encode(NULL,JSON_FORCE_OBJECT) );
                        die ;
                    }else {
                        redirect (createURL("user" ),  "Your successfully joined to the ride" , 3000, "success");
                }
            } elseif (checkValidSessionAndDIE() and $_REQUEST["form"] == 'newride') {
                $_REQUEST['fromtime'] = createDateTime ($_REQUEST['fdate'],  $_REQUEST['fhour'],  $_REQUEST['fmin'] );
                $_REQUEST['totime'] = createDateTime($_REQUEST['tdate'],  $_REQUEST['thour'],  $_REQUEST['tmin'] );
                
                newride($_REQUEST['fromlang'], $_REQUEST['fromlat'], $_REQUEST['tolang'], $_REQUEST['tolat'], $_REQUEST['fromtime'], $_REQUEST['totime']) ; 
                if (@$_REQUEST['output']!='json' ) {
                        echo (json_encode(NULL,JSON_FORCE_OBJECT) );
                        die ;
                    }else {
                        redirect (createURL("user" ),  "Your ride is successfully created" , 3000, "success");
                }
            }elseif (checkValidSessionAndDIE() and $_REQUEST["form"] == 'searchride') {
                $_REQUEST['fromtime'] = createDateTime ($_REQUEST['fdate'],  $_REQUEST['fhour'],   $_REQUEST['fmin'] );
                $_REQUEST['totime'] = createDateTime($_REQUEST['tdate'],   $_REQUEST['thour'],  $_REQUEST['tmin'] );
                $ridelist= searchride($_REQUEST['fromlang'], $_REQUEST['fromlat'], $_REQUEST['tolang'], $_REQUEST['tolat'], $_REQUEST['fromtime'], $_REQUEST['totime']) ; 
                if (@$_REQUEST['output']=='json' ) {

                        echo (json_encode($ridelist,JSON_FORCE_OBJECT) );
                        die ;
                    }else {
                    foreach ($ridelist as $ride )
                        {
                            echo " From Longitude: " . $ride["fromlang"]  ; 
                            echo " From Latitude: " . $ride["fromlat"]  ; 
                            echo " Departure time: " . $ride["fromtime"]  ; 
                            echo " To  Longitude: " . $ride["tolang"]  ; 
                            echo " To Latitud: " . $ride["tolat"]  ; 
                            echo " Arrival time: " . $ride["totime"]  ; 
                            
    $form = new PFBC\Form("joinride", 300);
    $form->configure(array(
         "action" => formProcessPath("ride") ,
        ));
        $form->addElement(new PFBC\Element\Hidden("form", "joinride"));
        $form->addElement(new PFBC\Element\Hidden("rideid", $ride['rideid']));
        $form->addElement(new PFBC\Element\Button("join")  );
        $form->render();
                            echo "<BR>"  ;
                        }
                }
            }
        
        
	}
	//else
    {
		/*Validation errors have been found.  We now need to redirect back to the 
		script where your form exists so the errors can be corrected and the form
		re-submitted.*/
        // here redirection is a bit tricky , we have to reditrect to the correct form
        switch ($_POST["form"])
        {
            case 'registration' :
                redirect (createURL("visitors", "registration") ,  "There is problem in processing registration form" , 1000, "error");
                break;
            case 'forgetpassword' :
                redirect (createURL("visitors", "forgetpassword") ,  "There is problem in processing inputs for forget password form" , 1000, "error");
                break;
            case 'edituser' :
                redirect (createURL("user", "edituser") ,  "There is problem in processing inputs for edit user form" , 1000, "error");
                break;
            case 'login' :
                redirect (createURL("user", "login") ,  "There is problem in processing inputs for login form" , 1000, "error");
                break;
            case 'document' :
                redirect (createURL("document", "lists", "drafts") ,  "There is problem in processing registration form" , 1000, "error");
                break;
            case 'operation' :
                redirect (createURL("document", "lists", "drafts") ,  "There is problem in processing input for specified operation" , 1000, "error");
                break;
                
        }

	}
//}
        
# EOF