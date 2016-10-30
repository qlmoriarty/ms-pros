<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Offer extends DynamoDbModel
{

    protected $table = 'Offers';
    protected $fillable = ['UserID', 'Active', 'Busy', 'CatID', 'Name', 'Updated', 'OfferID', 'Avatar'];
    protected $primaryKey = 'OfferID';

}
