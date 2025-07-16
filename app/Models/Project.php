<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $primaryKey ="id";
    protected $keyType ="int";
    protected $table="Projects";
    public $incrementing =true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'link',
        'tech_stack',
        'images',
        'user_id'
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class,"user_id","id");
    }
}
