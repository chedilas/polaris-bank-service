<?php

namespace GloCurrency\PolarisBank\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use GloCurrency\PolarisBank\PolarisBankServiceProvider;
use GloCurrency\PolarisBank\PolarisBank;
use GloCurrency\PolarisBank\Tests\Fixtures\TransactionFixture;
use GloCurrency\PolarisBank\Tests\Fixtures\ProcessingItemFixture;

abstract class TestCase extends OrchestraTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        PolarisBank::useTransactionModel(TransactionFixture::class);
        PolarisBank::useProcessingItemModel(ProcessingItemFixture::class);
    }

    protected function getPackageProviders($app)
    {
        return [PolarisBankServiceProvider::class];
    }

    /**
     * Create the HTTP mock for API.
     *
     * @return array<\GuzzleHttp\Handler\MockHandler|\GuzzleHttp\HandlerStack> [$httpMock, $handlerStack]
     */
    protected function mockApiFor(string $class): array
    {
        $httpMock = new \GuzzleHttp\Handler\MockHandler();
        $handlerStack = \GuzzleHttp\HandlerStack::create($httpMock);

        $this->app->when($class)
            ->needs(\GuzzleHttp\ClientInterface::class)
            ->give(function () use ($handlerStack) {
                return new \GuzzleHttp\Client(['handler' => $handlerStack]);
            });

        return [$httpMock, $handlerStack];
    }
}
