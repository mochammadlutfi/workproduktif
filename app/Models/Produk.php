<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Produk extends Model
{
    use HasFactory;
    use Sluggable;
    
    protected $table = 'produk';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'user_id', 'status', 'tgl'
    ];

    protected $appends = [
        // 'sisa'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
