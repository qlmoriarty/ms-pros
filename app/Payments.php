<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Payments extends DynamoDbModel
{
    protected $table = 'Payments';
    protected $fillable = ['UserID', 'DateAdd', 'Subscribe', 'Value'];
    protected $primaryKey = 'UserID';

    protected $dynamoDbIndexKeys = [
        'count_index' => 'count',
    ];
}
