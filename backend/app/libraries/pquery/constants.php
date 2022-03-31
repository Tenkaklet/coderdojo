<?php 
	/*Security*/
	define('AES_SECRET', 'ow9WxFe_4QEuQuy8Y8CMzhuzDSQHn66[');
    define('DOMAIN', 'api.quicklytorsby.se');

    define('APPLICATION_BASE', __DIR__ . DIRECTORY_SEPARATOR);

	/*Error Codes*/
	define('DBCONNECT_PROFILE_NOT_FOUND',		        100);
    define('DBCONNECT_CONNECTION_ERROR',		        101);
    define('CONFIG_INI_NOT_FOUND',		                102);
    define('WRONG_DATA_TYPE',       		            103);
    define('MISSING_DATA',                              104);
	define('NO_DATA_FOUND',                             105);

	define('SUCCESS_RESPONSE', 						200);
	define('INTERNAL_ERROR',		                500);

	/*Server Errors*/

	define('JWT_PROCESSING_ERROR',					300);
	define('ATHORIZATION_HEADER_NOT_FOUND',			301);
	define('ACCESS_TOKEN_ERRORS',					302);
	define('REFRESH_TOKEN_ERRORS',					303);	
?>