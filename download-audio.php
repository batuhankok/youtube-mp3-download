<?php
  $file = urldecode($_GET['file']);
  $filename = urldecode($_GET['filename']);
  header('Content-type: octet/stream');
  header('Content-disposition: attachment; filename='.$filename.'.mp4;');
  readfile($file);
  exit;
?>
  
