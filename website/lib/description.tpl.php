<?   // Copyright (c) Isaac Gouy 2015 ?>
<? 
  $orderedTests = array(
    'nbody', 'fannkuchredux', 'spectralnorm', 'mandelbrot', 'meteor',
    'pidigits', 'regexdna', 'fasta', 'knucleotide', 'revcomp',
    'binarytrees', 'chameneosredux', 'threadring' );

  $isOpenNav = FALSE;
  foreach($orderedTests as $each){

    if ($SelectedTest == $each){
      if ($isOpenNav){
        $isOpenNav = FALSE;
        echo "    </ul>\n";
        echo "  </nav>\n";
        echo "</div>\n";
      }
      $t = $Tests[$SelectedTest];
      $link = $t[TEST_LINK]; 
      $name = $t[TEST_NAME];

      echo "<article>\n";
      echo '  <h2 id="', $SelectedTest, '">', $name, " description</h2>\n";
      echo "  <aside>\n";
      echo '    <p><a href="./performance.php?test=', $link, '">program measurements</a>', "\n";
      echo "  </aside>\n";

      echo $Description, "\n";
      echo "</article>\n";

    } else {
      if (!$isOpenNav){
        $isOpenNav = TRUE;
        echo "<div>\n";
        echo "  <nav>\n";
        echo "    <ul>\n";
      }

      $t = $Tests[$each];
      $link = $t[TEST_LINK]; 
      $name = $t[TEST_NAME];
      $tag = $t[TEST_TAG];

      echo '      <li><a href="./', $link, '-description.html#', $link,'">', $name, '</a><p>', $tag, "\n";
    }
  }
  if ($isOpenNav){
    echo "    </ul>\n";
    echo "  </nav>\n";
    echo "</div>\n";
  }
?>
