<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'tanggal_lahir' => 'date',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function lansias()
    {
        return $this->belongsToMany(Lansia::class, 'karyawan_lansia');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isKaryawan()
    {
        return $this->hasRole('karyawan');
    }

    public function isKeluarga()
    {
        return $this->hasRole('keluarga');
    }

    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->role && in_array($this->role->name, $roles, true);
    }
}
