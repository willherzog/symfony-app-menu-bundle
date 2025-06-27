<?php

namespace WHSymfony\WHAppMenuBundle\Menu\TreeBuilder;

use WHPHP\TreeBuilder\AbstractNode;
use WHPHP\TreeBuilder\BranchNodeInterface;
use WHPHP\TreeBuilder\RootNodeInterface;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MenuBranchNode extends AbstractNode implements BranchNodeInterface, MenuNodeInterface
{
	private array $leaves = [];
	private array $branches = [];

	private bool $isCurrentBranch;

	public function __construct(
		public readonly string $slug,
		public readonly string $label,
		public readonly ?string $route = null,
		public readonly array $routeParams = []
	) {}

	public function is_branch(): bool
	{
		return true;
	}

	public function is_current_branch(): bool
	{
		return $this->isCurrentBranch ?? false;
	}

	public function is_top_level_branch(): bool
	{
		return $this->getParent() instanceof RootNodeInterface;
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
		if( $routeName === $this->route ) {
			$this->isCurrentBranch = true;

			return true;
		}

		foreach( $this->leaves as $leaf ) {
			if( $leaf->matchesRoute($routeName) ) {
				$this->isCurrentBranch = true;

				return true;
			}
		}

		$this->isCurrentBranch = false;

		return false;
	}

	#[\Override]
	public function end(): MenuLeafNode|MenuBranchNode|MenuRootNode
	{
		return parent::end();
	}
}
