<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'order';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama',
    ];

    protected $appends = [
        'dibayar', 'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function produk(){
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
    public function pembayaran(){
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function getDibayarAttribute(){
        return $this->pembayaran->sum('jumlah');
    }

    public function getStatusAttribute(){

        if($this->pembayaran->count()){
            if($this->pembayaran->sum('jumlah') == $this->total){
                return 'Lunas';
            }else{
                return 'Sebagian';
            }

        }else{
            return 'Belum Bayar';
        }
    }
}
