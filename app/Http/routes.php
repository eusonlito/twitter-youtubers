<?php
$app->get('/', ['as' => 'index', 'uses' => 'Controller@index']);
$app->get('/profile-shares', ['as' => 'profile-shares', 'uses' => 'Controller@profileShares']);
$app->get('/profile/{id}', ['as' => 'profile', 'uses' => 'Controller@profile']);
$app->get('/url-shares', ['as' => 'url-shares', 'uses' => 'Controller@urlShares']);
$app->get('/url/{id}', ['as' => 'url', 'uses' => 'Controller@url']);
$app->get('/media-links', ['as' => 'media-links', 'uses' => 'Controller@mediaLinks']);
$app->get('/media-shares', ['as' => 'media-shares', 'uses' => 'Controller@mediaShares']);
$app->get('/media/{id}', ['as' => 'media', 'uses' => 'Controller@media']);