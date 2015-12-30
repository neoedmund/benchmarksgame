<?   // Copyright (c) Isaac Gouy 2010-2015 ?>

<? 
$Row = $Langs[$SelectedLang];
$LangName = $Row[LANG_FULL];
$LangTag = $Row[LANG_TAG]; 
?>
<article>
  <div>
    <h2>all the <?=$LangName;?> program measurements</h2>
    <aside>
      <p><a href="./play.html">contribute your programs</a>
    </aside>
  </div>
  <section>
    <table>
<? 
// force version info into table

$noSpaceName = str_replace(' ','&nbsp;',$LangName);
echo "      <tbody>\n";

echo "      <tr>\n";
echo '        <td colspan="7" class="message">', $LangVersion, "\n";

$is_start = TRUE;
foreach($Data as $row){
  $test = $row[DATA_TEST];
  $id = $row[DATA_ID];
  $status = $row[DATA_STATUS];

  if (isset($prevTest) && isset($prevId)){
    if ($test != $prevTest || $id != $prevId){ $is_start = TRUE; }
    elseif (isset($prevStatus) && $prevStatus<0) { continue; }
  }
  $prevTest = $test;
  $prevId = $id;
  $prevStatus = $status;

  if ($row[DATA_TESTVALUE]==0){
    $n = '?'; 
  } else { 
    $n = '&nbsp;'.number_format($row[DATA_TESTVALUE]); 
  }

  if ($status<0){
    $e = StatusMessage($row[DATA_STATUS]); 
    $e_message = ' class="message"'; 
    $kb = ''; $gz = ''; $fc = ''; $ld = '';
   } else {
    $e = ElapsedTime($row);
    $e_message = ''; 
    if ($row[DATA_MEMORY]==0){ $kb = '?'; } else { $kb = number_format((double)$row[DATA_MEMORY]); }
    $gz = $row[DATA_GZ];
    $fc = number_format($row[DATA_FULLCPU],2);
    $ld = CpuLoad($row);
  }

  if ($is_start){
      echo "      <tbody>\n";
      if ($status==0){
        echo "        <tr>\n";
        echo "          <th>\n";
        echo "          <th>secs\n";
        echo "          <th>N\n";
        echo "          <th>KB\n";
        echo "          <th>gz\n";
        echo "          <th>cpu\n";
        echo "          <th>cpu load\n";
      }
      $is_start = FALSE;
  }

  echo "        <tr>\n";
  $TestName = $Tests[$row[DATA_TEST]][TEST_NAME];
  $nav = '"./program.php?test='.$test.'&amp;lang='.$row[DATA_LANG].'&amp;id='.$id.'"';
  echo "          <td><a href=$nav>", $TestName, "&nbsp;", IdName($id), "</a>\n";

  echo "          <td".$e_message.">", $e, "\n";
  echo "          <td>", $n, "\n";
  echo "          <td>", $kb, "\n";
  echo "          <td>", $gz, "\n";
  echo "          <td>", $fc, "\n";
  echo '          <td class="message">', $ld, "\n";
} 

?>
    </table>
  </section>
</article>
