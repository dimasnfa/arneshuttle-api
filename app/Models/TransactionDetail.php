<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulePlan extends Model
{
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'schedule_id', 'id'); 
    }
}
