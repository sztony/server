<?
// if not logged in redirect to login page// otherwise show choicesrequire_once("aptana_global/aptana.inc.php");// ------...------...------...------...------...------...------...------...------...------...------// should move this out of hereInitPage("get_projects");$lang  = $_GET['lang'];$entr  = new entries_iu(0);$projs = new projects_iu(0);$projs->sqlList("SELECT * FROM {SELF}");$x = 1;echo "<table cellspacing=0 cellpadding=0 border=0 style='width:220px;white-space:nowrap;overflow:hidden;font-size:8pt;'>\n";echo "<tr><td></td></tr>";while ($projs->sqlNext()) {  $langCnt = $entr->sqlGetCnt("SELECT COUNT(*) FROM {SELF} WHERE language_id=$lang AND  project_id=" . $projs->_id);  $entr->sqlList("SELECT name,COUNT(*) FROM {SELF}  WHERE project_id=" . $projs->_id . " GROUP BY name");   $fullCnt = $entr->sql_Cnt;  $width = 220*($langCnt/$fullCnt);  $name  = trim(strlen($projs->_name)?$projs->_name:$projs->_package_name);  $name  = str_replace(" ","&nbsp;",$name);  echo "<tr><td style='border-bottom:solid 1px #aaa;cursor:pointer; _cursor:hand;'> ";
  echo "    <a class=ss href='#' onmousedown='selProj(" . $projs->_id . ",$x);' onmouseover='ratover($x);' onmouseout='ratout($x);'> ";
  echo "    <div id=myPdiv$x class=graph style='width:" . $width . "px;'>&nbsp;$name</div></a></td></tr>\n";  $x++;}echo "</table>\n";/*<div id=graph style='width:" . $width . "px;'>alert("There was a problem retrieving the XML data:\n" + req.statusText);*/// ------...------...------...------...------...------...------...------...------...------...------?>