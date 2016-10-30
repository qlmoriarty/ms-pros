<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Database\Eloquent\Model;

class Setting extends DynamoDbModel
{
    protected $table = 'Settings';
    protected $fillable = ['Key', 'Value'];
    protected $primaryKey = 'Key';

    private static $getSetting = [];
    public static function getSetting()
    {
        if(empty(self::$getSetting )){
            foreach(self::all() as $setting){
                self::$getSetting[$setting->Key] = $setting->Value;
            }
        }
        return self::$getSetting ;
    }


}
