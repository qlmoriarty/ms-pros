<?php

namespace App;

use App\Http\Controllers\CategoryController;
use BaoPham\DynamoDb\DynamoDbModel;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Message extends DynamoDbModel
{
    const DIRECTION_BEFORE = 'before';
    const DIRECTION_AFTER = 'after';

    protected $table = 'Messages';
    protected $fillable = ['MesID', 'From', 'To', 'DateAdd', 'Text', 'Readed'];
    protected $primaryKey = 'MesID';

    public static function get($id, $direction = self::DIRECTION_BEFORE, $last_time = null)
    {
        $Message = [];

        $period = 7;
        $time_itter = 0;

        while (true) {
            $find = 0;

            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $time_itter = <pre>' . print_r($time_itter, true) . "</pre><br>\n";
            if ($direction == self::DIRECTION_BEFORE) {
                if ($last_time == null) {
                    $time_a = Carbon::now()->subDay(($time_itter + 1) * $period);
                    $time_b = Carbon::now()->subDay($time_itter * $period);
                } else {
                    $time_a = Carbon::createFromTimestamp($last_time)->subDay(($time_itter + 1) * $period);
                    $time_b = Carbon::createFromTimestamp($last_time)->subDay($time_itter * $period);
                }
            }

            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $time_a = <pre>' . print_r($time_a->toDateTimeString(), true) . "</pre><br>\n";
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $time_b = <pre>' . print_r($time_b->toDateTimeString(), true) . "</pre><br>\n";

            /** @var Message $MessageFrom */
            $MessageFrom = self
                ::where('From', '=', 'Profiles:' . $id)
                ->where('To', '=', 'Users:' . Auth::id());
            if ($direction == self::DIRECTION_BEFORE) {
                $MessageFrom = $MessageFrom
                    ->where('DateAdd', '>', $time_a->timestamp)
                    ->where('DateAdd', '<=', $time_b->timestamp);
            } else {
                $MessageFrom = $MessageFrom
                    ->where('DateAdd', '>', Carbon::createFromTimestamp($last_time)->timestamp);
            }
            $MessageFrom = $MessageFrom->all();
            $MessageFromArray = $MessageFrom->toArray();
            foreach ($MessageFrom as $MessageFrom_) {
                if (!$MessageFrom_->Readed) {
                    $MessageFrom_->Readed = true;
                    $MessageFrom_->save();
                }
            }
            $Message = array_merge($Message, $MessageFromArray);
            $find += count($MessageFromArray);
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $MessageFrom = <pre>' . print_r($MessageFrom, true) . "</pre><br>\n";

            /** @var Message $MessageTo */
            $MessageTo = self
                ::where('To', '=', 'Profiles:' . $id)
                ->where('From', '=', 'Users:' . Auth::id());
            if ($direction == self::DIRECTION_BEFORE) {
                $MessageTo = $MessageTo
                    ->where('DateAdd', '>', $time_a->timestamp)
                    ->where('DateAdd', '<=', $time_b->timestamp);
            } else {
                $MessageTo = $MessageTo
                    ->where('DateAdd', '>', Carbon::createFromTimestamp($last_time)->timestamp);
            }
            $MessageTo = $MessageTo
                ->all()
                ->toArray();
            $Message = array_merge($Message, $MessageTo);
            $find += count($MessageTo);
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $MessageTo = <pre>' . print_r($MessageTo, true) . "</pre><br>\n";

            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $find = <pre>' . print_r($find, true) . "</pre><br>\n";

            $time_itter++;

            if ($find > 40 || $time_itter > 10 || $direction == self::DIRECTION_AFTER) {
                break;
            }
        }

        $From = Auth::user();
        $To = Profile::find($id);

        if (count($Message)) {
            CategoryController::sortBySubkey($Message, 'DateAdd');
            foreach ($Message as &$Message_) {
                $Message_['DateAddCarbon'] = Carbon::createFromTimestamp($Message_['DateAdd']);
                if (Carbon::now()->diffInMinutes($Message_['DateAddCarbon']) > 30) {
                    $Message_['DateAddCarbon'] = $Message_['DateAddCarbon']->format('H:i d.m.Y');
                } else {
                    $Message_['DateAddCarbon'] = $Message_['DateAddCarbon']->diffForHumans();
                }
                if (preg_match('/Users:/', $Message_['From'])) {
                    $Message_['User'] = [
                        'Name' => $From->name,
                        'Avatar' => false
                    ];
                } else {
                    $Message_['User'] = [
                        'Name' => $To->NickName,
                        'Avatar' => $To->Avatar
                    ];
                }

            }
        }
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $Message = <pre>' . print_r($Message, true) . "</pre><br>\n";

        return [
            'period' => $period,
            'last_time' => ($direction == self::DIRECTION_BEFORE) ? $time_a->timestamp : Carbon::now()->timestamp,
            'items' => $Message
        ];
    }

}
