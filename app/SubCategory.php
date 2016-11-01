<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends DynamoDbModel
{
    protected $table = 'SubCategories';
    protected $fillable = ['ParentCatID', 'SubCatsID', 'Active', 'Avatar', 'Name', 'Description', 'MaxUsers'];
    protected $primaryKey = 'SubCatsID';

    private static $getPathName = [];

    public static function getPathName($CatID)
    {
        if (!isset(self::$getPathName[$CatID])) {
            $SubCategories = self::find((int)$CatID);
            $Categories = Category::find((int)$SubCategories->ParentCatID);
            self::$getPathName[$CatID] = $Categories->Name . ' >> ' . $SubCategories->Name;
        }
        return self::$getPathName[$CatID];
    }
}
