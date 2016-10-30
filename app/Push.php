<?php

namespace App;


use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Push extends DynamoDbModel
{
    protected $table = 'News';
    protected $fillable = ['NewsID', 'DateAdd', 'ImageUrl', 'Text', 'Title'];
    protected $primaryKey = 'NewsID';
}
