<?php

namespace WHSymfony\WHAppMenuBundle\Menu\TreeBuilder;

use WHPHP\TreeBuilder\RootNode;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MenuRootNode extends RootNode
{
	public function __construct()
	{
		parent::__construct(MenuLeafNode::class, MenuBranchNode::class);
	}

	#[\Override]
	public function addLeaf(string $nodeName, ...$leafParams): MenuLeafNode
	{
		return parent::addLeaf($nodeName, ...$leafParams);
	}

	#[\Override]
	public function addBranch(string $nodeName, ...$branchParams): MenuBranchNode
	{
		return parent::addBranch($nodeName, ...$branchParams);
	}

	#[\Override]
	public function getNode(string $nodeName): ?MenuBranchNode
	{
		return parent::getNode($nodeName);
	}
}
