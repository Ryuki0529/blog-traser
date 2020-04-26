<?php
// DOM取得モジュール
function curl_result( $url ){
    //サイトから情報を取得します。
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL,$url);
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
    //curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
    //curl_setopt($ch, CURLOPT_PROXY, 'http://147.157.2.20');

    curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0' );

    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($ch,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION, TRUE);

    $result = curl_exec( $ch );
    curl_close( $ch );

    if(isset($result) && $result!="" ){
        $result = str_replace(array("\r", "\n"), '', $result); // スクレイピングする際に改行が入ると邪魔だったので、改行を削除しました。改行を保持したい場合にはこの一行を消してください。
        return $result;
    }else{
        return false;
    }
}

// リアルタイムトレンド取得
function load_g_trend() {
    $progressTime = floor( (time() - filemtime( 'ajax/g-trend.html' )) / 60 );
    if ( $progressTime >= 1800 ) {
        ob_start();
        require_once 'ajax/g-trend.php';
        $data = ob_get_clean();
        file_put_contents( 'ajax/g-trend.html', $data );
    }
}

// HTML圧縮
function sanitize_output( $buffer ) {
	$search = array(
		'/\>[^\S ]+/s',       // strip whitespaces after tags, except space
		'/[^\S ]+\</s',       // strip whitespaces before tags, except space
        '/(\s)+/s',           // shorten multiple whitespace sequences
        '/<!--[\s\S]*?-->/s'  // コメントを削除
	);
	$replace = array(
		'>',
		'<',
        '\\1',
        ''
	);
	$buffer = preg_replace($search, $replace, $buffer);
	return $buffer;
}