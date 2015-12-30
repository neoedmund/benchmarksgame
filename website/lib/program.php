<?php
// Copyright (c) Isaac Gouy 2010-2015

// LIBRARIES ////////////////////////////////////////////////

require_once(LIB_PATH.'lib_whitelist.php');
require_once(LIB);


// PAGE ////////////////////////////////////////////////

$Page = & new Template(LIB_PATH);


// GET_VARS ////////////////////////////////////////////////

list($Incl,$Excl) = WhiteListInEx();
$Tests = WhiteListUnique('test.csv',$Incl); // assume test.csv in name order
$Langs = WhiteListUnique('lang.csv',$Incl); // assume lang.csv in name order

if (isset($_GET['test'])
      && strlen($_GET['test']) && (strlen($_GET['test']) <= NAME_LEN)){
   $X = $_GET['test'];
   if (ereg("^[a-z]+$",$X) && isset($Tests[$X]) && isset($Incl[$X])){ $T = $X; }
}
if (!isset($T)){ $T = 'nbody'; }


if (isset($_GET['lang'])
      && strlen($_GET['lang']) && (strlen($_GET['lang']) <= NAME_LEN)){
   $X = $_GET['lang'];
   if (ereg("^[a-z0-9]+$",$X)){ $L = $X; }
}

$Available = isset($L) && isset($Langs[$L]) && isset($Incl[$L]);

if (isset($_GET['id']) && strlen($_GET['id']) == 1){
   $X = $_GET['id'];
   if (ereg("^[0-9]$",$X)){ $I = $X; }
}
if (!isset($I)){ $I = -1; }

// 200 OK ////////////////////////////////////////////////

if ($Available){

$Body = & new Template(LIB_PATH);
$TemplateName = 'program.tpl.php';


// HEADER ////////////////////////////////////////////////

$TestName = $Tests[$T][TEST_NAME];
$LangName = $Langs[$L][LANG_FULL];
$IdName = ($I>1) ? '&nbsp;#'.$I : '';

$Title = $TestName.' '.$LangName.$IdName.' program';
$DescriptionURL = './'.$T.'-description.html#'.$T;


// META ////////////////////////////////////////////////

$keywords = '';
$robots = '<meta name="robots" content="noindex,follow,noarchive">';
$style = '<style><!--
a{color:black;text-decoration:none}article{padding: 0 0 2.9em}article,div,footer,header{margin:auto;width:92%}body{font:100% Droid Sans,Ubuntu,Verdana,sans-serif;margin:0;-webkit-text-size-adjust:100%}h1,h2,h3,li a{font-family:Ubuntu Mono,Consolas,Menlo,monospace}div,footer,header{max-width:31em}footer{padding:2.6em 0 0}h1{font-size:1.4em;font-weight:bold;margin:0;padding:.4em}h1,h1 a{color:white}h2,h3{margin:1.5em 0 0}h2{font-size:1.4em;font-weight:normal}h3{font-size:1.2em}li{list-style-type:none;vertical-align:top}li a{display:block;font-size:1.2em;margin:.5em .5em 0;padding:.5em .5em .3em}ul{clear:left;margin:-0.3em 0 1.5em;text-align:center}p{color:#333;line-height:1.4;margin:.3em 0 0}p a{border-bottom:.15em dotted #aaa}#u64,#u64q{background-color:#c90016}#u32{background-color:#ffb515}#u32q{background-color:#ff6309}.com,.slc{color:#888}.kwa{color:#066}.kwb{color:#900}.kwc{color:#050}.kwa,.kwb,.kwc{font-weight:bold}.dstr,.str,.sym,.num{color:#930}pre{color:#222;font-size:1em;overflow-wrap:break-word;white-space:pre-wrap;word-wrap:break-word}@media only screen and (min-width:60em){article,footer,header{font-size:1.25em}}
--></style>';


// TEMPLATE VARS ////////////////////////////////////////////////

$Page->set('PageTitle', $Title.' | Computer Language Benchmarks Game');

$Body->set('Code', HtmlFragment( CODE_PATH.$T.'.'.$I.'.'.$L.'.code' ));
$Body->set('DescriptionURL', $DescriptionURL);
$Body->set('Log',  htmlspecialchars( HtmlFragment( CODE_PATH.$T.'.'.$I.'.'.$L.'.log' )) );
$Body->set('Title', $Title);
$Body->set('Version', strip_tags( HtmlFragment(VERSION_PATH.$L.'-version.php')));

$Page->set('Keywords', $keywords);
$Page->set('PageBody', $Body->fetch($TemplateName));
$Page->set('Robots', $robots);
$Page->set('Style', $style);

echo $Page->fetch('pageHTML5.tpl.php');


// 404 Not Found ////////////////////////////////////////////////

} else {

echo $Page->fetch('page404HTML5.tpl.php');
}
?>
