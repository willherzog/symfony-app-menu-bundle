<?php

namespace WHSymfony\WHAppMenuBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class WHAppMenuBundle extends AbstractBundle
{
	public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		// Nothing yet
	}
}
