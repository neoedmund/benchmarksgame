<?php
ob_start();
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width,initial-scale=1">
<?
echo $Robots, "\n", $Keywords, "\n", "<title>", $PageTitle, " </title>\n";
echo $Style, "\n", '<link rel="shortcut icon" href="./favicon.ico">', "\n";
if (isset($LinkCanonical)) { echo $LinkCanonical, "\n"; }
?>
<header id="top">
  <h1 id="<?=SITE_NAME;?>"><a href="<?=CORE_SITE;?>">The&nbsp;Computer&nbsp;Language<br>Benchmarks&nbsp;Game</a></h1>
</header>
<?=$PageBody;?>
<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', 'UA-37137205-1', 'auto');
ga('send', 'pageview');
</script>
<script async src='//www.google-analytics.com/analytics.js'></script>
<?php
 ob_end_flush();
?>
