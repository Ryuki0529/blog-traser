<?php
session_start();
if ( $_SESSION['user'] === 'start' ):

require_once '../functions.php';

if (isset($_POST['keyword'])) {
    require_once("../phpQuery-onefile.php");

    $keyword = urlencode($_POST['keyword']);
    $limiterNum = 0;
    while ( $limiterNum <= 2000 ) {
        if ( !file_exists("../lockflag/yahoo-sh-19990529.lock") ) {
            file_put_contents('../lockflag/yahoo-sh-19990529.lock', 'locking...');
            file_put_contents(
                '../lockflag/keylog-19990529.log',
                $_POST['keyword'].','.date('Y-m-d H:i:s').',IP-'.$_SERVER["REMOTE_ADDR"].',Agent:'.$_SERVER['HTTP_USER_AGENT']."\n", FILE_APPEND
            );
            $content = curl_result('https://search.yahoo.co.jp/search?p='.$keyword.'&ei=UTF-8');
            if (strpos(PHP_OS, 'WIN')!==false) {
                $fp = popen('start php ../lockflag/yahoo-sh-unlock.php', 'r');
                pclose($fp);
            } else {
                exec('php ../lockflag/yahoo-sh-unlock.php >/dev/null 2>&1 &');
            }
            break;
        }
        usleep( 500000 );
        $limiterNum++;
    }

    $links = array();
    if ( isset($content) ) {
        $html = phpQuery::newDocument($content);

        $res = $html->find('.Contents__innerGroupBody')->find('.sw-CardBase .Algo');

        foreach( $res as $title){
            $t = pq($title);
            $section = $t->find(".sw-Card__title--cite");
            //$title = $section->find('h3')->text();
            $link = $section->find('a')->attr('href');
            $links[] = $link;
            //echo "<a href='".$link."' target='_blank'>".$title."</a><br/>".PHP_EOL;
        }
    }else {
        $links = ['https://www.infoaxel.com/make-matomesaito-wp/'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(array('links' => $links, 'count' => $limiterNum));
}
endif;
?>