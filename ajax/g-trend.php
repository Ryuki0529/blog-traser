<h3>Googleリアルタイムトレンド</h3>
<?php
$feed = file_get_contents('https://trends.google.co.jp/trends/trendingsearches/daily/rss?geo=JP');

$invalid_characters = '/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/';
$feed = preg_replace($invalid_characters, '', $feed);

$rss = simplexml_load_string($feed, 'SimpleXMLElement', LIBXML_NOCDATA);

$num = 1;
foreach($rss->channel->item as $item): ?>
<div class="search-list-content">
    <div class="number-text"><?php echo $num ?></div>
    <div class="trend-word">
        <span class="word-text"><?php echo $item->title ?></span>
        <span class="post-link">
            <a href="<?php echo $item->children('ht', true)->news_item->children('ht', true)->news_item_url ?>" target="_blank">
                <?php echo $item->children('ht', true)->news_item->children('ht', true)->news_item_title ?>
            </a>
            <span class="source-text">
                <?php echo $item->children('ht', true)->news_item->children('ht', true)->news_item_source ?>
            </span>
            <span class="pubdate-text">
                <?php echo date('n月d日H時i分',  strtotime( $item->pubDate )) ?>
            </span>
        </span>
    </div>
    <div class="traffic-data">
        <?php echo $item->children('ht', true)->approx_traffic ?>
    </div>
</div>
<?php $num++; endforeach;
//header("Content-type: text/html; charset=UTF-8");
?>