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

    public function user():BelongsTo{
        return $this->belongsTo(Experience::class,"user_id","id");
    }
}
