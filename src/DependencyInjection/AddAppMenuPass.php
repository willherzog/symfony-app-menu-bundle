<?php

namespace WHSymfony\WHAppMenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\TypedReference;

use WHSymfony\WHAppMenuBundle\Menu\AbstractAppMenu;
use WHSymfony\WHAppMenuBundle\MenuLoader\ContainerMenuLoader;

/**
 * Patterned after {@link Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass}.
 *
 * @author Will Herzog <willherzog@gmail.com>
 */
class AddAppMenuPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container): void
	{
		$menuServices = $container->findTaggedServiceIds('wh_app_menu.menu', true);
		$lazyMenuMap = [];
		$lazyMenuRefs = [];

		foreach( array_keys($menuServices) as $id ) {
			$definition = $container->getDefinition($id);
			$class = $container->getParameterBag()->resolveValue($definition->getClass());

			if( !$refl = $container->getReflectionClass($class) ) {
				throw new InvalidArgumentException(\sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
			}

			if( !$refl->isSubclassOf(AbstractAppMenu::class) ) {
				throw new InvalidArgumentException(\sprintf('The service "%s" tagged "%s" must be a subclass of "%s".', $id, 'app.menu', AbstractAppMenu::class));
			}

			$definition->addTag('container.no_preload');

			$menuName = $class::getMenuName();
			$lazyMenuMap[$menuName] = $id;
			$lazyMenuRefs[$id] = new TypedReference($id, $class);
		}

		$container
			->register('wh_app_menu.menu_loader', ContainerMenuLoader::class)
			->addTag('container.no_preload')
			->setArguments([ServiceLocatorTagPass::register($container, $lazyMenuRefs), $lazyMenuMap])
		;
	}
}
