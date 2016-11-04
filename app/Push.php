<?php

namespace App;


use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Push extends DynamoDbModel
{
    private $title;
    private $msg;
    private $image;

    protected $table = 'News';
    protected $fillable = ['NewsID', 'DateAdd', 'ImageUrl', 'Text', 'Title'];
    protected $primaryKey = 'NewsID';

    protected $compositeKey = ['NewsID', 'DateAdd'];
}
