<?php
/**
 * yt-feed.php — returns the latest videos from the Stockbazaari YouTube channel as JSON.
 * No API key needed (reads YouTube's public RSS feed). Cached for 1 hour on the server.
 * Upload next to the landing page and set  YT_FEED_URL: "/yt-feed.php"  in SB_CONFIG.
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=1800');

$channelId = 'UC68nemIejmqqzYfIlNmSRiA';   // @niftysensexbystockbazari
$limit     = 8;
$cacheFile = sys_get_temp_dir() . '/sb_yt_feed.json';
$ttl       = 3600;

if (is_file($cacheFile) && time() - filemtime($cacheFile) < $ttl) {
    readfile($cacheFile);
    exit;
}

$ctx = stream_context_create(['http' => ['timeout' => 8, 'user_agent' => 'Mozilla/5.0']]);
$xml = @file_get_contents('https://www.youtube.com/feeds/videos.xml?channel_id=' . $channelId, false, $ctx);
if ($xml === false) {
    if (is_file($cacheFile)) { readfile($cacheFile); exit; }   // serve stale cache if YouTube is unreachable
    http_response_code(502); echo '[]'; exit;
}

$feed = @simplexml_load_string($xml);
$out  = [];
if ($feed) {
    $feed->registerXPathNamespace('yt', 'http://www.youtube.com/xml/schemas/2015');
    foreach ($feed->entry as $entry) {
        $yt = $entry->children('http://www.youtube.com/xml/schemas/2015');
        $out[] = [
            'id'        => (string) $yt->videoId,
            'title'     => (string) $entry->title,
            'published' => (string) $entry->published,
        ];
        if (count($out) >= $limit) break;
    }
}

$json = json_encode($out, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
@file_put_contents($cacheFile, $json);
echo $json;
