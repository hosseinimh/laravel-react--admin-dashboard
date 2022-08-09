<?php

namespace App\Models;

use App\Constants\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_users';
    protected $fillable = [
        'name',
        'family',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public static function updatePassword(int $id, string $password)
    {
        return DB::statement("UPDATE `tbl_users` SET `password`='$password' WHERE `id`=$id");
    }

    public static function get(int $id)
    {
        return self::where('id', $id)->first();
    }

    public static function getPagination(string|null $email, string|null $name, string|null $family, int $page)
    {
        return self::where('email', 'LIKE', '%' . $email . '%')->where('name', 'LIKE', '%' . $name . '%')->orWhere('family', 'LIKE', '%' . $family . '%')->orderBy('family', 'ASC')->orderBy('name', 'ASC')->orderBy('id', 'ASC')->skip(($page - 1) * Theme::ITEMS_PER_PAGE)->take(Theme::ITEMS_PER_PAGE)->get();
    }

    public static function getAll()
    {
        return self::orderBy('family', 'ASC')->orderBy('name', 'ASC')->orderBy('id', 'ASC')->get();
    }

    public static function getUsersCount()
    {
        return self::count();
    }
}
