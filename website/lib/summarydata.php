<?php
// Copyright (c) Isaac Gouy 2009-2015

// LIBRARIES ////////////////////////////////////////////////

require_once(LIB_PATH.'lib_whitelist.php');
require_once(LIB);


// DATA LAYOUT ///////////////////////////////////////////////////

// Some code duplication

define('DATA_TEST',0);
define('DATA_LANG',1);
define('DATA_ID',2);
define('DATA_TESTVALUE',3);
define('DATA_STATUS',7);

// With quad-core we changed from CPU Time to Elapsed Time
// but we still want to show the old stuff
define('DATA_TIME',9);


// FUNCTIONS ///////////////////////////////////////////

// Some code duplication

function FastestRows($test_rows,$fastest){
   foreach($test_rows as $k => $rows) {
      $testvalue = -1; // assume negative test values are not used
      $time = 360000.0; // 100 hours
      foreach($rows as $row) {
         $row_testvalue = $row[DATA_TESTVALUE];
         if ($row_testvalue > $testvalue){
            $testvalue = $row_testvalue;
            $time = $row[DATA_TIME];
            $id = $row[DATA_ID];
         } elseif ($row_testvalue == $testvalue){
            $row_time = $row[DATA_TIME];
            if ($row_time < $time){
               $testvalue = $row_testvalue;
               $time = $row_time;
               $id = $row[DATA_ID];
            }
         }
      }
      foreach($rows as $row) {
         if ($row[DATA_ID] == $id){
            $fastest[] = $row;
         }
      }
   }
   return $fastest;
}


function DataRows($FileName,&$Tests,&$Langs,&$Incl,&$Excl,$HasHeading=TRUE){
   $data = array();
   $previous = 'not set';
   $test_rows = array();
   $lines = @file($FileName) or die ('Cannot open $FileName');
   if ($HasHeading){ unset($lines[0]); } // remove header line
   foreach($lines as $line) {
      $row = explode( ',', $line);
      $test = $row[DATA_TEST];
      $lang = $row[DATA_LANG];
      $key = $test.$lang.$row[DATA_ID];

      // accumulate all acceptable datarows, exclude duplicates

      if (isset($Incl[$test]) && isset($Incl[$lang]) &&
               isset($Langs[$lang]) &&
                  !isset($Excl[$key])){

            if ($previous != $test){ // assume ndata.csv is sorted by test
               $data = FastestRows($test_rows,$data);
               $test_rows = array();
            }
            $previous = $test;

            settype($row[DATA_STATUS],'integer');
            settype($row[DATA_TESTVALUE],'integer');
            $testvalue = $row[DATA_TESTVALUE];
            settype($row[DATA_TIME],'double');

            if ($row[DATA_STATUS] == 0){
               $test_rows[$lang][] = $row;
            }

      }
   }
   $data = FastestRows($test_rows,$data);
   return $data;
}


function MarkTime($PathRoot=''){
   $mtime = filemtime($PathRoot.DATA_PATH.'data.csv');
   $Mark = gmdate("d M Y", $mtime);
   return $Mark;
}


// DATA ///////////////////////////////////////////

list($Incl,$Excl) = WhiteListInEx();
$Tests = WhiteListUnique('test.csv',$Incl); // assume test.csv in name order
$Langs = WhiteListUnique('lang.csv',$Incl); // assume lang.csv in name order

$mark = MarkTime();
$mark = $mark.' '.SITE_NAME;

$Data = DataRows(DATA_PATH.'ndata.csv', $Tests, $Langs, $Incl, $Excl);
$dataname = SITE_NAME.'_bulkdata.csv.bz2';


// PAGE ////////////////////////////////////////////////

$Page = & new Template(LIB_PATH);
$Body = & new Template(LIB_PATH);
$TemplateName = 'summarydata.tpl.php';
$Title = 'Data '.'('.PLATFORM_NAME.')'; 
$mark = $mark.' n';

// META ////////////////////////////////////////////////

$keywords = '<meta name="description" content="The full measurements and summary data set used by the Computer Language Benchmarks Game ('.PLATFORM_NAME.').">';
$robots = '<meta name="robots" content="index,nofollow,archive">';
$style = '<style><!--
a{color:black;text-decoration:none}article{padding: 0 0 2.9em}article,div,footer,header{margin:auto;width:92%}body{font:100% Droid Sans,Ubuntu,Verdana,sans-serif;margin:0;-webkit-text-size-adjust:100%}h1,h2,h3,li a{font-family:Ubuntu Mono,Consolas,Menlo,monospace}div,footer,header{max-width:31em}footer{padding:2.6em 0 0}h1{font-size:1.4em;font-weight:bold;margin:0;padding:.4em}h1,h1 a{color:white}h2,h3{margin:1.5em 0 0}h2{font-size:1.4em;font-weight:normal}h3{font-size:1.2em}li{list-style-type:none;vertical-align:top}li a{display:block;font-size:1.2em;margin:.5em .5em 0;padding:.5em .5em .3em}ul{clear:left;margin:-0.3em 0 1.5em;text-align:center}p{color:#333;line-height:1.4;margin:.3em 0 0}p a{border-bottom:.15em dotted #aaa}#u64,#u64q{background-color:#c90016}#u32{background-color:#ffb515}#u32q{background-color:#ff6309}pre{color:#333;overflow-wrap:break-word;white-space:pre-wrap;word-wrap:break-word}@media only screen and (min-width:60em){article,footer,header{font-size:1.25em}}
--></style>';


// TEMPLATE VARS ////////////////////////////////////////////////

$Page->set('PageTitle', $Title.' | Computer Language Benchmarks Game');

$Body->set('Data', $Data );
$Body->set('DataName', $dataname );
$Body->set('Langs', $Langs);
$Body->set('Mark', $mark);
$Body->set('Tests', $Tests);
$Body->set('Title', $Title);

$Page->set('Keywords', $keywords);
$Page->set('PageBody', $Body->fetch($TemplateName));
$Page->set('Robots', $robots);
$Page->set('Style', $style);

echo $Page->fetch('pageHTML5.tpl.php');
?>
