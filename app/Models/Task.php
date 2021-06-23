<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id'
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'assigned_to_id')->withDefault();
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
