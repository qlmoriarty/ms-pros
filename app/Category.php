<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Database\Eloquent\Model;

class Category extends DynamoDbModel
{
    protected $table = 'Categories';
    protected $fillable = ['CatID', 'Active', 'Avatar', 'Name', 'Description', 'MaxUsers'];
    protected $primaryKey = 'CatID';
}
