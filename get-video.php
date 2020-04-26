<?php

if (empty($_GET['video_id'])) {
  die("Video ID boş bırakılamaz.");
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.yt-mp3s.com/@api/json/videostreams/' . $_GET['video_id']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$video_response = curl_exec($curl);
curl_close($curl);

$video_array = json_decode($video_response, JSON_UNESCAPED_SLASHES);

$video_link_array = [];
foreach ($video_array['vidInfo'] as $video_info) {
  $quality_array = ['1080', '720', '480'];
  $file_type_array = ['mp4'];
  if (in_array($video_info['quality'], $quality_array) && in_array($video_info['ftype'], $file_type_array)) {
    $video_link_array[] = array("quality" => $video_info['quality'], "url" => $video_info['dloadUrl'], "size" => $video_info['rSize'], "file" => $video_info['ftype']);
  }
}

$detail_array = [
  'title' => $video_array['vidTitle'],
  'thumb' => $video_array['vidThumb'],
  'link' => $video_link_array
];

print_r(json_encode($detail_array));
