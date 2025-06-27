<?php

namespace WHSymfony\WHAppMenuBundle\MenuLoader;

use Psr\Container\ContainerInterface;

use WHSymfony\WHAppMenuBundle\Exception\MenuNotFoundException;
use WHSymfony\WHAppMenuBundle\Menu\AppMenu;

/**
 * Patterned after {@link Symfony\Component\Console\CommandLoader\ContainerCommandLoader}.
 *
 * @author Will Herzog <willherzog@gmail.com>
 */
class ContainerMenuLoader
{
	public function __construct(
		private readonly ContainerInterface $container,
		private readonly array $menuMap
	) {}

	public function has(string $name): bool
	{
		return key_exists($name, $this->menuMap) && $this->container->has($this->menuMap[$name]);
	}

	public function get(string $name): AppMenu
	{
		if( !$this->has($name) ) {
			throw new MenuNotFoundException($name);
		}

		return $this->container->get($this->menuMap[$name]);
	}

	public function getNames(): array
	{
		return array_keys($this->menuMap);
	}
}
