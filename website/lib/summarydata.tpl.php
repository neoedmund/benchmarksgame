<?   // Copyright (c) Isaac Gouy 2004-2015 ?>
<article>
  <div>
  <h2 id="summary-data"><?=PLATFORM_NAME;?></h2>
  <aside>
    <p>The summary data only includes measurements for programs that successfully completed every workload; only includes measurements for the fastest programs and only includes the fastest measurement for those programs. 
    <p>For additional measurements (not just the fastest programs, not just the fastest measurements), download the compressed data file <a href="<?= DATA_PATH.$DataName ?>"><?= $DataName ?></a>
  </aside>
  </div>
  <section>
    <h3><a href="#summary-data"><?= "Summary Data [".$Mark."]" ?></a></h3>
    <pre>
<?   
      echo "task,language,id,n,gz,cpu,KB,status,load,secs [", $Mark, "]\n";
      foreach($Data as $i => $row){
        $row[DATA_TEST] = $Tests[ $row[DATA_TEST] ][TEST_NAME];
        $row[DATA_LANG] = $Langs[ $row[DATA_LANG] ][LANG_FULL];
        echo implode(',', $row), "\n";
      }
?>
    </pre>
  </section>
</article>
<footer>
  <nav>
    <ul>
      <li><a href="../license.html">license</a>
    </ul>
  </nav>
</footer>
