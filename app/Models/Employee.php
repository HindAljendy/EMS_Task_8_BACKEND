<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory , SoftDeletes ;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'position',
        'department_id',
    ];

    /* the Relations */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /* Implement setters and getters  to ensure that the `first_name` and `last_name` are
    properly capitalized upon retrieval and storage. */

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    /* The relations "many to many" */

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class , 'employee_project');
    }


    /* The Relation Morph */
    public function notes(): MorphMany {
        return $this->morphMany(Note::class,'noteable');
    }

}
