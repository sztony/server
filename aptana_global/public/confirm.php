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
require_once("aptana_global/code/confirm.code.php");

// ------...------...------...------...------...------...------...------...------...------...------
include("aptana_global/head.php");
echo <<< toTheEnd
<form method="post">
<div id="title">Email Confirmation</div>


<table cellspacing=4 cellpadding=0 >
<tr>
  <td id="formLbl">          key:</td>
  <td><input type="text" style="width:215px;" name="key"  value="$key"     /><p /></td>
  <td id="formErr">{$g_ERRSTRS[0]}&nbsp;</td>
</tr>
<!--
<tr>
  <td id="formLbl">are&nbsp;you&nbsp;human:</td>
  <td><input type="text" style="width:215px;" name="code" value="$codeStr" />     </td>
  <td id="formErr">{$g_ERRSTRS[1]}&nbsp;</td>
</tr>
-->
<tr><td id="formLbl"></td><td><img src="/img/$codePng"><p /></td></tr>

<tr><td></td><td><input type="submit" name="postIT" value="confirm" style="font-size:14px;"/><br /><br /></td></tr>
</table>
</form>

toTheEnd;
include("aptana_global/foot.php");

// ------...------...------...------...------...------...------...------...------...------...------
?>