<?php session_start(); ?>
<?php if ( $_SESSION['user'] === 'start' ): ?>
<h3>分析結果を表示</h3>
<div class="search-list-content">
    <div class="number-text label">順位</div>
    <div class="page-title label">ページタイトル</div>
    <div class="str-num-text label">文字数</div>
    <div class="show-word-info label">ワード出現数/割合</div>
</div>
<?php
require_once '../functions.php';

if ( isset($_POST['links']) && isset($_POST['words']) ) {
    require_once("../phpQuery-onefile.php");

    $num = 0; $successIndex = 0; $totalStrNum = 0;
    $links = $_POST['links'];
    $words = $_POST['words'];
    foreach( $links as $link ) {
        $num++;
        $content = mb_convert_encoding(curl_result($link), 'HTML-ENTITIES', 'Shift_JIS, UTF-8');
        //$content = curl_result($link);
        $content =  preg_replace('/^<\?xml.*\?>/', '', $content);
        $html = phpQuery::newDocument($content);
        $pageTitle = $html->find('title'); $pageTitle = pq($pageTitle);
        $mainDom = $html->find('main'); $mainDom = pq($mainDom);
        if ($mainDom->text() === "") {
            $mainDom = $html->find('body'); $mainDom = pq($mainDom);
            $textData = preg_replace( '/(\s|　)/', '', $mainDom->text() );
            $strNum = floor( mb_strlen( $textData, 'UTF-8') * 0.8 );
        }else {
            $textData = preg_replace( '/(\s|　)/', '', $mainDom->text() );
            $strNum = mb_strlen( $textData, 'UTF-8' );
        }
        //file_put_contents('text'.$num.'.txt', preg_replace( '/(\s|　)/', '', $mainDom->text() ));
        if ( strlen( $link ) >= 71 ) {
            $showLink = substr( $link, 0, 70 ).'...';
        }else $showLink = $link;
        $totalStrNum += $strNum; $successIndex++;

        $wordMetaList = array(); $allProportion = 0; $matchNumSum = 0;
        foreach ( $words as $word ) {
            $wordMetaList[ $word ] = substr_count( $textData, $word );
            $matchNumSum += $wordMetaList[ $word ];
        }
        $allProportion = round( ( $matchNumSum / $strNum ) * 100, 2 );
        ?>

        <div class="search-list-content">
            <div class="number-text"><?php echo $num ?></div>
            <div class="page-title">
                <?php echo "<a href='".$link."' target='_blank'>".$pageTitle->text()."</a>"; ?>
                <span><?php echo $showLink ?></span>
            </div>
            <div class="str-num-text">
                <?php echo $strNum.' 字' ?>
                <?php //echo mb_detect_encoding($content, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS') ?>
            </div>
            <div class="show-word-info">
                <?php echo $matchNumSum ?> / <?php echo $allProportion ?> %
            </div>
        </div>
    <?php }
    echo "<span class='str-average'>平均：".floor($totalStrNum / $successIndex)." 文字</span>";
}
endif;
?>