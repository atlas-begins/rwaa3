<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => 'MySQLDatabase',
	"server" => 'localhost',
	"username" => 'SS_admin',
	"password" => 'admin__',
	"database" => 'rwaa3',
	"path" => '',
);

// Set the site locale
i18n::set_locale('en_US');

// enable fulltext index searching
FulltextSearchable::enable();