<?php
/*
 * While($x) 
 *   Copyright (C) 2013  While($x) Team
 * 
 *   WebSite: http://www.whilex.it/
 *   GitHub: https://github.com/whilex
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
	$db="whilex";
	$dbhost="localhost";
	$dbuser="root";
	$dbpwd="password";
		
	$debug = 0;

	function mysql_start(){
		$db="whilex";
		$dbhost="localhost";
		$dbuser="root";
		$dbpwd="password";
	
		$dbtype = "mysql:dbname=$db;host=$dbhost";

		try {
			$mysql = new PDO($dbtype , $dbuser, $dbpwd);
		} catch (PDOException $e) {
			echo 'MySQL Error: ' . $e->getMessage();
		}
		
		mysql_connect($dbhost,$dbuser,$dbpwd) or die(mysql_error());
		mysql_select_db($db) or die(mysql_error()); 
		
		return $mysql;
	}

	function mysql_kill($mysql){
		$mysql = null;
		
		return 1;
	}
?>
