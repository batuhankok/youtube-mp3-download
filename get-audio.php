<?php

if (empty($_GET['video_id'])) {
  die("Video ID boş bırakılamaz.");
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.yt-mp3s.com/@api/json/mp3/' . $_GET['video_id']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$audio_response = curl_exec($curl);
curl_close($curl);

$audio_array = json_decode($audio_response, JSON_UNESCAPED_SLASHES);

$audio_link_array = [];
foreach ($audio_array['vidInfo'] as $audio_info) {
  $bitrate = [128, 256];
  if (in_array($audio_info['bitrate'], $bitrate)) {
    $audio_link_array[] = array("quality" => $audio_info['bitrate'], "url" => $audio_info['dloadUrl'], "size" => $audio_info['mp3size'], "file" => "MP3");
  }
}

$detail_array = [
  'title' => $audio_array['vidTitle'],
  'thumb' => $audio_array['vidThumb'],
  'link' => $audio_link_array
];

print_r(json_encode($detail_array));
