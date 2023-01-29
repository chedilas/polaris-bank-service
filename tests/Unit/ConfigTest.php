<?php

namespace GloCurrency\PolarisBank\Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use GloCurrency\PolarisBank\Tests\TestCase;
use GloCurrency\PolarisBank\Config;
use BrokeYourBike\PolarisBank\Interfaces\ConfigInterface;

class ConfigTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_implemets_config_interface(): void
    {
        $this->assertInstanceOf(ConfigInterface::class, new Config());
    }

    /** @test */
    public function it_will_return_empty_string_if_value_not_found()
    {
        $configPrefix = 'services.polaris_bank.api';

        // config is empty
        config([$configPrefix => []]);

        $config = new Config();

        $this->assertSame('', $config->getUrl());
        $this->assertSame('', $config->getAuthUrl());
        $this->assertSame('', $config->getClientId());
        $this->assertSame('', $config->getClientSecret());
    }

    /** @test */
    public function it_can_return_values()
    {
        $url = $this->faker->url;
        $authUrl = $this->faker->url;
        $clientId = $this->faker->clientId;
        $clientSecret = $this->faker->clientSecret();

        $configPrefix = 'services.polaris_bank.api';

        config(["{$configPrefix}.url" => $url]);
        config(["{$configPrefix}.auth_url" => $authUrl]);
        config(["{$configPrefix}.clientId" => $clientId]);
        config(["{$configPrefix}.clientSecret" => $clientSecret]);

        $config = new Config();

        $this->assertSame($url, $config->getUrl());
        $this->assertSame($authUrl, $config->getAuthUrl());
        $this->assertSame($clientId, $config->getClientId());
        $this->assertSame($clientSecret, $config->getClientSecret());
    }
}
