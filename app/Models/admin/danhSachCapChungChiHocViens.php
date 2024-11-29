<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhSachCapChungChiHocViens extends Model
{
    use HasFactory;
    protected $table = 'danhSachCapChungChiHocViens';
    protected $fillable = [
       'maChungChi',
       'hoTen',
       'namSinh',
       'gioiTinh',
       'vanHoa',
       'danToc',
       'queQuan',
       'image',
       'diemTrungBinh',
       'xepLoai',
       'ghiChu',
       'maDotCap',
       'maKhoaHoc',
       'maHoSoKyDuyet',
    ];
    public function dotCap(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(dotCaps::class, 'maDotCap', 'maDot');
    }
    public function khoaHoc(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(thongTinKhoaHocs::class, 'maKhoaHoc', 'maKhoaHoc');
    }
    public function hoSoDuyet(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(hoSoKyDuyets::class, 'maHoSoKyDuyet', 'maHoSo');
    }
}
