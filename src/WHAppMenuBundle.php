<?php

namespace WHSymfony\WHAppMenuBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

use WHSymfony\WHAppMenuBundle\DependencyInjection\AddAppMenuPass;
use WHSymfony\WHAppMenuBundle\Menu\AppMenu;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class WHAppMenuBundle extends AbstractBundle
{
	public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$builder->registerForAutoconfiguration(AppMenu::class)->addTag('wh_app_menu.menu');
		$builder->addCompilerPass(new AddAppMenuPass(), PassConfig::TYPE_BEFORE_REMOVING);
	}
}
