<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = 'false';
    protected $fillable = [
        'user_name', 'user_email', 'password', 'user_no_pegawai', 'user_unit', 'user_subunit','user_telp','user_jabatan','user_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
