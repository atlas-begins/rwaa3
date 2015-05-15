<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => 'MySQLDatabase',
	"server" => 'localhost',
	"username" => 'SS_admin',
	"password" => 'admin_SS',
	"database" => 'rwaa',
	"path" => '',
);

// Set the site locale
i18n::set_locale('en_NZ');

global $fpdfPath;
$fpdfPath = '//Applications/MAMP/bin/php/fpdf17/fpdf.php';