<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends DynamoDbModel implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Notifiable;
    use \Illuminate\Auth\Authenticatable;

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';

    protected $table = 'Users';
    protected $fillable = ['UserId', 'name', 'email', 'password'];
    protected $primaryKey = 'UserId';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
