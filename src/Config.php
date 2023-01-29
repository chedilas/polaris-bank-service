<?php

namespace GloCurrency\PolarisBank;

use Dilas\PolarisBank\Interfaces\ConfigInterface;

final class Config implements ConfigInterface
{
    private function getAppConfigValue(string $key): string
    {
        $value = \Illuminate\Support\Facades\Config::get("services.polaris_bank.api.$key");

        return is_string($value) ? $value : '';
    }

    public function getUrl(): string
    {
        return $this->getAppConfigValue('url');
    }

    public function getAuthUrl(): string
    {
        return $this->getAppConfigValue('auth_url');
    }

    public function getClientId(): string
    {
        return $this->getAppConfigValue('client_id');
    }

    public function getClientSecret(): string
    {
        return $this->getAppConfigValue('client_secret');
    }
}
