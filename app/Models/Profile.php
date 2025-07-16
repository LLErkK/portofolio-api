<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table ="profiles";
    protected $primaryKey = "id";
    protected $keyType ="int";
    public $timestamps ="true";
    public $incrementing = "true";

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,"user_id","id");
    }
    protected $fillable = [
        'user_id',
        'name',
        'bio',
        'linkedin',
        'github',
        'photo'
    ];
}
