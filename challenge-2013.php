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
          <h2>Ultimate Easter Challenge 2013</h2>
        
          <h3>Score Card</h3>

          <table>
            <thead>
              <tr>
                <th>
                  Rank
                </th>
                <th>
                  Team Name
                </th>
                <th>
                  Points
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="first">
                <td>1</td>
                <td>
                  Trigger Happy Bunnies
                </td>
                <td>
                  8630
                </td>
              </tr>
              <tr class="second">
                <td>2</td>
                <td>
                  3rd Time Clucky
                </td>
                <td>
                  8330
                </td>
              </tr>
              <tr class="third">
                <td>3</td>
                <td>
                  El Chapelinis
                </td>
                <td>
                  8120
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>
                  The Egg-Stra Specials
                </td>
                <td>
                  7580
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td>
                  The Aldrenators
                </td>
                <td>
                  7050
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>
                  Cadbury Heroes!
                </td>
                <td>
                  6950
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td>
                  The Baa-Barians
                </td>
                <td>
                  6450
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>
                  Alcohooligans!
                </td>
                <td>
                  6025
                </td>
              </tr>
              <tr>
                <td>9</td>
                <td>
                  Team Jpeg
                </td>
                <td>
                  5325
                </td>
              </tr>
              <tr>
                <td>10</td>
                <td>
                  Gold Members
                </td>
                <td>
                  4695
                </td>
              </tr>
              <tr>
                <td>11</td>
                <td>
                  The Country Bumpkins
                </td>
                <td>
                  4415
                </td>
              </tr>
              <tr>
                <td>12</td>
                <td>
                  The Original Blue Pills
                </td>
                <td>
                  2810
                </td>
              </tr>
            </tbody>
          </table>

          <h3>Photo Gallery</h3>
        
       		<?php
      		  $thumbs = getImages("assets/images/gallery-2013/thumbs");

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