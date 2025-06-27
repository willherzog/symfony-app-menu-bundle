<?php

namespace WHSymfony\WHAppMenuBundle\Menu;

use WHSymfony\WHAppMenuBundle\Menu\TreeBuilder\MenuRootNode;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
abstract class AbstractAppMenu implements AppMenu
{
	private readonly MenuRootNode $rootNode;

	abstract protected function buildMenuTree(MenuRootNode $rootNode): void;

	final public function __construct()
	{
		$this->rootNode = new MenuRootNode();

		$this->buildMenuTree($this->rootNode);
	}

	/**
	 * Returns the root node; primary extension point for this app menu.
	 */
	final public function getRootNode(): MenuRootNode
	{
		return $this->rootNode;
	}

	/**
	 * Returns all current tree nodes; primary output method for this app menu.
	 */
	final public function getTreeNodes(): iterable
	{
		return array_merge($this->rootNode->getLeaves(), $this->rootNode->getBranches());
	}
}
