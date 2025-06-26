<?php

namespace WHSymfony\WHAppMenuBundle\Menu\TreeBuilder;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
interface MenuNodeInterface
{
	/**
	 * Twig template method: Whether this node is a branch (if not, it is a leaf).
	 */
	public function is_branch(): bool;

	public function matchesRoute(string $routeName): bool;
}
