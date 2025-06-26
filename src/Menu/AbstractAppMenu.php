<?php

namespace WHSymfony\WHAppMenuBundle\Menu;

use WHPHP\TreeBuilder\TreeBuilderInterface;

use WHSymfony\WHAppMenuBundle\Menu\TreeBuilder\MenuRootNode;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
// TODO: Employ a custom PHP attribute to facilitate associating an alias with each menu class
abstract class AbstractAppMenu implements TreeBuilderInterface
{
	protected readonly MenuRootNode $rootNode;

	public function __construct()
	{
		$this->rootNode = new MenuRootNode();

		// Override this method in your extending class and add your menu's branches and leaves here
		// by calling $this->rootNode->addBranch() or $this->rootNode->addLeaf() for each of them.
	}

	/**
	 * Returns the root node; primary extension point for this app menu.
	 */
	public function getRootNode(): MenuRootNode
	{
		return $this->rootNode;
	}

	/**
	 * Returns all current tree nodes; primary output method for this app menu.
	 */
	public function getTreeNodes(): iterable
	{
		return array_merge($this->rootNode->getLeaves(), $this->rootNode->getBranches());
	}
}
