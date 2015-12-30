<?   // Copyright (c) Isaac Gouy 2004-2015 ?>
<article>
  <div>
    <h2><?=$Title;?></h2>
    <aside>
      <p><a href="<?=$DescriptionURL;?>">description</a>
    </aside>
  </div>
  <section>
    </div>
      <h3>source code</h3>
    </div>
    <pre>
<?=$Code;?>
    </pre>
  </section>
  <section>
    <h3 id="log">notes, command-line, and program output</h3>
    <pre>
NOTES:
<?=PLATFORM_NAME;?>

<?=$Version;?>

<?=$Log;?>
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
