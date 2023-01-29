<?php

namespace GloCurrency\PolarisBank\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GloCurrency\PolarisBank\PolarisBank;
use GloCurrency\PolarisBank\Models\Transaction;
use GloCurrency\PolarisBank\Models\Sender;
use GloCurrency\PolarisBank\Models\Recipient;
use GloCurrency\PolarisBank\Models\Bank;
use GloCurrency\PolarisBank\Enums\TransactionStateCodeEnum;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'transaction_id' => (PolarisBank::$transactionModel)::factory(),
            'processing_item_id' => (PolarisBank::$processingItemModel)::factory(),
            'polaris_bank_sender_id' => Sender::factory(),
            'polaris_bank_recipient_id' => Recipient::factory(),
            'state_code' => TransactionStateCodeEnum::LOCAL_UNPROCESSED,
            'reference' => $this->faker->uuid(),
            'receive_currency_code' => $this->faker->currencyCode(),
            'receive_amount' => $this->faker->randomFloat(2, 1),
        ];
    }
}
