<?php

namespace GloCurrency\PolarisBank\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GloCurrency\PolarisBank\Database\Factories\RecipientFactory;
use BrokeYourBike\PolarisBank\Interfaces\RecipientInterface;
use BrokeYourBike\CountryCasts\Alpha2Cast;
use BrokeYourBike\BaseModels\BaseUuid;

/**
 * GloCurrency\PolarisBank\Models\Recipient
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $country_code
 * @property string $country_code_alpha2
 * @property string $phone_number
 * @property string $email
 * @property string $bank_account
 * @property string $bank_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Recipient extends BaseUuid implements RecipientInterface
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'polaris_bank_recipients';

    /**
     * @var array<mixed>
     */
    protected $casts = [
        'country_code_alpha2' => Alpha2Cast::class . ':country_code',
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCountryCode(): string
    {
        return $this->country_code_alpha2;
    }

    public function getBankAccount(): string
    {
        return $this->bank_account;
    }

    public function getBankCode(): string
    {
        return $this->bank_code;
    }

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RecipientFactory::new();
    }
}
