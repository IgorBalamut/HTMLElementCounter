 <?php 
if($_SERVER['SERVER_ADDR']=="1.1.1.1"){
	define('HOST','localhost');
	define('DB_USER', 'project_user');
	define('DB_PASSWORD','project1');
	define('DB_NAME','project');
} else {
	define('HOST','localhost');
	define('DB_USER', 'project_user');
	define('DB_PASSWORD','project1');
	define('DB_NAME','project');
}