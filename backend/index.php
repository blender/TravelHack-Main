<?php
require_once("view.php");
require_once("config.php");
require_once("functions.php");

include("visitor.php");


if (checkValidSession())
{
    $GLOBALS['sidebar'] = userSideBar("User Menu","Nothing") ; 
    if (isset($_REQUEST['page'])) 
    {
        $name = basename($_REQUEST['page']);
         if (file_exists(WEB_ROOT.STATIC_FILES.$name.".html"))
        {
            echo (file_get_contents(WEB_ROOT.STATIC_FILES.$name.".html")) ;
        }
    } else
    {
            echo ("<B>You are logged in as ".$_SESSION['info']['loginname'] . "</B>") ; 
            
            // wanna create a new contract from scratch.
            include "func.php" ;
            FormNew();
            // show folders
    }
} else {
        if (isset($_REQUEST['page']))
        {
            $name = basename($_REQUEST['page']);
        }else
        {
            $name="index";
        }
         if (file_exists(WEB_ROOT.STATIC_FILES.$name.".html"))
        {
            echo (file_get_contents(WEB_ROOT.STATIC_FILES.$name.".html")) ;
        }
        $GLOBALS['title'] = "Welcome to kontrak.se" ;
         $GLOBALS['sidebar'] = GuestSideBar(TRUE) . 
                "<div class=\"gadget\">
                <div class=\"clr\"></div>
                <ul class=\"sb_menu\">" 
                .returnLink("Forgot your password?" , createURL("visitors", "forgetpassword"), "listitemActive") 
                .returnLink("Register an account" , createURL("visitors", "registration"), "listitemActive") 
                . "</ul></div>";
}
# EOF