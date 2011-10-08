<?php

function createDateTime($dateString, $hour, $minute) {
    if (trim($dateString) == '') {
        return null;
    } else {
        $timeString = $dateString.' '.$hour.':'.$minute;
        return date('Y-m-d H:i:s', strtotime($timeString));
    }
}

function redirectHomePagePANIC(){
    redirect ( BASE_URL);
    die ;
}
/*
function redirect ($section , $formname, $text, $delay = 4000){
    $url = createURL($section , $formname)  ;  
        if (isset($text)){
                JSHTMLredirect (  $url ,  $text  ,$delay) ;
            } else {
                header("Location: " . $url );
            }
    die ;
}
*/

function redirect ($url, $text, $delay = 4000, $type= "error"){
        if (isset($text)){
                JSHTMLredirect (  $url ,  $text  ,$delay, $type) ;
            } else {
                header("Location: " . $url );
            }
    die ;
}

function createThumbnail($imagefile){
    define("MAX_SIZE" , 200) ;
    $image = new SimpleImage();
    $image->load($imagefile);

    list($width, $height, $type, $attr) = getimagesize($imagefile);
    if ($width > $height) {
                $image->resizeToWidth(MAX_SIZE);
        } else {
                $image->resizeToHeight(MAX_SIZE);
        }
    $temp = tempnam(TMP_PATH_ABSOLUTE, "TMPIMG");
    $image->save($temp);
    return $temp ;
}

function HtmlImage($src, $alt= "image" ) {
    return "<img src=\"$src\" alt=\"$alt\"  />" ; 
}

function JSHTMLredirect($url, $text, $delay = 4000, $type = "error") {
// $type  can be info, error , success, warning 
?>
<html>
<head>
<script type="text/javascript">
function delayer(){
    window.location = "<?php echo $url ; ?>"
}
</script>
<style type="text/css">
body{
    font-family:Arial, Helvetica, sans-serif; 
    font-size:13px;
}
.info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
}
.info {
    color: #00529B;
    background-color: #BDE5F8;
    background-image: url('/images/icons/info.png');
}
.success {
    color: #4F8A10;
    background-color: #DFF2BF;
    background-image:url('/images/icons/success.png');
}
.warning {
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('/images/icons/warning.png');
}
.error {
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('/images/icons/error.png');
}
</style>
</head>
<body onLoad="setTimeout('delayer()', <?php echo $delay ; ?>)"> 
<div class="<?php echo $type ?>"><?php echo $text ; ?></div>
Prepare to be redirected!, if you are not rediercted after a few second, click on the this : <a href="<?php echo $url ; ?>"  > LINK </a>
</body>
</html>
<?
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


function generateSalt($length = 10) {
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$return = '';
	if ($length > 0) {
		$totalChars = strlen($characters) - 1;
		for ($i = 0; $i <= $length; ++$i) {
			$return .= $characters[rand(0, $totalChars)];
			}
	}
	return $return;
}

function formProcessPath($formName) {
    return BASE_URL.'process/'.$formName ;
}

function formProcessPathwithID($formName , $id) {
    return BASE_URL.'process/'.$formName. '/' . $id  ;
}

function createURL()
{
    $path = '' ;
    $numargs = func_num_args();
    $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
        $path .= $arg_list[$i] . "/" ;
        }
    return substr(BASE_URL . $path,0,-1) ; // remove the last '/' in the string 
}

function createLink($text , $link ,  $type = "normal" )
{
    echo returnLink($text , $link , $type  )  ;
}


function returnLink($text , $link ,   $type  = "normal"   ) 
{
    if ($type == "normal") 
    {
        return "<a href=\"$link\">$text</a>";
    }elseif ($type== "listitemActive" ) 
    {
        return "<li class=\"active\"><a href=\"$link\">$text</a></li>";
    }elseif ($type== "listitem" ) 
    {
        return "<li><a href=\"$link\">$text</a></li>" ;
    }
}

function checkValidSessionAndDIE(){
    if (!checkValidSession()) {
        redirect (createURL("user"),  "your session is not valid" , 4000);
        die ;
        }else  return true  ;
}
    
function checkValidSession(){
    $_SESSION['userID'] =  1 ;
    return (isset($_SESSION['userID'])  && $_SESSION['userID'] > 0) ; 
}
# EOF