<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $full_name
 * @property string $national_id
 * @property string $profession
 * @property $relationship
 * @property int $declaration_id
 */
class DeclarationFamilyMember extends Model
{
    protected $fillable = ['full_name', 'national_id', 'profession', 'born_at', 'declaration_id'];
}
