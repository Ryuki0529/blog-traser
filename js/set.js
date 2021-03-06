$(function() {
    $('#sh-res-ani').fadeIn();
    $('#load-search-result').load('ajax/g-trend.html', function( $data, $status ) {
        if ( $status === 'success' ) {
            $('#sh-res-ani').fadeOut();
        }
    });
});

function searchRun() {
    let $keyword = $('#keyword').val();
    let $parent_words = $keyword.replace(/(\s|　)+/g, '.').split('.');
    $('#status-message-sh').text('検索結果を取得中');
    $('#sh-res-ani').fadeIn();
    $.ajax({
        url:'ajax/search-result.php',
        type:'POST',
        dataType: 'json', // json,xml,text,html
        data: "keyword=" + $keyword
    }).done( (data) => {
        loadSiteData( data.links, $parent_words );
    }).fail( (data) => {
        alert('通信エラー');
        console.log(data);
    }).always( (data) => {
    //
    });
    viewGTrendWord( $parent_words[0] );
    $('#re-search-put-text').val( $parent_words[0] );
}

function reSearchStart() {
    let $reWord = $('#re-search-put-text').val();
    viewGTrendWord( $reWord );
}

function loadSiteData( $url_array, $word_array ) {
    $('#status-message-sh').text('サイトリストを処理中');
    $.ajax({
        url:'ajax/load-site-data.php',
        type:'POST',
        dataType: 'html',
        data: { 'links' : $url_array, 'words' : $word_array }
    }).done( (data) => {
        $('#load-search-result').html(data);
        $('#sh-res-ani').fadeOut();
    }).fail( (data) => {
        $('#load-search-result').html('<p>通信エラーが発生したため、このリンクに対する解析は中断されました。</p>');
    });
}

function viewGTrendWord( $keyword ) {
    $('#td-res-wrap').slideDown();
    $('#load-trend-result').html(
        "<iframe src='ajax/load-trend-word.php?word=" + $keyword + "'></iframe>"
    );
}