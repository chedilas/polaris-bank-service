<?php

namespace GloCurrency\PolarisBank\Console;

use Illuminate\Console\Command;
use GloCurrency\PolarisBank\Models\Transaction;
use GloCurrency\PolarisBank\Jobs\FetchTransactionUpdateJob;
use GloCurrency\PolarisBank\Enums\TransactionStateCodeEnum;

class FetchTransactionsUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'polairs-bank:fetch-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch fetch jobs for unfinished PolarisBank/Transaction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @todo add actual implemetation
     */
    public function handle()
    {
        $transactionsQuery = Transaction::where('state_code', TransactionStateCodeEnum::PROCESSING->value);

        $count = $transactionsQuery->count();

        if (!$count) {
            $this->error('You do not have any unfinished PolarisBank/Transaction');
            return;
        }

        $this->info("Dispatching fetch jobs for {$count} PolarisBank/Transaction");

        $bar = $this->output->createProgressBar($count);

        $bar->start();

        foreach ($transactionsQuery->cursor() as $transaction) {
            FetchTransactionUpdateJob::dispatch($transaction);
        }

        $bar->finish();

        $this->newLine();
        $this->info("Job dispatching done");
    }
}
