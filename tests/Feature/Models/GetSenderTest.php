<?php

namespace GloCurrency\PolarisBank\Tests\Feature\Models;

use Illuminate\Support\Facades\Event;
use GloCurrency\PolarisBank\Tests\FeatureTestCase;
use GloCurrency\PolarisBank\Models\Transaction;
use GloCurrency\PolarisBank\Models\Sender;

class GetSenderTest extends FeatureTestCase
{
    /** @test */
    public function it_can_get_sender(): void
    {
        Event::fake([
            TransactionCreatedEvent::class,
        ]);

        $sender = Sender::factory()->create();

        $transaction = Transaction::factory()->create([
            'polaris_bank_sender_id' => $sender->id,
        ]);

        $this->assertSame($sender->id, $transaction->fresh()->sender->id);
    }
}
