<?php session_start(); ?>
<?php if ( $_SESSION['user'] === 'start' ): ?>
<?php $word = $_GET['word'] ?>
<link rel="stylesheet" href="../css/g-trend-sh.min.css">
<div class="g-trend-searchres">
  <div class="popular-index">
    <h3>キーワードの人気度の動向</h3>
    <script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/2152_RC04/embed_loader.js"></script>
    <script type="text/javascript">
      trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"<?php echo $word ?>","geo":"JP","time":"today 5-y"}],"category":0,"property":""}, {"exploreQuery":"date=today%205-y&geo=JP&q=<?php echo urlencode($word) ?>","guestPath":"https://trends.google.co.jp:443/trends/embed/"});
    </script>
  </div>
  <div class="area-index">
    <h3>地域別の人気度割合</h3>
    <script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/2152_RC04/embed_loader.js"></script>
    <script type="text/javascript">
      trends.embed.renderExploreWidget("GEO_MAP", {"comparisonItem":[{"keyword":"<?php echo $word ?>","geo":"JP","time":"today 5-y"}],"category":0,"property":""}, {"exploreQuery":"q=<?php echo urlencode($word) ?>&date=today%205-y&geo=JP","guestPath":"https://trends.google.co.jp:443/trends/embed/"});
    </script>
  </div>
  <div class="searchengine-index">
    <h3>関連する人気キーワード一覧</h3>
    <script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/2152_RC04/embed_loader.js"></script>
    <script type="text/javascript">
      trends.embed.renderExploreWidget("RELATED_QUERIES", {"comparisonItem":[{"keyword":"<?php echo $word ?>","geo":"JP","time":"today 5-y"}],"category":0,"property":""}, {"exploreQuery":"date=today%205-y&geo=JP&q=<?php echo urlencode($word) ?>","guestPath":"https://trends.google.co.jp:443/trends/embed/"});
    </script>
  </div>
</div>
<?php endif; ?>