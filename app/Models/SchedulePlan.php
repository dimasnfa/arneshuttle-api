<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulePlan extends Model
{
    use HasFactory;

    protected $table = 'schedule_plans';

    protected $fillable = [
        'manifest_code',
        'trip_code',
        'depart',
        'schedule_id',
        'schedule_extra_id',
        'date',
        'etd',
        'vehicle_list_id',
        'vehicle_data',
        'driver_data',
        'driver_id',
        'fuel',
        'tol',
        'driver_funds',
        'additional_funds',
        'additional_note',
        'total_funds',
        'admin_id',
        'lateness',
        'in_minutes',
        'status',
        'print',
        'created_at',
        'updated_at',
        'total_ticket',
        'total_transaksi_tiket',
        'total_package',
        'total_transaksi_paket',
    ];
}

class TransactionDetail extends Model
{
    public function schedulePlan()
    {
        return $this->belongsTo(SchedulePlan::class, 'schedule_id', 'id'); // Sesuaikan dengan kolom foreign key
    }
}
