<?php

namespace App;
use Elasticquent\ElasticquentTrait;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	use ElasticquentTrait;
	
    protected $fillable = ['user_id', 'title', 'body', 'tags'];
	
	protected $mappingProperties = array(
        'user_id' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
		'title' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'body' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'tags' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
		'user' => [
			"type" => "nested",
			"properties" => [
				'name' => [
					'type' => 'text',
					"analyzer" => "standard",
				],
				'email' => [
					'type' => 'text',
					"analyzer" => "standard",
				]
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


