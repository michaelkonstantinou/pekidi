<?php

namespace App\Models;

use App\Types\OwnerType;
use App\Types\RelationshipType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @property string $name
 * @property string $full_name
 * @property string $home_address
 * @property string $national_id
 * @property int $user_id
 * @property Collection<DeclarationDebt> $debts
 * @property Collection<DeclarationFamilyMember> $familyMembers
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

    public static function lastForUser(User $user): ?Declaration
    {
        return Declaration::where('user_id', $user->id)->orderBy('updated_at', 'desc')->first();
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(DeclarationFamilyMember::class, 'declaration_id');
    }

    public function realEstates(): HasMany
    {
        return $this->hasMany(DeclarationRealEstate::class, 'declaration_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(DeclarationVehicle::class, 'declaration_id');
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(DeclarationBusiness::class, 'declaration_id');
    }

    public function investments(): HasMany
    {
        return $this->hasMany(DeclarationInvestment::class, 'declaration_id');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(DeclarationDeposit::class, 'declaration_id');
    }

    public function additionalAssets(): HasMany
    {
        return $this->hasMany(DeclarationAdditionalAsset::class, 'declaration_id');
    }

    public function debts(): HasMany
    {
        return $this->hasMany(DeclarationDebt::class, 'declaration_id');
    }


    public function realEstatesOfOwner(OwnerType $owner): Collection
    {
        return $this->realEstates()->where('owner', $owner)->get();
    }

    public function vehiclesOfOwner(OwnerType $owner): Collection
    {
        return $this->vehicles()->where('owner', $owner)->get();
    }

    public function businessesOfOwner(OwnerType $owner): Collection
    {
        return $this->businesses()->where('owner', $owner)->get();
    }

    public function investmentsOfOwner(OwnerType $owner): Collection
    {
        return $this->investments()->where('owner', $owner)->get();
    }

    public function depositsOfOwner(OwnerType $owner): Collection
    {
        return $this->deposits()->where('owner', $owner)->get();
    }

    public function additionalAssetsOfOwner(OwnerType $owner): Collection
    {
        return $this->additionalAssets()->where('owner', $owner)->get();
    }

    public function debtsOfOwner(OwnerType $owner): Collection
    {
        return $this->debts()->where('owner', $owner)->get();
    }

    /**
     * Override delete to automatically transaction-wrap relation cleanup.
     *
     * @return bool|null
     * @throws Throwable
     */
    public function delete(): ?bool
    {
        return DB::transaction(function () {
            $this->familyMembers()->delete();
            $this->realEstates()->delete();
            $this->vehicles()->delete();
            $this->businesses()->delete();
            $this->investments()->delete();
            $this->deposits()->delete();
            $this->additionalAssets()->delete();
            $this->debts()->delete();

            return parent::delete();
        });
    }

    /**
     * Check if the declaration includes a spouse.
     */
    public function hasSpouse(): bool
    {
        return $this->familyMembers()->where('relationship', RelationshipType::Spouse->value)->count() > 0;
    }

    /**
     * Get a collection of all minor children (under 18 years old).
     */
    public function minorChildren(): Collection
    {
        return $this->familyMembers->filter(function (DeclarationFamilyMember $member) {
            if ($member->relationship !== RelationshipType::Child) {
                return false;
            }

            return !$member->born_at || Carbon::parse($member->born_at)->age < 18;
        });
    }

    /**
     * Count the total number of minor children.
     */
    public function minorChildrenCount(): int
    {
        return $this->minorChildren()->count();
    }
}
