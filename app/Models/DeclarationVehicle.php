<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $description
 * @property int $value
 */
class DeclarationVehicle extends Model
{
    protected $fillable = ['declaration_id', 'owner', 'description', 'value'];

    protected $casts = ['owner' => OwnerType::class];
}
