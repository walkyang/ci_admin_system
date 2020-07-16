<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'data_dataface';
$active_record = TRUE;

$db['data_dataface']['hostname'] = '47.99.117.126';
$db['data_dataface']['username'] = 'root';
$db['data_dataface']['password'] = 'dataface!q1';
$db['data_dataface']['database'] = 'dataface_data';
$db['data_dataface']['dbdriver'] = 'mysqli';
$db['data_dataface']['dbprefix'] = '';
$db['data_dataface']['pconnect'] = FALSE;
$db['data_dataface']['db_debug'] = TRUE;
$db['data_dataface']['cache_on'] = FALSE;
$db['data_dataface']['cachedir'] = '';
$db['data_dataface']['char_set'] = 'utf8';
$db['data_dataface']['dbcollat'] = 'utf8_general_ci';
$db['data_dataface']['swap_pre'] = '';
$db['data_dataface']['autoinit'] = TRUE;
$db['data_dataface']['stricton'] = FALSE;

$active_group = 'data_sz';
$active_record = TRUE;

$db['data_sz']['hostname'] = '47.99.117.126';
$db['data_sz']['username'] = 'root';
$db['data_sz']['password'] = 'dataface!q1';
$db['data_sz']['database'] = 'dataface_data_sz';
$db['data_sz']['dbdriver'] = 'mysqli';
$db['data_sz']['dbprefix'] = '';
$db['data_sz']['pconnect'] = FALSE;
$db['data_sz']['db_debug'] = TRUE;
$db['data_sz']['cache_on'] = FALSE;
$db['data_sz']['cachedir'] = '';
$db['data_sz']['char_set'] = 'utf8';
$db['data_sz']['dbcollat'] = 'utf8_general_ci';
$db['data_sz']['swap_pre'] = '';
$db['data_sz']['autoinit'] = TRUE;
$db['data_sz']['stricton'] = FALSE;

$active_group = 'data_hz';
$active_record = TRUE;

$db['data_hz']['hostname'] = '61.151.249.247';
$db['data_hz']['username'] = 'ywweb';
$db['data_hz']['password'] = 'yw!@#123';
$db['data_hz']['database'] = 'hw_data_hz';
$db['data_hz']['dbdriver'] = 'mysqli';
$db['data_hz']['dbprefix'] = '';
$db['data_hz']['pconnect'] = FALSE;
$db['data_hz']['db_debug'] = TRUE;
$db['data_hz']['cache_on'] = FALSE;
$db['data_hz']['cachedir'] = '';
$db['data_hz']['char_set'] = 'utf8';
$db['data_hz']['dbcollat'] = 'utf8_general_ci';
$db['data_hz']['swap_pre'] = '';
$db['data_hz']['autoinit'] = TRUE;
$db['data_hz']['stricton'] = FALSE;


$active_group = 'data_sh';
$active_record = TRUE;

$db['data_sh']['hostname'] = '61.151.249.247';
$db['data_sh']['username'] = 'ywweb';
$db['data_sh']['password'] = 'yw!@#123';
$db['data_sh']['database'] = 'hw_data_sh';
$db['data_sh']['dbdriver'] = 'mysqli';
$db['data_sh']['dbprefix'] = '';
$db['data_sh']['pconnect'] = FALSE;
$db['data_sh']['db_debug'] = TRUE;
$db['data_sh']['cache_on'] = FALSE;
$db['data_sh']['cachedir'] = '';
$db['data_sh']['char_set'] = 'utf8';
$db['data_sh']['dbcollat'] = 'utf8_general_ci';
$db['data_sh']['swap_pre'] = '';
$db['data_sh']['autoinit'] = TRUE;
$db['data_sh']['stricton'] = FALSE;


$active_group = 'data_bj';
$active_record = TRUE;

$db['data_bj']['hostname'] = '61.151.249.247';
$db['data_bj']['username'] = 'ywweb';
$db['data_bj']['password'] = 'yw!@#123';
$db['data_bj']['database'] = 'hw_data_bj';
$db['data_bj']['dbdriver'] = 'mysqli';
$db['data_bj']['dbprefix'] = '';
$db['data_bj']['pconnect'] = FALSE;
$db['data_bj']['db_debug'] = TRUE;
$db['data_bj']['cache_on'] = FALSE;
$db['data_bj']['cachedir'] = '';
$db['data_bj']['char_set'] = 'utf8';
$db['data_bj']['dbcollat'] = 'utf8_general_ci';
$db['data_bj']['swap_pre'] = '';
$db['data_bj']['autoinit'] = TRUE;
$db['data_bj']['stricton'] = FALSE;

$active_group = 'data_gz';
$active_record = TRUE;

$db['data_gz']['hostname'] = '61.151.249.247';
$db['data_gz']['username'] = 'ywweb';
$db['data_gz']['password'] = 'yw!@#123';
$db['data_gz']['database'] = 'hw_data_gz';
$db['data_gz']['dbdriver'] = 'mysqli';
$db['data_gz']['dbprefix'] = '';
$db['data_gz']['pconnect'] = FALSE;
$db['data_gz']['db_debug'] = TRUE;
$db['data_gz']['cache_on'] = FALSE;
$db['data_gz']['cachedir'] = '';
$db['data_gz']['char_set'] = 'utf8';
$db['data_gz']['dbcollat'] = 'utf8_general_ci';
$db['data_gz']['swap_pre'] = '';
$db['data_gz']['autoinit'] = TRUE;
$db['data_gz']['stricton'] = FALSE;

$active_group = 'data_suzhou';
$active_record = TRUE;

$db['data_suzhou']['hostname'] = '61.151.249.247';
$db['data_suzhou']['username'] = 'ywweb';
$db['data_suzhou']['password'] = 'yw!@#123';
$db['data_suzhou']['database'] = 'hw_data_suzhou';
$db['data_suzhou']['dbdriver'] = 'mysqli';
$db['data_suzhou']['dbprefix'] = '';
$db['data_suzhou']['pconnect'] = FALSE;
$db['data_suzhou']['db_debug'] = TRUE;
$db['data_suzhou']['cache_on'] = FALSE;
$db['data_suzhou']['cachedir'] = '';
$db['data_suzhou']['char_set'] = 'utf8';
$db['data_suzhou']['dbcollat'] = 'utf8_general_ci';
$db['data_suzhou']['swap_pre'] = '';
$db['data_suzhou']['autoinit'] = TRUE;
$db['data_suzhou']['stricton'] = FALSE;

$active_group = 'data_qd';
$active_record = TRUE;

$db['data_qd']['hostname'] = '61.151.249.247';
$db['data_qd']['username'] = 'ywweb';
$db['data_qd']['password'] = 'yw!@#123';
$db['data_qd']['database'] = 'hw_data_qd';
$db['data_qd']['dbdriver'] = 'mysqli';
$db['data_qd']['dbprefix'] = '';
$db['data_qd']['pconnect'] = FALSE;
$db['data_qd']['db_debug'] = TRUE;
$db['data_qd']['cache_on'] = FALSE;
$db['data_qd']['cachedir'] = '';
$db['data_qd']['char_set'] = 'utf8';
$db['data_qd']['dbcollat'] = 'utf8_general_ci';
$db['data_qd']['swap_pre'] = '';
$db['data_qd']['autoinit'] = TRUE;
$db['data_qd']['stricton'] = FALSE;

$active_group = 'data_nj';
$active_record = TRUE;

$db['data_nj']['hostname'] = '47.99.117.126';
$db['data_nj']['username'] = 'root';
$db['data_nj']['password'] = 'dataface!q1';
$db['data_nj']['database'] = 'dataface_data_nj';
$db['data_nj']['dbdriver'] = 'mysql';
$db['data_nj']['dbprefix'] = '';
$db['data_nj']['pconnect'] = FALSE;
$db['data_nj']['db_debug'] = TRUE;
$db['data_nj']['cache_on'] = FALSE;
$db['data_nj']['cachedir'] = '';
$db['data_nj']['char_set'] = 'utf8';
$db['data_nj']['dbcollat'] = 'utf8_general_ci';
$db['data_nj']['swap_pre'] = '';
$db['data_nj']['autoinit'] = TRUE;
$db['data_nj']['stricton'] = FALSE;

$active_group = 'data_xian';
$active_record = TRUE;

$db['data_xian']['hostname'] = '47.99.117.126';
$db['data_xian']['username'] = 'root';
$db['data_xian']['password'] = 'dataface!q1';
$db['data_xian']['database'] = 'dataface_data_xian';
$db['data_xian']['dbdriver'] = 'mysqli';
$db['data_xian']['dbprefix'] = '';
$db['data_xian']['pconnect'] = FALSE;
$db['data_xian']['db_debug'] = TRUE;
$db['data_xian']['cache_on'] = FALSE;
$db['data_xian']['cachedir'] = '';
$db['data_xian']['char_set'] = 'utf8';
$db['data_xian']['dbcollat'] = 'utf8_general_ci';
$db['data_xian']['swap_pre'] = '';
$db['data_xian']['autoinit'] = TRUE;
$db['data_xian']['stricton'] = FALSE;

$active_group = 'data_hf';
$active_record = TRUE;

$db['data_hf']['hostname'] = '47.99.117.126';
$db['data_hf']['username'] = 'root';
$db['data_hf']['password'] = 'dataface!q1';
$db['data_hf']['database'] = 'dataface_data_hf';
$db['data_hf']['dbdriver'] = 'mysqli';
$db['data_hf']['dbprefix'] = '';
$db['data_hf']['pconnect'] = FALSE;
$db['data_hf']['db_debug'] = TRUE;
$db['data_hf']['cache_on'] = FALSE;
$db['data_hf']['cachedir'] = '';
$db['data_hf']['char_set'] = 'utf8';
$db['data_hf']['dbcollat'] = 'utf8_general_ci';
$db['data_hf']['swap_pre'] = '';
$db['data_hf']['autoinit'] = TRUE;
$db['data_hf']['stricton'] = FALSE;

$active_group = 'data_sy';
$active_record = TRUE;

$db['data_sy']['hostname'] = '47.99.117.126';
$db['data_sy']['username'] = 'root';
$db['data_sy']['password'] = 'dataface!q1';
$db['data_sy']['database'] = 'dataface_data_xian';
$db['data_sy']['dbdriver'] = 'mysqli';
$db['data_sy']['dbprefix'] = '';
$db['data_sy']['pconnect'] = FALSE;
$db['data_sy']['db_debug'] = TRUE;
$db['data_sy']['cache_on'] = FALSE;
$db['data_sy']['cachedir'] = '';
$db['data_sy']['char_set'] = 'utf8';
$db['data_sy']['dbcollat'] = 'utf8_general_ci';
$db['data_sy']['swap_pre'] = '';
$db['data_sy']['autoinit'] = TRUE;
$db['data_sy']['stricton'] = FALSE;


$active_group = 'data_xz';
$active_record = TRUE;

$db['data_xz']['hostname'] = '47.99.117.126';
$db['data_xz']['username'] = 'root';
$db['data_xz']['password'] = 'dataface!q1';
$db['data_xz']['database'] = 'dataface_data_xz';
$db['data_xz']['dbdriver'] = 'mysqli';
$db['data_xz']['dbprefix'] = '';
$db['data_xz']['pconnect'] = FALSE;
$db['data_xz']['db_debug'] = FALSE;
$db['data_xz']['cache_on'] = FALSE;
$db['data_xz']['cachedir'] = '';
$db['data_xz']['char_set'] = 'utf8';
$db['data_xz']['dbcollat'] = 'utf8_general_ci';
$db['data_xz']['swap_pre'] = '';
$db['data_xz']['autoinit'] = TRUE;
$db['data_xz']['stricton'] = FALSE;

$active_group = 'data_fz';
$active_record = TRUE;

$db['data_fz']['hostname'] = '47.99.117.126';
$db['data_fz']['username'] = 'root';
$db['data_fz']['password'] = 'dataface!q1';
$db['data_fz']['database'] = 'dataface_data_fz';
$db['data_fz']['dbdriver'] = 'mysqli';
$db['data_fz']['dbprefix'] = '';
$db['data_fz']['pconnect'] = FALSE;
$db['data_fz']['db_debug'] = FALSE;
$db['data_fz']['cache_on'] = FALSE;
$db['data_fz']['cachedir'] = '';
$db['data_fz']['char_set'] = 'utf8';
$db['data_fz']['dbcollat'] = 'utf8_general_ci';
$db['data_fz']['swap_pre'] = '';
$db['data_fz']['autoinit'] = TRUE;
$db['data_fz']['stricton'] = FALSE;

$active_group = 'data_xm';
$active_record = TRUE;

$db['data_xm']['hostname'] = '47.99.117.126';
$db['data_xm']['username'] = 'root';
$db['data_xm']['password'] = 'dataface!q1';
$db['data_xm']['database'] = 'dataface_data_xm';
$db['data_xm']['dbdriver'] = 'mysqli';
$db['data_xm']['dbprefix'] = '';
$db['data_xm']['pconnect'] = FALSE;
$db['data_xm']['db_debug'] = FALSE;
$db['data_xm']['cache_on'] = FALSE;
$db['data_xm']['cachedir'] = '';
$db['data_xm']['char_set'] = 'utf8';
$db['data_xm']['dbcollat'] = 'utf8_general_ci';
$db['data_xm']['swap_pre'] = '';
$db['data_xm']['autoinit'] = TRUE;
$db['data_xm']['stricton'] = FALSE;

$active_group = 'data_zz';
$active_record = TRUE;

$db['data_zz']['hostname'] = '47.99.117.126';
$db['data_zz']['username'] = 'root';
$db['data_zz']['password'] = 'dataface!q1';
$db['data_zz']['database'] = 'dataface_data_zz';
$db['data_zz']['dbdriver'] = 'mysqli';
$db['data_zz']['dbprefix'] = '';
$db['data_zz']['pconnect'] = FALSE;
$db['data_zz']['db_debug'] = FALSE;
$db['data_zz']['cache_on'] = FALSE;
$db['data_zz']['cachedir'] = '';
$db['data_zz']['char_set'] = 'utf8';
$db['data_zz']['dbcollat'] = 'utf8_general_ci';
$db['data_zz']['swap_pre'] = '';
$db['data_zz']['autoinit'] = TRUE;
$db['data_zz']['stricton'] = FALSE;


$active_group = 'data_qidong';
$active_record = TRUE;

$db['data_qidong']['hostname'] = '47.99.117.126';
$db['data_qidong']['username'] = 'root';
$db['data_qidong']['password'] = 'dataface!q1';
$db['data_qidong']['database'] = 'dataface_data_qidong';
$db['data_qidong']['dbdriver'] = 'mysqli';
$db['data_qidong']['dbprefix'] = '';
$db['data_qidong']['pconnect'] = FALSE;
$db['data_qidong']['db_debug'] = FALSE;
$db['data_qidong']['cache_on'] = FALSE;
$db['data_qidong']['cachedir'] = '';
$db['data_qidong']['char_set'] = 'utf8';
$db['data_qidong']['dbcollat'] = 'utf8_general_ci';
$db['data_qidong']['swap_pre'] = '';
$db['data_qidong']['autoinit'] = TRUE;
$db['data_qidong']['stricton'] = FALSE;
