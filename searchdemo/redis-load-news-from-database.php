<?php

use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$embedding = new Embedding();

$client = new Predis\Client([
	'port'=>6378
]);


$db = $argv[1];
$pid = $argv[2];
$base = $argv[3];


$pdo = new PDO('mysql:host=127.0.0.1;dbname='.$db, getenv('DBUSER'), getenv('DBPASS'));

$res = $pdo->query('select * from tx_news_domain_model_news where deleted=0 and hidden=0 and pid='.$pid);
$res->execute();

while($row = $res->fetch(PDO::FETCH_ASSOC)) {
	//print_r( $row);

    dowrite(
        'MYINDEX:'.$db.':tx_news_domain_model_news:'.$row['uid'],
        $row['uid'],
        $row['pid'],
        $base.$row['path_segment'],
        'tx_news_domain_model_news',
        sprintf("%s\n%s\n%s",$row['title'] ?? '',$row['header'] ?? '',strip_tags( $row['teaser']))
    );


    $text = strip_tags( $row['bodytext']);

    if (!empty($text)) {

        dowrite(
            'MYINDEX:' . $db . ':tx_news_domain_model_news:' . $row['uid'] . ':bodytext',
            $row['uid'],
            $row['pid'],
            $base.$row['path_segment'],
            'tx_news_domain_model_news',
            $text
        );

    }

    $res2 = $pdo->query('select * from tt_content where deleted=0 and hidden=0 and tx_news_related_news='.$row['uid']);
    $res2->execute();
    while($row2 = $res2->fetch(PDO::FETCH_ASSOC)) {
        dowrite(
            'MYINDEX:'.$db.':tt_content:'.$row2['uid'],
            $row2['uid'],
            $row2['pid'],
            $base.$row['path_segment'],
            'tt_content',
            $text
        );
    }

}

function dowrite($key,$uid,$pid,$slug,$table,$text) {
    $set = [
        'uid'=>$uid,
        'pid'=>$pid,
        'slug'=>$slug,
        'table'=>$table,
        'text' => $text,
        'embedding'=>$GLOBALS['embedding']->getEmbedding( $text)
    ];


    $GLOBALS['client']->jsonset( $key, '$', json_encode($set) );

    echo $key,"\n";
}
