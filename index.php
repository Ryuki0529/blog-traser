<?php
session_start();
$_SESSION['user'] = 'start';
require_once 'functions.php';
load_g_trend();
ob_start();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>ライバルサイトの文字数・検索ボリュームチェックツール｜BLOG TRASER</title>
        <meta name="description" content="BLOG TRASERを利用して、検索結果ライバルサイトの文字数・キーワード出現頻度・検索ボリュームを参照することができます。ブロガーやアフィリエイターの方、SEO対策ツールの１つとして利用してみてください！検索順位を少しでも上げたいという方もおすすめです！">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@prog_php" />
        <meta property="og:url" content="https://blog-traser.infoaxel.com" />
        <meta property="og:title" content="ライバルサイトの文字数・検索ボリュームチェックツール" />
        <meta property="og:description" content="検索結果ライバルサイトの文字数・キーワード出現頻度・検索ボリュームを参照することができます。" />
        <meta property="og:image" content="https://blog-traser.infoaxel.com/img/icon.png" />
        <link rel="stylesheet" href="css/main.min.css">
        <link rel="stylesheet" href="css/animate.min.css">
        <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/particles.min.js"></script>
        <script type="text/javascript" src="js/wow.min.js"></script>
        <script type="text/javascript">new WOW().init()</script>
    </head>
    <body class="wow fadeInUp" data-wow-duration="1.5s">
        <header id="particles" class="shadow">
            <div class="hd-wrap">
                <div class="container">
                    <h1>BLOG TRASER</h1>
                </div>
            </div>
        </header>
        <div class="inner margin">
        <div class="container design">
            <h1 style="text-align:center;">検索結果を取得</h1>
            <center><p>検索結果上位１０件のサイトを分析します。</p></center>
            <form class="search-box" action="" method="post" onsubmit="return false;">
                <input type="search" id="keyword" placeholder="対象のキーワードを入力" name="keyword">
                <input type="button" name="search" onclick="searchRun()" value="分析開始">
            </form>
            <div class="load-search-res-wrap">
                <div class="load-search-res-content">
                    <div class="loading-effect" id="sh-res-ani">
                        <div class="loading-img">
                            <img src="img/loading.svg" alt="ローディング画像">
                            <span id="status-message-sh">・・読込中・・</span>
                        </div>
                    </div>
                    <div id="load-search-result"></div>
                </div>
            </div>
            <div class="load-search-res-wrap hidden" id="td-res-wrap" data-is_hide="true">
                <div class="re-serch-trend-element">
                    <div class="tips-text">
                        デフォルトでは親キーワードの指標を表示しますが、
                        更に掘り下げて表示したい場合は、こちらで再検索してください。
                    </div>
                    <div class="re-search-box">
                        <input type="search" id="re-search-put-text" placeholder="再検索するキーワードを入力">
                        <button type="button" onclick="reSearchStart()">再表示</button>
                    </div>
                </div>
                <div class="load-search-res-content trend">
                    <div class="loading-effect" id="trend-res-ani">
                        <div class="loading-img">
                            <img src="img/loading.svg" alt="ローディング画像">
                            <span id="status-message-td">・・読込中・・</span>
                        </div>
                    </div>
                    <div id="load-trend-result"></div>
                </div>
            </div>
            <div class="notes-content">
                <h2>留意事項</h2>
                <ul>
                    <li>
                        当サービスでは、対象とする検索エンジンから結果を取得していますが、
                        検索結果はCookie（クッキー）やGoogle・Yahooの利用状況によって
                        多少変動することがありますので、常に厳密な順位を提供できるものではありません。
                    </li>
                    <li>
                        当サービスへのアクセスが爆発的に増加した場合には、
                        負荷軽減のためアクセス制限を行うことがあります。
                        多数ユーザーからの同時アクセス時には、リクエストの送信時に排他制御を行い、
                        ５秒程度の待機幅を設けます。取得までに時間を要することがありますのでご了承ください。
                    </li>
                    <li>
                        キーワードの検索ボリュームのデータ・グラフはGoogleトレンドのAPIを利用していますが、
                        モバイル端末からの読み込み時に表示されないことが多々あります。
                        当サービスでは、基本的にPC操作重視で製作しているため、PCからのご利用をおすすめします。
                    </li>
                    <li>
                        当サービスへのご意見・要望・お問い合わせは
                        <a href="https://twitter.com/prog_php" target="_blank">Twitter（@prog_php）</a>
                        にお願いします。
                    </li>
                </ul>
            </div>
        </div>
        </div>
        <footer>
            <small>Copyright © BLOG TRASER All Rights Reserved.</small>
        </footer>
        <script type="text/javascript" src="js/particles.setting.min.js"></script>
        <script type="text/javascript" src="js/set.min.js"></script>
    </body>
</html>
<?php
$data = ob_get_clean();
echo sanitize_output( $data );
?>