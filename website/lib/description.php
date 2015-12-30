<?php
// Copyright (c) Isaac Gouy 2015
// use to generate html to be cached


// LIBRARIES ////////////////////////////////////////////////

require_once(LIB_PATH.'lib_whitelist.php');
require_once(LIB);


// PAGE ////////////////////////////////////////////////

$Page = & new Template(LIB_PATH);


// GET_VARS ////////////////////////////////////////////////

list($Incl,$Excl) = WhiteListInEx();
$Tests = WhiteListUnique('test.csv',$Incl); // assume test.csv in name order

if (isset($_GET['test'])
      && strlen($_GET['test']) && (strlen($_GET['test']) <= NAME_LEN)){
   $X = $_GET['test'];
   if (ereg("^[a-z]+$",$X)){ $T = $X; }
}
$Available = isset($T) && isset($Tests[$T]) && isset($Incl[$T]);
if (!$Available){ $T = 'nbody'; }


// 200 OK ////////////////////////////////////////////////

if (FALSE && $Available){

$Body = & new Template(LIB_PATH);
$TemplateName = 'description.tpl.php';


// HEADER ////////////////////////////////////////////////

$TestName = $Tests[$T][TEST_NAME];
$Title = $TestName.' description ('.PLATFORM_NAME.')';


// META ////////////////////////////////////////////////

$keywords = '<meta name="description" content="What the '.$TestName.' benchmarks game programs should do ('.PLATFORM_NAME.')." />';

$robots = '<meta name="robots" content="noindex,nofollow,noarchive">';
if (SITE_NAME != 'u64q') {
   $LinkRelCanonical = '<link rel="canonical" href="../u64q/'.$T.'-description.html">';
}

$style = '<style><!-- 
a{color:black;text-decoration:none}article{padding: 0 0 2.9em}article,div,header{margin:auto;max-width:31em;width:92%}body{font:100% Droid Sans,Ubuntu,Verdana,sans-serif;margin:0;-webkit-text-size-adjust:100%}h1,h2,h3,nav li a{font-family:Ubuntu Mono,Consolas,Menlo,monospace}h1{font-size:1.4em;font-weight:bold;margin:0;padding:.4em}h1,h1 a{color:white}h2,h3{margin:1.5em 0 0}h2{font-size:1.4em;font-weight:normal}h3{font-size:1.2em}nav li{list-style-type:none;vertical-align:top}nav li a{display:block;font-size:1.2em;margin:.5em .5em 0;padding:.5em .5em .3em}nav p{margin:0 .5em}nav ul{clear:left;margin:-0.3em 0 1.5em;text-align:center}p{color:#333;line-height:1.4;margin:.3em 0 0}p a{border-bottom:.15em dotted #aaa}#u64,#u64q{background-color:#c90016}#u32{background-color:#ffb515}#u32q{background-color:#ff6309}@media only screen and (min-width:33em){nav li{display:inline-block}nav p{text-align:left;width:17em}}@media only screen and (min-width:60em){article,div,header{font-size:1.25em}}
--></style>';


// TEMPLATE VARS ////////////////////////////////////////////////

$Body->set('Description', HtmlFragment(DESC_PATH.$T.'-description.html'));
$Body->set('SelectedTest', $T);
$Body->set('Tests', $Tests);
$Body->set('Title', $Title);

$Page->set('Keywords', $keywords);
if (isset($LinkRelCanonical)) { $Page->set('LinkCanonical', $LinkRelCanonical); }
$Page->set('PageBody', $Body->fetch($TemplateName));
$Page->set('PageTitle', $Title.' | Computer Language Benchmarks Game');
$Page->set('Robots', $robots);
$Page->set('Style', $style);

echo $Page->fetch('pageHTML5.tpl.php');

// 404 Not Found ////////////////////////////////////////////////

} else {

echo $Page->fetch('page404HTML5.tpl.php');
}

?>
