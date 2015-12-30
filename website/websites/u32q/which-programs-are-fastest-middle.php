<?php
header('Pragma: public');
header("Cache-Control: maxage=691200,public");
header("Content-type: image/svg+xml");
header("Content-Encoding: gzip");
readfile('which-programs-are-fastest-middle.svgz');
?>
