<?   // Copyright (c) Isaac Gouy 2015 ?>
<? 
  list($labels,$gm,$stats) = $Data;
  unset($Data);  
  unset($gm); 

  $marker_label = '0';
  $marker = array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0);

  if (SITE_NAME=='u64q'){
    // define kde based groups -- u64q
    $index_firstlast = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,-1,16);
    $index_middle = array(17,18,-1,19,20,21,-1,22,23,24,25,26,27,28,29);

  } elseif (SITE_NAME=='u64'){
    // define based groups -- u64
    $index_firstlast = array(0,1,2,3,4,5,-1,20,21,22,23,24,25,26);
    $index_middle = array(6,7,8,9,10,11,12,13,14,15,16,17,-1,18,19);

  } elseif (SITE_NAME=='u32q'){
    // define based groups -- u32q
    $index_firstlast = array(0,1,2,3,4,5,6,7,-1,18,19,20,-1,21,22);
    $index_middle = array(8,9,10,11,12,13,14,-1,15,-1,16,17);

  } elseif (SITE_NAME=='u32'){
    // define based groups -- u32
    $index_firstlast = array(0,1,2,3,4,5,-1,6,7,8,-1,21,22,23,24,25,26);
    $index_middle = array(9,10,11,12,13,14,15,-1,16,17,18,-1,19,20);
  }

  if ($IsFirstLast){
    foreach($index_firstlast as $i){
      $l[] = ($i > -1) ? $labels[$i] : $marker_label;
      $s[] = ($i > -1) ? $stats[$i] : $marker;
    }
  } else {
    foreach($index_middle as $i){
      $l[] = ($i > -1) ? $labels[$i] : $marker_label;
      $s[] = ($i > -1) ? $stats[$i] : $marker;
    }
  }

  unset($labels); 
  unset($stats); 
  $chart = 'chartboxSVG.php';
?>
<img src="<?=$chart;?>?<?='s='.Encode($s);?>&amp;<?='m='.Encode($Mark);?>&amp;<?='w='.Encode($l);?>">
