<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Article;
use App\User;

Route::get('/', function () {
		
    //Article::deleteIndex();		
    Article::createIndex($shards = null, $replicas = null);

    //Article::deleteMapping();
    Article::putMapping($ignoreConflicts = true);
    //Article::rebuildMapping();

    Article::addAllToIndex();

    return view('welcome');
});


Route::get('/search', function() {
	//$articles = Article::search('a');
    //$articles = Article::searchByQuery(['match' => ['title' => 'Sed']]); // working
    //$articles = Article::searchByQuery(['match' => ['body' => 'a']]); // working
    //$articles = Article::searchByQuery(['match' => ['nested' => ['user' => ['email' => 'susan88@example.net']]]]); // not work
	
	
    $articles = Article::complexSearch(
		["body" => ["query" => ["bool" => ["must" => [
				["match" => ["title" => "aut"]],
				["nested" => [
					"path" => "user",
					"query" => ["bool" => ["must" => [
						["match" => ["user.name" => "PhD"]]
					]]]
				]]
		]]]]]
	);
	
    return $articles;
});


/*
		["body" => ["query" => ["bool" => ["must" => [
				["match" => ["title" => "aut"]],
				["nested" => [
					"path" => "user",
					"query" => ["bool" => ["must" => [
						["match" => ["user.name" => "PhD"]]
					]]]
				]]
		]]]]]



		["body" => ["query" => ["bool" => ["must" => [
				["match" => ["title" => "Quae"]]
		]]]]]



		["body" => ["query" => ["bool" => ["must" => [
				["nested" => [
					"path" => "user",
					"query" => ["bool" => ["must" => [
						["match" => ["user.name" => "PhD"]]
					]]]
				]]
		]]]]]
*/

