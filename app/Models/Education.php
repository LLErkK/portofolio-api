<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
     protected $table="educations";
    protected $keyType ="int";
    protected $primaryKey ="id";
    public $incrementing="true";
    public $timestamps="true";
    
    protected $fillable=[
        'school_name',
        'start_year',
        'end_year',
        'address',
        'user_id'
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class,"user_id","id");
    }
}
