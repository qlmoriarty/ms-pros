<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Database\Eloquent\Model;

class LastId extends DynamoDbModel
{
    protected $table = 'LastIds';
    protected $fillable = ['TableName', 'id'];
    protected $primaryKey = 'TableName';

    public static function get($class)
    {
        /** @var Category $class */
        $class = new $class();

        $r = self::find($class->getTable());
        if (!isset($r->id)) {
            $r = self::create(['TableName' => $class->getTable()]);
            $r->id = 1;
        }
        while (true) {
            if (empty($class::find($r->id))) {
                break;
            }
            $r->id++;
        }
        return $r;
    }
}
