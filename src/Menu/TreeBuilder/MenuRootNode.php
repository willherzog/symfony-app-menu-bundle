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
	public function addLeaf(...$leafParams): MenuLeafNode
	{
		return parent::addLeaf(...$leafParams);
	}

	#[\Override]
	public function addBranch(string $branchName, ...$branchParams): MenuBranchNode
	{
		return parent::addBranch($branchName, ...$branchParams);
	}

	#[\Override]
	public function getBranch(string $branchName): ?MenuBranchNode
	{
		return parent::getBranch($branchName);
	}
}
