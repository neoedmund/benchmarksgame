<?   // Copyright (c) Isaac Gouy 2015 ?>
<? 
  list($labels,$gm,$stats) = $Data;
  unset($Data);  

  $n = sizeof($labels); 
  for ($i=0; $i<$n; $i++){
    echo $labels[$i], ",", $gm[$i],"\n";

    for ($j=0; $j<STATS_SIZE; $j++){
      echo ",",$stats[$i][$j],"\n";
    }
  }

   unset($labels); 
   unset($gm); 
   unset($stats); 
?>



