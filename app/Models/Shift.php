<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use Carbon\Carbon;
use App\Services\DayService;
use Log;
use DB;

class Shift extends Model
{
    const TABLENAME = 'shifts';
    protected $table = self::TABLENAME;

    


}
