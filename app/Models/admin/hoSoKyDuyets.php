<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class hoSoKyDuyets extends Model
{
    use HasFactory;
    protected $table = 'hosokyduyets';
    protected $fillable = [
        'maHoSo',
        'nguoiKyDuyet',
        'soChungChi',
        'soVaoSo',
        'hinhanhchuky',
        'publickey',
        'privatekey',
        'signature',
        'thongTinLuu',
        'ghiChu',
    ];
    public function nguoiKyDuyet(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class, 'nguoiKyDuyet', 'id');
    }
}
