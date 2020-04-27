<?php
@header('Content-Type: text/html; charset=utf-8');

if (empty($_GET['video_id'])) {
  die("Video ID boş bırakılamaz.");
}

require __DIR__.'/vendor/autoload.php';

use YouTube\YouTubeDownloader;

$yt = new YouTubeDownloader();

$url = "https://www.youtube.com/watch?v=" . $_GET['video_id'];
$links = $yt->getDownloadLinks($url);

$hd_exists = false;
$hd_url = "";

$video_link_array = [];
foreach ($links as $video_info) {

  if ($video_info['format'] == 'mp4, video, 360p, audio') {
    $video_link_array[] = array("quality" => "360", "url" => $video_info['url'], "size" => "", "file" => "mp4");
  } else if ($video_info['format'] == 'mp4, video, 480p, audio') {
    $video_link_array[] = array("quality" => "480", "url" => $video_info['url'], "size" => "", "file" => "mp4");
  } else if ($video_info['format'] == 'mp4, video, 720p, audio') {
    $hd_exists = true;
    $video_link_array[] = array("quality" => "720", "url" => $video_info['url'], "size" => "", "file" => "mp4");
  } else if ($video_info['format'] == 'mp4, video, 1024p, audio') {
    $video_link_array[] = array("quality" => "1024", "url" => $video_info['url'], "size" => "", "file" => "mp4");
  }

  $hd_url = $video_info['url'];
}

if (!$hd_exists) {
  $video_link_array[] = array("quality" => "720", "url" => $hd_url, "size" => "", "file" => "mp4");
}

$url = 'http://www.youtube.com/oembed?format=json&url=' . $url;
$json = json_decode(file_get_contents($url), true);

$detail_array = [
  'title' => str_replace("\n", "", strip_tags(trim($json['title']))),
  'thumb' => "http://img.youtube.com/vi/{$_GET['video_id']}/mqdefault.jpg",
  'link' => $video_link_array
];

print_r(json_encode($detail_array, JSON_UNESCAPED_UNICODE));