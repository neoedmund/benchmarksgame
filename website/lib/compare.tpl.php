<?   // Copyright (c) Isaac Gouy 2004-2015 ?>
<? 

// hardcode comparisons that will be offered

$vs_gcc = array( "id" => "gcc", "name" => "C" );
$vs_gpp = array( "id" => "gpp", "name" => "C++" );
$vs_csharp = array( "id" => "csharp", "name" => "C#" );
$vs_dart = array( "id" => "dart", "name" => "Dart" );
$vs_erlang = array( "id" => "erlang", "name" => "Erlang" );
$vs_fsharp = array( "id" => "fsharp", "name" => "F#" );
$vs_go = array( "id" => "go", "name" => "Go" );
$vs_hack = array( "id" => "hack", "name" => "Hack" );
$vs_ghc = array( "id" => "ghc", "name" => "Haskell" );
$vs_java = array( "id" => "java", "name" => "Java" );
$vs_jruby = array( "id" => "jruby", "name" => "JRuby" );
$vs_v8 = array( "id" => "v8", "name" => "JavaScript" );
$vs_sbcl = array( "id" => "sbcl", "name" => "Lisp" );
$vs_ocaml = array( "id" => "ocaml", "name" => "OCaml" );
$vs_php = array( "id" => "php", "name" => "PHP" );
$vs_python = array( "id" => "python3", "name" => "Python" );
$vs_yarv = array( "id" => "yarv", "name" => "Ruby" );
$vs_rust = array( "id" => "rust", "name" => "Rust" );

$comparisons = array(
  "gnat" => array( $vs_gcc, $vs_gpp ),
  "gcc" => array( $vs_gpp, $vs_java ),
  "csharp" => array( $vs_gpp, $vs_fsharp, $vs_java ),
  "gpp" => array( $vs_gcc, $vs_java ),
  "clojure" => array( $vs_java, $vs_sbcl ),
  "dart" => array( $vs_java, $vs_v8 ),
  "hipe" => array( $vs_erlang, $vs_java ),
  "fsharp" => array( $vs_csharp, $vs_java, $vs_ocaml ),
  "ifc" => array( $vs_gcc, $vs_gpp ),
  "go" => array( $vs_gcc, $vs_gpp, $vs_java, $vs_rust ),
  "hack" => array( $vs_java, $vs_php ),
  "ghc" => array( $vs_gcc, $vs_gpp, $vs_java, $vs_ocaml ),
  "java" => array( $vs_gcc, $vs_gpp ),
  "v8" => array( $vs_gpp, $vs_java, $vs_python, $vs_yarv ),
  "sbcl" => array( $vs_gpp, $vs_java ),
  "lua" => array( $vs_java, $vs_python ),
  "ocaml" => array( $vs_gpp, $vs_fsharp, $vs_ghc, $vs_java ),
  "fpascal" => array( $vs_gpp, $vs_java ),
  "perl" => array( $vs_php, $vs_python, $vs_yarv ),
  "php" => array( $vs_hack, $vs_python, $vs_yarv ),
  "python3" => array( $vs_gcc, $vs_gpp, $vs_go, $vs_java ),
  "racket" => array( $vs_java, $vs_sbcl ),
  "rust" => array( $vs_gcc, $vs_gpp, $vs_go, $vs_java ),
  "yarv" => array( $vs_go, $vs_jruby, $vs_php, $vs_python ),
  "jruby" => array( $vs_java, $vs_yarv ),
  "scala" => array( $vs_java ),
  "vw" => array( $vs_java, $vs_python ),
  "swift" => array( $vs_java, $vs_v8, $vs_python ),
  "typescript" => array( $vs_v8, $vs_dart )
);

function PF($d){
  $rounded = round($d);
  if ($rounded>15){ return '<td class="num1">'.number_format($rounded).'&#215;</td>'; }
  elseif ($rounded>1){ return '<td class="num2">'.number_format($rounded).'&#215;</td>'; }
  elseif ($d>1.01){ return '<td class="num2">&#177;</td>'; }
  else {
    if ($d>0){
      $i = 1.0 / $d;
      $rounded = round($i);
      if ($rounded>15){ return '<td class="num5"><sup>1</sup>/<sub>'.number_format($rounded).'</sub></td>'; }
        elseif ($rounded>1){ return '<td><sup>1</sup>/<sub>'.number_format($rounded).'</sub></td>'; }
        else { return '<td class="num2">&#177;</td>'; }
    } else {
      return '<td>&nbsp;</td>';
    }
  }
}

$Row = $Langs[$SelectedLang];
$LangName = $Row[LANG_FULL];
$LangName2 = $Langs[$SelectedLang2][LANG_FULL];
$LangLink = $Row[LANG_LINK];
?>
<article>
  <div>
    <h2><?=$LangName;?> programs versus <?=$LangName2;?></h2>
    <aside>
      <p><a href="./measurements.php?lang=<?=$LangLink;?>">all the <?=$LangName;?> program measurements</a>
    </aside>
  </div>
  <section>
    <div>
      <h3>by benchmark task performance</h3>
    </div>
    <table>
<?
foreach($Data as $k => $rows){
  // Why would $k be NULL? No working programs for a test? 
  if ($k == NULL || $Tests[$k][TEST_WEIGHT]<=0){ continue; }
  $test = $Tests[$k];
  $testname = $test[TEST_NAME];
  $testlink = $test[TEST_LINK];

  if (!empty($rows)){

    echo "      <tbody>\n";
    echo "      <tr>\n";
    echo '        <th colspan="3"><a href="./performance.php?test=', $testlink, '">', $testname, "</a>\n";
    echo '        <th colspan="3">', "\n";

    echo "      <tr>\n";
    echo "        <th>\n";
    echo "        <th>secs\n";
    echo "        <th>KB\n";
    echo "        <th>gz\n";
    echo "        <th>cpu\n";
    echo "        <th>cpu load\n";

    $elapsed_td = '';
    if (isset($rows[0]) && isset($rows[1]) && ($rows[0][DATA_TIME] < $rows[1][DATA_TIME])){
      $elapsed_td = ' class="best"';
    }

    foreach($rows as $row){

      if (is_array($row)){
        $id = $row[DATA_ID];
        $lang = $row[DATA_LANG];
        $name = $Langs[$lang][LANG_FULL];
        $noSpaceName = str_replace(' ','&nbsp;',$name);

        echo "      <tr>\n";

        $nav = '"./program.php?test='.$k.'&amp;lang='.$lang.'&amp;id='.$id.'"';
        echo "        <td><a href=$nav>", "$noSpaceName</a>\n";

        if ($row[DATA_STATUS] > PROGRAM_TIMEOUT){

          if ($row[DATA_ELAPSED]>0){ $e = number_format($row[DATA_ELAPSED],2); } else { $e = ''; }
          echo "        <td", $elapsed_td, ">", $e, "\n";

          if ($row[DATA_MEMORY]==0){ $kb = '?'; } else { $kb = number_format($row[DATA_MEMORY]); }
          echo "        <td>", $kb, "\n";

          $gz = $row[DATA_GZ];
          echo "        <td>", $gz, "\n";

          $fc = number_format($row[DATA_FULLCPU],2);
          echo "        <td>", $fc, "\n";

          $ld = CpuLoad($row);
          echo '        <td class="message">', $ld, "\n";

        } else {
          echo "        <td>&nbsp;", "\n";
          echo '        <td class="message">', StatusMessage($row[DATA_STATUS]), "\n";
          echo '        <td colspan="4">', "\n";
        }
        $elapsed_td = '';

      } elseif (!isset($row)) {

        echo "      <tr>\n";
        echo "        <td>&nbsp;", "\n";
        echo '        <td class="message">', 'No&nbsp;program', "\n";
        echo '        <td class="message" colspan="4">', '<a href="./play.html">contribute your program</a>', "\n";
      }
    }

  } else { // empty($rows)     

    echo "      <tbody>\n";
    echo "      <tr>\n";
    echo "        <th>", $testname, "\n";
    echo '        <th colspan="5">', "\n";

    echo "      <tr>\n";
    echo "        <td>&nbsp;", "\n";
    echo '        <td class="message">', 'No&nbsp;programs', "\n";
    echo '        <td class="message" colspan="4">', '<a href="./play.html">contribute your programs</a>', "\n";
  }
}


// force version info into bottom of table

$name = $Langs[$SelectedLang][LANG_FULL];
$noSpaceName = str_replace(' ','&nbsp;',$name);
echo "      <tbody>\n";

echo "      <tr>\n";
echo "        <td>", "$noSpaceName\n";
echo '        <td colspan="5" class="message">', $LangVersion, "\n";

$name = $Langs[$SelectedLang2][LANG_FULL];
$noSpaceName = str_replace(' ','&nbsp;',$name);
echo "      <tr>\n";
echo "        <td>", "$noSpaceName\n";
echo '        <td colspan="5" class="message">', $Lang2Version, "\n";

echo "      </table>", "\n";


if (isset( $comparisons[$SelectedLang] )) {
  $cs = $comparisons[$SelectedLang]; 
  if (count($cs) > 1) {
    $default = $Langs[$SelectedLang][LANG_COMPARE];
    $page = $Langs[$SelectedLang][LANG_SPECIALURL];

    echo "      <nav>", "\n";
    echo "        <ul>", "\n";

    foreach($cs as $c){
      if ($SelectedLang2 == $c["id"]) {
        echo '          <li class="best">vs ', $c["name"], "\n";

      } elseif ($c["id"] == $default) {

          if ((SITE_NAME == "u64q")||(SITE_NAME == "u32")) {
            echo '          <li><a href="./', $page, '.html">vs ', $c["name"], "</a>\n";
        } else {
            echo '          <li><a href="./', $page, '.php">vs ', $c["name"], "</a>\n";
        }

      } else {

// special-case some more commonly viewed pages



        echo '          <li><a href="./compare.php?lang=', $SelectedLang, "&amp;lang2=", $c["id"], '">vs ', $c["name"], "</a>\n";
      }
    }

    echo "        </ul>", "\n";
    echo "      </nav>", "\n";
  } 
}

?>
  </section>
</article>
