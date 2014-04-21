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
          <h2>Ultimate Easter Challenge 2012</h2>
        
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
                  Rampant Rabbits
                </td>
                <td>
                  12360
                </td>
              </tr>
              <tr class="second">
                <td>2</td>
                <td>
                  Hot Cross Bunnies
                </td>
                <td>
                  11920
                </td>
              </tr>
              <tr class="third">
                <td>3</td>
                <td>
                  El Chappelinis
                </td>
                <td>
                  10400
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>
                  The A Team
                </td>
                <td>
                  10050
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td>
                  Anita Phart (T/A The Jackson Five)
                </td>
                <td>
                  9245
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>
                  Cadbury's Heroes
                </td>
                <td>
                  9065
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td>
                  On It Like An Easter Bonnet
                </td>
                <td>
                  8520
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>
                  Spring Chickens 2: Return Of The Fearless
                </td>
                <td>
                  8080
                </td>
              </tr>
              <tr>
                <td>9</td>
                <td>
                  Wadhurst Eggstras
                </td>
                <td>
                  7055
                </td>
              </tr>
              <tr>
                <td>10</td>
                <td>
                  Team T.H.I.C.K
                </td>
                <td>
                  6885
                </td>
              </tr>
              <tr>
                <td>11</td>
                <td>
                  Team Dirty Gang
                </td>
                <td>
                  4950
                </td>
              </tr>
              <tr>
                <td>12</td>
                <td>
                  The Inbetweeners
                </td>
                <td>
                  2765
                </td>
              </tr>
            </tbody>
          </table>

          <h3>Photo Gallery</h3>

          <?php
            $thumbs = getImages("assets/images/gallery-2012/thumbs");

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