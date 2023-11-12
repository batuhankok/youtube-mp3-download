<?php

//https://www.googleapis.com/youtube/v3/videos?part=snippet%2Cplayer&chart=mostPopular&locale=TR&regionCode=TR&key=AIzaSyAwonQ8E8KbZBwWWwBF8ARXqgnCOT8mn6o

$EVERY_X_HOUR = 12;
$YOUTUBE_DATA_API_TOKEN = '';
$MAX_RESULTS = 6;

$last_execution_time = fgets(fopen(__DIR__ . '/last_execution.txt', 'r'));
if ((time() - $last_execution_time) <= (60*60*$EVERY_X_HOUR)) {
  exit;
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2Cplayer&chart=mostPopular&locale=TR&regionCode=TR&maxResults=' . $MAX_RESULTS . '&key=' . $YOUTUBE_DATA_API_TOKEN);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$trends_response = curl_exec($curl);
curl_close($curl);

$trends_json_file = @fopen(__DIR__ . '/trends.json', 'wb');
@fwrite($trends_json_file, $trends_response);
@fclose($trends_json_file);

# UPDATE LAST EXECUTION TIME
$last_execution_time_file = @fopen(__DIR__ . '/last_execution.txt', 'wb');
@fwrite($last_execution_time_file, time());
@fclose($last_execution_time_file);
