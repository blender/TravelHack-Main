<?php
require_once("view.php");
require_once("config.php");
require_once("functions.php");
require_once("PFBC/Form.php");
require_once("databaseoperation.php");


checkValidSessionAndDIE() ;
if (isset($_REQUEST['action'] ) and $_REQUEST['action'] == 'new') {
    FormNew();  // zero means Empty document
}elseif (isset($_REQUEST['action'] ) and $_REQUEST['action'] == 'search') {
    FormSearch(); 
}


function FormNew( $fromlang=0, $fromlat=0, $tolang=0, $tolat=0 , $fromtime= 0 , $totime=0)
{

    $form = new PFBC\Form("newride", 300);
    $form->configure(array(
         "action" => formProcessPath("ride") ,
        "view" => new PFBC\View\Grid(array(2, 3, 2,3)),
        ));
        

    $form->addElement(new PFBC\Element\Hidden("form", "newride"));
    
        $form->addElement(new PFBC\Element\Textbox("From langtitute", "fromlang", array(
        "required" => 1,
        "value" => $fromlang
        )));
        
        $form->addElement(new PFBC\Element\Textbox("From latitude", "fromlat", array(
        "required" => 1,
        "value" => $fromlat
        )));
    $form->addElement(new PFBC\Element\Date("Departure Date", "fdate", array(
        "required" => 1,
        )));
    $form->addElement(new PFBC\Element\Select("Hour", "fhour",  range(1, 24)));
    $form->addElement(new PFBC\Element\Select("Minute", "fmin",  range(1, 59)));


        
        /*
        $form->addElement(new PFBC\Element\Textbox("From time", "fromtime", array(
        "required" => 1,
        "value" => $fromtime
        )));
        */
        $form->addElement(new PFBC\Element\Textbox("From langtitute", "tolang", array(
        "required" => 1,
        "value" => $tolang
        )));     
        $form->addElement(new PFBC\Element\Textbox("From latitude", "tolat", array(
        "required" => 1,
        "value" => $tolat
        )));

        $form->addElement(new PFBC\Element\Date("Arrival Date", "tdate", array(
            "required" => 1,
            )));
        $form->addElement(new PFBC\Element\Select("Hour", "thour",  range(1, 24)));
        $form->addElement(new PFBC\Element\Select("Minute", "tmin",  range(1, 59)));


            
        /*
        $form->addElement(new PFBC\Element\Textbox("to time", "totime", array(
        "required" => 1,
        "value" => $totime
        )));     
        */
        


    $form->addElement(new PFBC\Element\Button("Save")  );
    $form->render();
}


function FormSearch( $fromlang=0, $fromlat=0, $tolang=0, $tolat=0 , $fromtime= 0 , $totime=0)
{

    $form = new PFBC\Form("searchride", 300);
    $form->configure(array(
         "action" => formProcessPath("ride") ,
        "view" => new PFBC\View\Grid(array(2, 3, 2,3)),
        ));
        

    $form->addElement(new PFBC\Element\Hidden("form", "searchride"));
    
        $form->addElement(new PFBC\Element\Textbox("From langtitute", "fromlang", array(
        "required" => 1,
        "value" => $fromlang
        )));
        
        $form->addElement(new PFBC\Element\Textbox("From latitude", "fromlat", array(
        "required" => 1,
        "value" => $fromlat
        )));
    $form->addElement(new PFBC\Element\Date("Departure Date", "fdate", array(
        "required" => 1,

        )));
    $form->addElement(new PFBC\Element\Select("Hour", "fhour",  range(1, 24)));
    $form->addElement(new PFBC\Element\Select("Minute", "fmin",  range(1, 59)));


        
        /*
        $form->addElement(new PFBC\Element\Textbox("From time", "fromtime", array(
        "required" => 1,
        "value" => $fromtime
        )));
        */
        $form->addElement(new PFBC\Element\Textbox("From langtitute", "tolang", array(
        "required" => 1,
        "value" => $tolang
        )));     
        $form->addElement(new PFBC\Element\Textbox("From latitude", "tolat", array(
        "required" => 1,
        "value" => $tolat
        )));

        $form->addElement(new PFBC\Element\Date("Arrival Date", "tdate", array(
            "required" => 1,
            )));
        $form->addElement(new PFBC\Element\Select("Hour", "thour",  range(1, 24)));
        $form->addElement(new PFBC\Element\Select("Minute", "tmin",  range(1, 59)));


            
        /*
        $form->addElement(new PFBC\Element\Textbox("to time", "totime", array(
        "required" => 1,
        "value" => $totime
        )));     
        */
        

    $form->addElement(new PFBC\Element\Button("Save")  );
    $form->render();
}




/*        
    $form->addElement(new PFBC\Element\Date("Departure Date", "ddate", array(
        "required" => 1,
        "value" => $ddate
        )));
        

    $form->addElement(new PFBC\Element\Select("Hour", "dhour",  range(1, 24)));
    $form->addElement(new PFBC\Element\Select("Minute", "dmin",  range(1, 59)));

    $form->addElement(new PFBC\Element\Date("Arrival Date", "adate", array(
        "required" => 1,
        "value" => $ddate
        )));
        

    $form->addElement(new PFBC\Element\Select("Hour", "ahour",  range(1, 24)));
    $form->addElement(new PFBC\Element\Select("Minute", "amin",  range(1, 59)));
       
*/
# EOF