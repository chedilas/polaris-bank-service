<?php

namespace GloCurrency\AccessBank\Tests\Feature\Models;

use Illuminate\Support\Facades\Event;
use GloCurrency\PolarisBank\Tests\Fixtures\ProcessingItemFixture;
use GloCurrency\PolarisBank\Tests\FeatureTestCase;
use GloCurrency\PolarisBank\Models\Transaction;
use GloCurrency\PolarisBank\Events\TransactionCreatedEvent;

class GetProcessingItemTest extends FeatureTestCase
{
    /** @test */
    public function it_can_get_processing_item(): void
    {
        Event::fake([
            TransactionCreatedEvent::class,
        ]);

        $processingItem = ProcessingItemFixture::factory()->create();

        $transaction = Transaction::factory()->create([
            'processing_item_id' => $processingItem->id,
        ]);

        $this->assertSame($processingItem->id, $transaction->fresh()->processingItem->id);
    }
}
