<?php

namespace App;
use Elasticquent\ElasticquentTrait;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	use ElasticquentTrait;
	
    protected $fillable = ['user_id', 'title', 'body', 'tags'];
	
	protected $mappingProperties = array(
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
		'title' => ['type' => 'text'],
        'body' => ['type' => 'text'],
        'tags' => ['type' => 'text'],
		'user' => [
			"type" => "nested",
			"properties" => [
				'name' => ['type' => 'text'],
				'email' => ['type' => 'text']
			]
		]
    );
	
	public function getIndexDocumentData()
    {
        return array(
            'id'	=> $this->id,
            'user_id'	=> $this->user_id,
            'title'	=> $this->title,
            'body'	=> $this->body,
            'tags'	=> $this->tags,
            'user'  => array(
				'name' 	=> $this->user->name,
				'email' => $this->user->email
			)
        );
    }
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}


