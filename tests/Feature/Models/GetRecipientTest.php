<?php

namespace GloCurrency\PolarisBank\Tests\Feature\Models;

use Illuminate\Support\Facades\Event;
use GloCurrency\PolarisBank\Tests\FeatureTestCase;
use GloCurrency\PolarisBank\Models\Transaction;
use GloCurrency\PolarisBank\Models\Recipient;
use GloCurrency\PolarisBank\Events\TransactionCreatedEvent;

class GetRecipientTest extends FeatureTestCase
{
    /** @test */
    public function it_can_get_recipient(): void
    {
        Event::fake([
            TransactionCreatedEvent::class,
        ]);

        $recipient = Recipient::factory()->create();

        $transaction = Transaction::factory()->create([
            'polaris_bank_recipient_id' => $recipient->id,
        ]);

        $this->assertSame($recipient->id, $transaction->fresh()->recipient->id);
    }
}
