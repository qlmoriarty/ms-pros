<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ajax_DT_Avatar($data)
    {
        if (empty($data->Avatar)) {
            return '';
        } else {
            return '<img src="' . $data->Avatar . '" style="max-width: 100px;max-height: 100px;">';
        }
    }

    public function ajax_DT_Active($data)
    {
        return ($data->Active) ? UniversalConstant::TITLE_YES : UniversalConstant::TITLE_NO;
    }
}
