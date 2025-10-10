<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $declaration_id
 * @property OwnerType $owner
 * @property string $location
 * @property string $real_estate_type
 * @property int $area
 * @property string $acquisition_type
 * @property int $acquisition_year
 * @property int  $acquisition_value
 * @property int $current_value
 * @property string $rights_encumbrances
 */
class DeclarationRealEstate extends Model
{
    protected $fillable = [
        'declaration_id',
        'owner',
        'location',
        'real_estate_type',
        'area',
        'acquisition_type',
        'acquisition_year',
        'acquisition_value',
        'current_value',
        'rights_encumbrances'
    ];

    protected $casts = ['owner' => OwnerType::class];
}
