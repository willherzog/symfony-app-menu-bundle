<?php

namespace WHSymfony\WHAppMenuBundle\Menu\TreeBuilder;

use WHPHP\TreeBuilder\AbstractNode;
use WHPHP\TreeBuilder\BranchNodeInterface;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MenuBranchNode extends AbstractNode implements BranchNodeInterface, MenuNodeInterface
{
	private array $leaves = [];
	private array $branches = [];

	public function __construct(
		public readonly string $slug,
		public readonly string $label
	) {}

	public function is_branch(): bool
	{
		return true;
	}

	public function isAnonymous(): bool
	{
		return empty($this->label);
	}

	public function addLeaf(...$leafParams): MenuLeafNode
	{
		$leaf = new MenuLeafNode(...$leafParams);

		$leaf->setParent($this);

		$this->leaves[] = $leaf;

		return $leaf;
	}

	public function getLeaves(): iterable
	{
		return $this->leaves;
	}

	public function addBranch(...$branchParams): MenuBranchNode
	{
		$branch = new MenuBranchNode(...$branchParams);

		$branch->setParent($this);

		$this->branches[] = $branch;

		return $branch;
	}

	public function getBranches(): iterable
	{
		return $this->branches;
	}

	public function matchesRoute(string $routeName): bool
	{
		foreach( $this->leaves as $leaf ) {
			if( $leaf->matchesRoute($routeName) ) {
				return true;
			}
		}

		return false;
	}

	#[\Override]
	public function end(): MenuLeafNode|MenuBranchNode|MenuRootNode
	{
		return parent::end();
	}
}
