<?php

namespace App;
use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

 use Illuminate\Database\Eloquent\Model;

class Offs extends DynamoDbModel
{
    protected $table = 'Offers';
//    protected $fillable = ['OfferID', 'Active', 'Avatar', 'Busy', 'CatID', 'Contact', 'Cost', 'Created', 'Desc',  'Images', 'Name','Updated','UserID'];
    protected $fillable = ['OfferID','Active','Avatar','Busy','CatID','Contact','Cost','Created','Desc','Name','Updated','UserID'];
    protected $primaryKey = 'OfferID';

//    protected $compositeKey = ['OfferID', 'UserID', 'Created'];
}
