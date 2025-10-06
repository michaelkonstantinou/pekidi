<?php

namespace App\Models;

use App\Types\RelationshipType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $full_name
 * @property string $national_id
 * @property string $profession
 * @property RelationshipType $relationship
 * @property int $declaration_id
 */
class DeclarationFamilyMember extends Model
{
    protected $table = 'declaration_family_members';
    protected $fillable = ['full_name', 'national_id', 'profession', 'born_at', 'declaration_id', 'relationship'];

    protected $casts = ['relationship' => RelationshipType::class];
}
