<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=noodle',
//	'connectionString' => 'mysql:host=8.8.8.12;dbname=tezisuo',

	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'tiantianjianmian',
    'tablePrefix'=>'ttjm_',
	'charset' => 'utf8',

);