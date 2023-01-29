<?php

namespace GloCurrency\PolarisBank\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GloCurrency\PolarisBank\PolarisBank;
use GloCurrency\PolarisBank\Events\TransactionUpdatedEvent;
use GloCurrency\PolarisBank\Events\TransactionCreatedEvent;
use GloCurrency\PolarisBank\Enums\TransactionStateCodeEnum;
use GloCurrency\PolarisBank\Database\Factories\TransactionFactory;
use GloCurrency\MiddlewareBlocks\Contracts\ModelWithStateCodeInterface;
use Dilas\PolarisBank\Interfaces\TransactionInterface;
use Dilas\PolarisBank\Interfaces\SenderInterface;
use Dilas\PolarisBank\Interfaces\RecipientInterface;
use Dilas\PolarisBank\Enums\ErrorCodeEnum;
use BrokeYourBike\HasSourceModel\SourceModelInterface;
use BrokeYourBike\BaseModels\BaseUuid;

/**
 * GloCurrency\PolarisBank\Transaction
 *
 * @property string $id
 * @property string $transaction_id
 * @property string $processing_item_id
 * @property string $polaris_bank_sender_id
 * @property string $polaris_bank_recipient_id
 * @property \GloCurrency\PolarisBank\Enums\TransactionStateCodeEnum $state_code
 * @property string|null $state_code_reason
 * @property \Dilas\PolarisBank\Enums\ErrorCodeEnum|null $error_code
 * @property string|null $error_code_description
 * @property \Dilas\PolarisBank\Enums\TransactionTypeEnum $operation
 * @property string|null $linking_reference
 * @property string $reference
 * @property float $amount
 * @property string $currency_code
 * @property string $country_code
 * @property string $country_code_alpha2
 * @property string|null $reason
 * @property string|null $description
 * @property string|null $secret_question
 * @property string|null $secret_answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Transaction extends BaseUuid implements MModelWithStateCodeInterface, SourceModelInterface, TransactionInterface
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'polaris_bank_transactions';

    /**
     * @var array<mixed>
     */
    protected $casts = [
        'state_code' => TransactionStateCodeEnum::class,
        'error_code' => ErrorCodeEnum::class,
        'operation' => TransactionTypeEnum::class,
        'country_code_alpha2' => Alpha2Cast::class . ':country_code',
        'amount' => 'double',
    ];

    /**
     * @var array<mixed>
     */
    protected $dispatchesEvents = [
        'created' => TransactionCreatedEvent::class,
        'updated' => TransactionUpdatedEvent::class,
    ];

    public function getStateCode(): TransactionStateCodeEnum
    {
        return $this->state_code;
    }

    public function getStateCodeReason(): ?string
    {
        return $this->state_code_reason;
    }

    public function getSender(): ?SenderInterface
    {
        return $this->sender;
    }

    public function getRecipient(): ?RecipientInterface
    {
        return $this->recipient;
    }

    public function getTransactionType(): TransactionTypeEnum
    {
        return $this->operation;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCountryCode(): string
    {
        return $this->country_code_alpha2;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSecretQuestion(): ?string
    {
        return $this->secret_question;
    }

    public function getSecretAnswer(): ?string
    {
        return $this->secret_answer;
    }

    /**
     * Get Sender that the Transaction has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(
            Sender::class,
            'id',
            'polaris_bank_sender_id',
        );
    }

    /**
     * Get Recipient that the Transaction has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipient()
    {
        return $this->hasOne(
            Recipient::class,
            'id',
            'polaris_bank_recipient_id',
        );
    }

    /**
     * The ProcessingItem that Transaction belong to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processingItem()
    {
        return $this->belongsTo(PolarisBank::$processingItemModel, 'processing_item_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TransactionFactory::new();
    }
}
