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
    return view('welcome');
});


Route::get('/index/create', function () {
    Article::createIndex($shards = null, $replicas = null);
})->name('index.create');

Route::get('/index/delete', function () {
    Article::deleteIndex();	// Delete entire Elastic indexing
})->name('index.delete');

Route::get('/index/add', function () {
    Article::addAllToIndex();
})->name('index.add');


Route::get('/mapping/create', function () {
    Article::putMapping($ignoreConflicts = true);
})->name('mapping.create');

Route::get('/mapping/delete', function () {
    Article::deleteMapping();
})->name('mapping.delete');

Route::get('/mapping/rebuild', function () {
    Article::rebuildMapping();
})->name('mapping.rebuild');






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
	
	foreach($articles as $article){
		echo $article['user']['name'].'<br>';
	}
	
	//print_r($articles);exit();
    return $articles;
})->name('search');


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

