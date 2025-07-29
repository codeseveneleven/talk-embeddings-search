<?php

use Predis\Command\Argument\Search\SearchArguments;
use SUDHAUS7\Embeddings\Embedding;

require_once '../vendor/autoload.php';

header('Content-type: application/json');

$embedding = new Embedding();
$textEmbedding = $embedding->getEmbedding( $_POST['search'] );
$client = new Predis\Client( [
    'port' => 6378
] );
$searchArguments = new SearchArguments();
$searchArguments
    ->dialect( 2 ) // must be 2 for vector
    ->sortBy( '__vector_score' )
    ->addReturn( 6, '__vector_score', 'uid', 'text','table','pid','slug' )
    ->limit( 0 , 10)
    ->params( [ 'query_vector', pack( 'f1536', ... $textEmbedding ) ] );

$results = $embedding->normalizeRedisResult( $client->ftsearch( 'idx:MYINDEX', '(*)=>[KNN 100 @vector $query_vector]', $searchArguments ) );

$return = [];
foreach($results as $key=>$result) {
    $result['id']=$key;
    $text = wordwrap($result['text'],350,"@@@",true);
    $text = explode("@@@",$text)[0];
    $result['text']=nl2br($text);
    $return[] = $result;
}

echo json_encode($return);
