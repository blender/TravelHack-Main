<?php
require_once("config.php");
require_once("functions.php");
include_once('db/mysqldatabase.php');
include_once('db/mysqlresultset.php');

$db = MySqlDatabase::getInstance();
try {
    $conn = $db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
} 
catch (Exception $exception) {
    // TODO : remove user alert it for production server. (or save it on log files
    die($exception->getMessage());
}

error_reporting(E_ALL);

//testcases 
//RegisterUser('hamid', 'hanmid' , 'asddasd');
//echo UpdateUserByLoginName('hamid' ,  array('email'  => 'xxxxx', 'password' => 'two') ) ;
//var_dump( Authenticate('hanxmid', 'asddasd') );
//var_dump(GetUserInfoById(1));
//var_dump(GetUserIdbyLoginName("hamid"));

function newride($fromlang, $fromlat, $tolang, $tolat, $fromtime, $totime)
{
    global $db ; 
    $query = "INSERT INTO ride (fromlang, fromlat, tolang, tolat, fromtime, totime ) VALUES ($fromlang, $fromlat, $tolang, $tolat, '$fromtime', '$totime') " ;
	$db->insert($query);
}

function searchride($fromlang, $fromlat, $tolang, $tolat, $fromtime, $totime)
{
    global $db ; 
    foreach ($db->iterate("SELECT  *   FROM   ride  " , MySqlResultSet::DATA_ASSOCIATIVE_ARRAY) as $row) {
        $list[]  = $row;
    }
    return $list;
}


 // remove the pesky slashes from magic quotes if it's turned on
function clean_string( $value)
{
    if ( get_magic_quotes_gpc() )
    {
        $value = stripslashes( $value );
    }
    // escape things properly
    return mysql_real_escape_string( $value );
}

/**
 * Authenticate a user 
 * 
 * Using the formula from "Formulas that are way too complicated for anyone to
 * ever understand except for me" by Irwin Nerdy, this function calculates the
 * date of Easter given a date in the Ancient Mayan Calendar, if you can also
 * guess the birthday of the author.
 * @param string 
 * @return 
 * @example 
 */

function authenticate($username_or_email, $password)
{
    global $db;
    // TODO check input
    $query= "SELECT id,loginname,email,password,salt
                    FROM users
                    where  isactive=1 and  (loginname= '$username_or_email'  or   email= '$username_or_email' ) ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ASSOCIATIVE_ARRAY);
    //var_dump($row);
    return 1 ;
    if (isset($row['id'] ))
    {
        if ($row['password']== sha1($row['salt'].$password) )
        { 
            return $row['id'] ;
        } else 
        {
            return false ;
        }
    }
    else 
    {
        return false ;
    }
}


function joinride($uid , $rideid) 
{
    global $db ; 
    $query = "INSERT INTO users_has_ride (users_id, ride_rideid) VALUES ($uid , $rideid) " ;
    echo $query ;
	$db->insert($query);
}


function checkAccess($doc_id, $user_id) 
{
    global $db ;
    if ($doc_id < 0  ) return true ;
    $adminuid = ADMIN_UID; 
    $count = $db->fetchOne("SELECT COUNT(*) FROM document where (users_id= $user_id or users_id= $adminuid )and id = $doc_id and  isactive = 1 ");
    if ( $count > 0 ) return true ;
    return false ;
}

function DocExist($docid)
{
    global $db ;
    if ($docid < 0  ) return false ; 
    $count = $db->fetchOne("SELECT COUNT(*) FROM document where id = $docid and  isactive = 1  ");
    if ( $count > 0 ) return true ;
    return false ;
}
function checkAccessPANIC($docid, $userid) {
    if (!checkAccess($docid, $userid)) {
        redirectHomePagePANIC() ;
    }
}
function GetPrefInfoById($uid){
    global $db ;
    $query = "SELECT 
                                    language, 
                                    companyname, 
                                    font, 
                                    header, 
                                    footer, 
                                    rightmargin, 
                                    leftmargin, 
                                    topmargin, 
                                    headermargin,  
                                    footermargin, 
                                    template, 
                                    author
                                                    FROM preferences where users_id= '$uid'  ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ASSOCIATIVE_ARRAY);
    return $row ;
}

function GetUserInfoById($uid){
    global $db ;
    $query = "SELECT * FROM users where id= '$uid'  and isactive= 1 ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ASSOCIATIVE_ARRAY);
    return $row ;
}
function UpdateUserPerferences($uid, $logo, $data){
    // TODO : check if logo file is uploaded otherwise we will remove the overwrite the old files
    
    global $db ;
    $query = "UPDATE  preferences  SET                 language     =    '$data[language]' ,
                                                                                font = '$data[font]' ,
                                                                                companyname = '$data[companyname]' ,
                                                                                header = '$data[header]' ,
                                                                                footer = '$data[footer]' ,
                                                                                rightmargin = '$data[rightmargin]' ,
                                                                                leftmargin = '$data[leftmargin]' ,
                                                                                topmargin = '$data[topmargin]' ,
                                                                                headermargin = '$data[headermargin]' ,
                                                                                footermargin = '$data[footermargin]' ,
                                                                                template = '$data[template]' ," .
                                                                                "logo = '" . mysql_real_escape_string(file_get_contents($logo) ). "'  WHERE users_id = $uid  " ; 
    if ($db->update($query) > 0 ) return true  ;
}
// TODO : split the upload logo from user preferences form 


 

function GetUserIdbyLoginName($LoginName){
    global $db ;
    $query = "SELECT id FROM users where loginname= '$LoginName' ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ASSOCIATIVE_ARRAY);
    return $row['id'] ;
}

function GetUserIdbyEmail($Email){
    global $db ;
    $query = "SELECT id FROM users where email= '$Email' ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ARRAY);
    return $row['id'] ;
}


function GetUserIdbyEmailORLoginName($user){
    global $db ;
    $query = "SELECT id FROM users where email= '$user' or loginname= '$user'  ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ARRAY);
    return $row['id'] ;
}


function RegisterUser($LoginName, $Email, $Password){
	// TODO check inputs 
    global $db ;
	$salt = generateSalt(10);
	$hash= sha1($salt.$Password) ;
	// get auto increment value
	$query = "INSERT INTO users (loginname, email, password, salt, isactive ) VALUES ('$LoginName', '$Email', '$hash', '$salt', 1)";
	$uid = $db->insert($query);
	// TODO    
    // InitializeUserPreferences();
    // initializing some database fields and filesystem directories 
    return $uid;
}


function PasswordResetByEmailORLoginName($user){
    global $db ;
    $query = "SELECT password FROM users where email = '$user'  or loginname= '$user' ";
    $row = $db->fetchOneRow($query, MySqlResultSet::DATA_ARRAY);
    return $row['password'] ;
}


function UpdateUserById($uid, $data){
    global $db ;
    if (isset($data['password'])){
        $salt = generateSalt(10);
        $data['password']= sha1($salt.$data['password']) ;
        $data['salt'] = $salt;
    }
    $query = mysql_update_array('users', $data, 'id', $uid);
    $affected_id = $db->update($query);
}


// helper function
function mysql_update_array($table, $data, $id_field, $id_value) {
	foreach ($data as $field=>$value) {
		$fields[] = sprintf("`%s` = '%s'", $field, mysql_real_escape_string($value));
	}
	$field_list = join(',', $fields);
	
	$query = sprintf("UPDATE `%s` SET %s WHERE `%s` = %s", $table, $field_list, $id_field, intval($id_value));
	
	return $query;
}

function sendResetInformationToEmail($hash){
    $hash= PasswordResetByEmailORLoginName ($_POST["emailORLoginname"]) ; 
    sendResetInformationToEmail($hash) ;
}
# EOF