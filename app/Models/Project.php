<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'owner_id'];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

}
