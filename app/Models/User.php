<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{   use HasFactory;
    public function getAuthIdentifierName(){
        return 'username';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier(){
        return $this->username;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(){
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken(){
        return $this->token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value){
        $this->token =$value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName(){
        return 'token';
    }

    protected $table ="users";
    protected $primaryKey = "id";
    protected $keyType ="int";
    public $timestamps ="true";
    public $incrementing = "true";

    protected $fillable =[
        'username',
        'password',
        'name'
    ];
    public function profile():BelongsTo{
        return $this->belongsTo(Profile::class,"user_id","id");
    }
    public function projects():HasMany{
        return $this->hasMany(Project::class,"user_id","id");
    }

    public function experiences():HasMany{
        return $this->hasMany(Experience::class,"user_id","id");
    }

    public function educations():HasMany{
        return $this->hasMany(Education::class,"user_id","id");
    }
}
