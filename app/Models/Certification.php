<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $table="certifications";
    protected $keyType ="int";
    protected $primaryKey ="id";
    public $incrementing="true";
    public $timestamps="true";
    protected $fillable=[
        'title',
        'issuer',
        'year',
        'image',
        'user_id'
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class,"user_id","id");
    }
}
