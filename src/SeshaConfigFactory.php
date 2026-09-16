<?php

declare(strict_types=1);
/**
 * Sesha configuration class factory
 *
 * Creates instances of the SeshaConfig class.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(SeshaConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Sesha;

use Horde\Core\Config\ConfigLoader;
use Horde\Injector\Injector;

class SeshaConfigFactory
{
    public function __construct(private Injector $injector) {}

    public function create(): SeshaConfig
    {
        $state = $this->injector->get(ConfigLoader::class)->load('sesha');
        return new SeshaConfig($state->toArray());
    }
}
