<?php
// TODO check session start for errors
session_start();
error_reporting(0);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'uhJMBsAyms6XnbS6EJDPeGKbA');
define('DB_DATABASE', 'travel' );
define('BASE_URL', 'http://localhost/' );
define ('ITEM_PER_PAGE', 5 ) ;
define ('WEB_ROOT', '/var/www/' ) ;
define ('DOC_TMP', '/var/www/tmp/' ) ;
define('ADMIN_UID' , 1 ) ;
define ('STATIC_FILES', 'staticpages/' ) ;

define ('TMP_PATH_ABSOLUTE', 'WEB_ROOT'.'tmp') ;

# EOF
