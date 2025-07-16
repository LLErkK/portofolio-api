<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    protected $table="experiences";
    protected $keyType ="int";
    protected $primaryKey ="id";
    public $incrementing="true";
    public $timestamps="true";
    protected $fillable=[
        
            'company_name',
            'position' ,
            'start_date' ,
            'end_date' ,
            'description',
            'user_id' 
            
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class,"user_id","id");
    }
}
