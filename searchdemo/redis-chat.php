<?php

use Predis\Command\Argument\Search\SearchArguments;
use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$fp = fopen('php://stdin', 'rb');
echo "What is your question?\n";
while ($text = fgets($fp)) {
	$text = trim($text);
	if (strtolower($text) === 'exit') {
		exit(0);
	}
	if(empty($text)) {
		continue;
	}
	$embedding = new Embedding();

	//$text = $argv[1];

	$textEmbedding = $embedding->getEmbedding( $text );

	$client = new Predis\Client( [
		'port' => 6378
	] );

	$searchArguments = new SearchArguments();
	$searchArguments
		->dialect( 2 )
		->sortBy( '__vector_score' )
		->addReturn( 6, '__vector_score', 'uid', 'text','table','pid','slug' )
		->params( [ 'query_vector', pack( 'f1536', ... $textEmbedding ) ] );

    $raw =  $client->ftsearch( 'idx:MYINDEX', '(*)=>[KNN 3 @vector $query_vector]', $searchArguments );

	$result = $embedding->normalizeRedisResult( $raw);
	foreach ($result as $key => $row) {
		echo "\n\n",wordwrap($row['text']),"\n",$row['slug'],"\n\n";
	}
	echo "What is your question?\n";
}
// */


