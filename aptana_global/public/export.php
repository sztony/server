<?php
/*******************************************************************************
 * Copyright (c) 2007 Eclipse Foundation and others.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Paul Colton (Aptana)- initial API and implementation

*******************************************************************************/
// if not logged in redirect to login page
// otherwise show choices
require_once("aptana_global/aptana.inc.php");
require_once("aptana_global/agent.inc.php");
// ------...------...------...------...------...------...------...------...------...------...------
// should move this out of here
InitPage("export");

$lang_code = (isset($_GET['lang'])?$_GET['lang']:'');
$format    = 'xml';

$entry_rec = new entries_iu(0);
$lang_rec  = new languages_iu(0);
$lang_rec->sqlLoad("iso_code",$lang_code);

if (!$lang_rec->_id) {
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  echo "<error>language not found</error>\n";
  exit;
}


$lang_name = $lang_rec->_name;
$file_name = $lang_name . "_Translation.xml";

$path = array();
$cmd = "SELECT * FROM entries WHERE language_id=1";
$qry = mysql_query($cmd);
while ($rec = mysql_fetch_object($qry)) {
  $path[$rec->name] = $rec->repo_path;
}

$cmd       = "SELECT entries.name AS entry," .
             "       entries.value AS value," .
             "       projects.name AS name, " .
             "       projects.package_name AS package," .
             "       projects.id AS id" .
             "  FROM entries,projects " .
             " WHERE projects.id=entries.project_id " .
             "   AND language_id=" . $lang_rec->_id .
             " ORDER BY projects.id";
$qry = mysql_query($cmd);

header("Pragma: no-cache");
header("Content-Type: application/xml");
header("Content-Disposition: attachment; filename=$file_name");

echo <<< toTheEnd
<?xml version="1.0" encoding="UTF-8"?>
 <translation>
 <language>$lang_name</language>
 <iso_name>$lang_code</iso_name>
 <projects>

toTheEnd;

$proj_id = 0;
while ($entry = mysql_fetch_object($qry)) {
  if (strlen($entry->value) < 1)
    continue;
  if ($entry->id != $proj_id) {
    if ($proj_id) {
      echo "   </entries>\n";
      echo "  </project>\n";
    }
    $proj_id = $entry->id;
    echo "  <project>\n";
    echo "   <name>$entry->name</name>\n";
    echo "   <entries>\n";
  }
  $entry_rec->sqlLoad("name='$entry->entry' AND language_id=1");
  echo "   <entry>\n";
  echo "     <name>$entry->entry</name>\n";
  echo "     <value>\n";
  echo "      <![CDATA[$entry->value]]>\n";
  echo "     </value>\n";
  echo "     <file>" . $path[$entry->entry] . "</file>\n";
  echo "    </entry>\n";
}

// ------...------...------...------...------...------...------...------...------...------...------

echo <<< toTheEnd
   </entries>
  </project>
 </projects>
</translation>

toTheEnd;

// ------...------...------...------...------...------...------...------...------...------...------
?>