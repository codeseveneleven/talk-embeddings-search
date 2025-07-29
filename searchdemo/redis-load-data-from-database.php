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
$table = $argv[4] ?? 'tt_content';

$pdo = new PDO('mysql:host=127.0.0.1;dbname='.$db, getenv('DBUSER'), getenv('DBPASS'));

$res = $pdo->query('select p.title,p.slug,tt.* from tt_content tt 
join pages p on tt.pid=p.uid 
where tt.deleted=0 and tt.hidden=0 and bodytext !="" and p.uid in (
select pages.uid  from pages 
left join pages p1 on pages.pid=p1.uid
left join pages p2 on p1.pid=p2.uid
left join pages p3 on p2.pid=p3.uid
left join pages p4 on p3.pid=p4.uid
left join pages p5 on p4.pid=p5.uid
left join pages p6 on p5.pid=p6.uid
where (pages.uid='.$pid.' or p1.uid='.$pid.' or p2.uid='.$pid.' or p3.uid='.$pid.' or p4.uid='.$pid.' or p5.uid='.$pid.' or p6.uid='.$pid.') and pages.deleted=0
)
');
$res->execute();

while($row = $res->fetch(PDO::FETCH_ASSOC)) {
	//print_r( $row);

    printf("%s : %d / %d\n",$db,$row['pid'],$row['uid']);

	$text = sprintf("%s\n%s\n%s",$row['title'],$row['header'],strip_tags( $row['bodytext']));

	$key = 'MYINDEX:'.$db.':'.$table.':'.$row['uid'];
	$set = [
		'uid'=>$row['uid'],
		'pid'=>$row['pid'],
		'slug'=>$base.$row['slug'],
		'table'=>$table,
		'text' => $text,
		'embedding'=>$embedding->getEmbedding( $text)
	];

	$client->jsonset( $key, '$', json_encode($set) );

	echo $key,"\n";
}

