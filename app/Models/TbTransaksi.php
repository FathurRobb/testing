<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TbTransaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'chart_of_account_id',
        'tanggal',
        'deskripsi',
        'debit',
        'credit'
    ];

    public function chart_of_account()
    {
        return $this->belongsTo(MChartOfAccount::class);
    }
}
