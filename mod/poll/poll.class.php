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
if(!isset($_SESSION)) session_start();

include "security.core.php";

class poll extends phpSecurityClass{
 
	public function send($title,$text,$qtype)
	{
		$mysql = mysql_start();
		
		if(!$this->num($qtype)){
			$_SESSION['login'] = 0;
			return 0;
		}
		
		$text = str_replace("&","&amp;",$text);
		$text = str_replace("<","&lt;",$text);
		$text = str_replace(">","&gt;",$text);
		$text = str_replace("\"","&quot;",$text);
		$text = str_replace("'","&apos;",$text);
		
		$title = str_replace("&","&amp;",$title);
		$title = str_replace("<","&lt;",$title);
		$title = str_replace(">","&gt;",$title);
		$title = str_replace("\"","&quot;",$title);
		$title = str_replace("'","&apos;",$title);
		
		
		mysql_query("INSERT INTO 
						main_poll (`title`,`content`,`id_user_rif`,`qtype`)
						VALUES ('$title','$text','".$_SESSION['userid']."','".$qtype."')
						")
		or die(mysql_error()); 

		mysql_kill($mysql);
		
		return 1;
	}
	
	public function subsend($text,$id)
	{
		$mysql = mysql_start();
		
		if(!$this->num($id)){
			$_SESSION['login'] = 0;
			return 0;
		}
		
		$text = str_replace("&","&amp;",$text);
		$text = str_replace("<","&lt;",$text);
		$text = str_replace(">","&gt;",$text);
		$text = str_replace("\"","&quot;",$text);
		$text = str_replace("'","&apos;",$text);
		
		
		mysql_query("INSERT INTO 
						sub_poll (`content`,`id_user_rif`,`id_poll_rif`)
						VALUES ('$text','".$_SESSION['userid']."','$id')
						")
		or die(mysql_error()); 

		mysql_kill($mysql);
		
		return 1;
	}
	
	public function quest()
	{
		$mysql = mysql_start();
		
		$sql = "SELECT * FROM main_poll ORDER BY id DESC";
		$array = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($array)){
			echo "<h2><a href=\"index.php?page=poll&view=".$row['id']."\">".$row['title']."?</a></h2>";
		}

		mysql_kill($mysql);
		
		return 1;
	}
	
	public function idquest($id)
	{
		$mysql = mysql_start();
		
		if(!$this->num($id)){
			$_SESSION['login'] = 0;
			return 0;
		}
		
		$sql = "SELECT * FROM main_poll,users WHERE main_poll.id_user_rif = users.id AND main_poll.id = '".$id."' ORDER BY users.id DESC";
		$array = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($array)){
			echo "<h2><a href=\"index.php?page=poll&view=".$id."\">".$row['title']."?</a></h2>@".$row['nick'].": ".$row['content']."<br /><br /><hr>";
		}
		
		$sql = "SELECT * FROM sub_poll,users WHERE sub_poll.id_user_rif = users.id AND sub_poll.id_poll_rif = '".$id."' ORDER BY sub_poll.id ASC";
		$array = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($array)){
			echo "<br />@".$row['nick'].": ".$row['content']."<br /><br /><hr>";
		}

		mysql_kill($mysql);
		
		return 1;
	}
}
?>
