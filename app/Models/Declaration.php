<?php

namespace App\Models;

use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $full_name
 * @property string $home_address
 * @property string $national_id
 * @property int $user_id
 */
class Declaration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'full_name', 'born_at', 'home_address', 'national_id', 'user_id'];

    public static function createForUser(User $user, string $name): ?Declaration
    {
        return Declaration::create([
            'name' => $name,
            'user_id' => $user->id,
            'full_name' => $user->name,
            'born_at' => $user->born_at,
            'home_address' => $user->home_address,
            'national_id' => $user->national_id
        ]);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(DeclarationFamilyMember::class, 'declaration_id');
    }

    public function realEstates(): HasMany
    {
        return $this->hasMany(DeclarationRealEstate::class, 'declaration_id');
    }

    public function realEstatesOfOwner(OwnerType $owner): Collection
    {
        return $this->realEstates()->where('owner', $owner)->get();
    }
}
