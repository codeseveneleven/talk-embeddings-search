<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$test = new Embedding();

$queen = $test->getEmbedding( 'queen');
$woman = $test->getEmbedding('woman');
$monarch = $test->getEmbedding('monarch');
$king  = $test->getEmbedding('king');
$man = $test->getEmbedding('man');
$summ = $test->vectoradd( $monarch, $woman);
$distance = $test->distance( $queen,$summ);
printf("\n\nDistance between Monarch + Woman and Queen %s\n\n",$distance);

$distance = $test->distance( $queen,$monarch);
printf("Distance between Monarch and Queen %s\n\n",$distance);
$distance = $test->distance( $queen,$woman);
printf("Distance between Woman and Queen %s\n\n",$distance);
//$distance = $test->distance( $queen,$king);
//printf("Distance between King and Queen %s\n\n",$distance);
//$distance = $test->distance( $woman,$man);
//printf("Distance between Man and Woman %s\n\n",$distance);
