<?php

namespace WHSymfony\WHAppMenuBundle\Menu;

use WHSymfony\WHAppMenuBundle\Menu\TreeBuilder\MenuRootNode;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
abstract class AbstractAppMenu implements AppMenu
{
	private readonly MenuRootNode $rootNode;

	/**
	 * This method should be called from within your extending class's constructor.
	 * You can then use the MenuRootNode instance it returns to build your menu tree.
	 */
	final protected function createRootNode(): MenuRootNode
	{
		$this->rootNode = new MenuRootNode();

		return $this->rootNode;
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
		return $this->rootNode->getNodes();
	}
}
