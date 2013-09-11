<?php
  $titleTag = "Photo Gallery";

  // filetypes to display
  $imagetypes = array("image/jpeg");

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function getImages($dir)
  {
    global $imagetypes;

    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // full server path to directory
    $fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir";

    $d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;

      // check for image files
      $f = escapeshellarg("$fulldir$entry");
      $retval[] = array(
       'file' => "/$dir$entry",
       'size' => getimagesize("$fulldir$entry")
      );
    }
    $d->close();

    return $retval;
  }
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<html>
    <?php include("includes/html-head.php"); ?>
    <body id="gallery">
        <?php include("includes/header.php"); ?>
        
        <section>
        	<h2>Ultimate Easter Challenge 2012 Photo Gallery</h2>
        
       		<?php
      		  $thumbs = getImages("assets/images/gallery/thumbs");

      		  foreach($thumbs as $img) {
      		    $photoPath = str_replace('thumbs', 'photos', $img['file']);

              echo "<div class=\"photo\"><a href=\"{$photoPath}\" rel=\"shadowbox[UEC]\"><img src=\"{$img['file']}\" {$img['size'][3]} alt=\"\"></a></div>\n";
      		  }  
       		?> 
        </section>
        <script src="../../assets/js/shadowbox.js"></script>
        <script type="text/javascript">
        Shadowbox.init();
        </script>
    </body>
</html>