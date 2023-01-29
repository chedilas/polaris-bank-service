<?php

namespace Tests\Unit\Enums\PolarisBank;

use GloCurrency\PolarisBank\Tests\TestCase;
use GloCurrency\PolarisBank\Enums\TransactionStateCodeEnum;
use GloCurrency\MiddlewareBlocks\Enums\ProcessingItemStateCodeEnum as MProcessingItemStateCodeEnum;
use Dilas\PolarisBank\Enums\PaymentStatusEnum;
use Dilas\PolarisBank\Enums\ErrorCodeEnum;

class TransactionStateCodeTest extends TestCase
{
    /** @test */
    public function it_can_return_processing_item_state_code_from_all_values()
    {
        foreach (TransactionStateCodeEnum::cases() as $value) {
            $this->assertInstanceOf(MProcessingItemStateCodeEnum::class, $value->getProcessingItemStateCode());
        }
    }

    /** @test */
    public function it_can_be_created_from_error_code()
    {
        foreach (ErrorCodeEnum::cases() as $value) {
            $this->assertInstanceOf(TransactionStateCodeEnum::class, TransactionStateCodeEnum::makeFromErrorCode($value));
        }
    }

    /** @test */
    public function it_can_be_created_from_status_code()
    {
        foreach (PaymentStatusEnum::cases() as $value) {
            $this->assertInstanceOf(TransactionStateCodeEnum::class, TransactionStateCodeEnum::makeFromPaymentStatus($value));
        }
    }
}
