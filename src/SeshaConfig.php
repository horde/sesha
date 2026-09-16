<?php

declare(strict_types=1);
/**
 * Sesha configuration class
 *
 * Provides access to the Sesha configuration settings.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(SeshaConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Sesha;

use Horde\Core\Config\State;
use Horde\Injector\Attribute\Factory;

#[Factory(factory: SeshaConfigFactory::class, method: 'create')]
class SeshaConfig extends State {}
