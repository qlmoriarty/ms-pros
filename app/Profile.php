<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profile extends DynamoDbModel
{

    protected $table = 'Profiles';
    protected $fillable = ['UserID', 'Active', 'Avatar', 'Contacts', 'Created', 'Description', 'NickName', 'Subscribe', 'Updated'];
    protected $primaryKey = 'UserID';

}
