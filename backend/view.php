<?php
if(@$_REQUEST['output']=='json') {
    } else {
        ob_start("callback");
    }
    
function callback($buffer)
{
    // replace all the apples with oranges
    $template= file_get_contents(WEB_ROOT. "template.tmpl");

    $search  = array("%%BODY%%" ,"%%PAGETITLE%%"  , '%%SIDEBAR_GADGET%%', '%%MENU_NAV%%' );
    // TODO : SECURITY : UNSET GLOBAL VAR IN THE BEGINNING 
    
    if (isset($GLOBALS['title']))
    {
        $replace = array ($buffer , $GLOBALS['title'] ,  $GLOBALS['sidebar'] ,menu_nav() );
    }else
    {
        $replace = array ($buffer , "code monkey " ,  userSideBar() , menu_nav() );
    }
    return str_replace($search, $replace, $template); 
}
function GuestSideBar()
{
        return showLoginForm(TRUE);
}
function userSideBar($manutitle = "User Menu" , $active)
{
    $activecode = "class=\"active\" " ;
    unset($menu1 , $menu2 , $menu3 , $menu4 , $menu5 ) ;
    switch ($active){
        case "" :
            $menu1 = $activecode ;
            break ;
        case "editcontract" :
            $menu2 = $activecode ;
            break ;
        case "editpref" :
            $menu3 = $activecode ;
            break ;
        case "edituser" :
            $menu4 = $activecode ;
            break ;
        case "draft" :
            $menu5 = $activecode ;
            break ;
        case "library" :
            $menu6 = $activecode ;
            break ;
        case "logout" :
            $menu7 = $activecode ;
            break ;

    }
    $sidebar = "
              <div class=\"gadget\">
                <h2 class=\"star\"><span>User </span> Menu</h2>
                <div class=\"clr\"></div>
                <ul class=\"sb_menu\">"
                .returnLink("New ride" , createURL("rides", "new") , "listitem") 
                .returnLink("Search ride" , createURL("rides" , "search" ), "listitem")  
                .returnLink("My rides" , createURL("rides" , "list"  ), "listitem")  
                .returnLink("Edit user" , createURL( "user", "edituser"), "listitem") 
                .returnLink("Logout" , createURL("visitors", "logout"), "listitem") 
                . "</ul></div>";
    return $sidebar;
}


function menu_nav($active)
{
    $activecode = "class=\"active\" " ;
    unset($menu1 , $menu2 , $menu3 , $menu4 , $menu5, $menu6, $menu7 ) ;
    switch ($active){
        case "home" :
            $menu1 = $activecode ;
            break ;
        case "aboutus" :
            $menu2 = $activecode ;
            break ;
        case "contact" :
            $menu3 = $activecode ;
            break ;
        case "services" :
            $menu4 = $activecode ;
            break ;
        case "help" :
            $menu5 = $activecode ;
            break ;
        case "registration" :
            $menu6 = $activecode ;
            break ;
        case "user" :
            $menu7 = $activecode ;
            break ;
            
            
    }
    $menu_nav = "
     
           <div class=\"menu_nav\">
              <ul>"
                .returnLink("Home" , BASE_URL , "listitem") 
                .returnLink("About us" , createURL("static", "aboutus") , "listitem") 
                .returnLink("Contact" , createURL("static", "contact") , "listitem") 
                .returnLink("Services" , createURL( "static", "services"), "listitem") 
                .returnLink("How it works" , createURL("static" , "help" ), "listitem")  
                .returnLink("Sign Up" , createURL("visitors", "registration"), "listitem") 
                .returnLink("User area" , createURL("user"), "listitem") 
                
               ."</ul>
              </div>";
           
    return $menu_nav;
}


        