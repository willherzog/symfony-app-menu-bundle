<?php

namespace WHSymfony\WHAppMenuBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

use WHSymfony\WHAppMenuBundle\DependencyInjection\AddAppMenuPass;
use WHSymfony\WHAppMenuBundle\Menu\AppMenu;
use WHSymfony\WHAppMenuBundle\Twig\WHAppMenuExtension;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class WHAppMenuBundle extends AbstractBundle
{
	public function build(ContainerBuilder $container): void
	{
		parent::build($container);

		$container->addCompilerPass(new AddAppMenuPass(), PassConfig::TYPE_BEFORE_REMOVING);
	}

	public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$builder
			->registerForAutoconfiguration(AppMenu::class)
				->addTag('wh_app_menu.menu')
		;

		$container->services()
			->set('wh_app_menu.twig.extension', WHAppMenuExtension::class)
				->args([service('request_stack'), service('wh_app_menu.menu_loader')])
				->tag('twig.extension')
		;
	}
}
