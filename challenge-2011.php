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
        	<h2>Ultimate Easter Challenge 2011</h2>
        
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
                  The Eggs Ray Department
                </td>
                <td>
                  9090
                </td>
              </tr>
              <tr class="second">
                <td>2</td>
                <td>
                  The Eggsplorers
                </td>
                <td>
                  8950
                </td>
              </tr>
              <tr class="third">
                <td>3</td>
                <td>
                  Three Legged Donkey
                </td>
                <td>
                  8600
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>
                  Great Eggspectations
                </td>
                <td>
                  8490
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td>
                  No longer Spring Chickens
                </td>
                <td>
                  8450
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>
                  The Eggstremists
                </td>
                <td>
                  8145
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td>
                  Eggstra Special
                </td>
                <td>
                  7610
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>
                  Brothers and Sisters
                </td>
                <td>
                  2950
                </td>
              </tr>
            </tbody>
          </table>

          <h3>Photo Gallery</h3>

       		<?php
      		  $thumbs = getImages("assets/images/gallery-2011/thumbs");

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