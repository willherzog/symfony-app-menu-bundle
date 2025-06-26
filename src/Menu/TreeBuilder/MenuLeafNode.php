<?php

namespace WHSymfony\WHAppMenuBundle\Menu\TreeBuilder;

use WHPHP\TreeBuilder\AbstractNode;
use WHPHP\TreeBuilder\LeafNodeInterface;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MenuLeafNode extends AbstractNode implements LeafNodeInterface, MenuNodeInterface
{
	public const MATCH_ANY = 1;
	public const MATCH_SELF = 2;
	public const MATCH_ONLY = 3;

	private bool $isFauxBranch = false;
	private array $matchOnlyRoutes = [];

	public function __construct(
		public readonly string $slug,
		public readonly string $label,
		public readonly string $route,
		public readonly array $routeParams = []
	) {}

	public function is_branch(): bool
	{
		return false;
	}

	public function setAsFauxBranch(): static
	{
		$this->isFauxBranch = true;

		return $this;
	}

	public function isFauxBranch(): bool
	{
		return $this->isFauxBranch;
	}

	public function addMatchOnlyRoute(string $routeName): static
	{
		if( !in_array($routeName, $this->matchOnlyRoutes, true) ) {
			$this->matchOnlyRoutes[] = $routeName;
		}

		return $this;
	}

	public function matchesRoute(string $routeName, int $mode = self::MATCH_ANY): bool
	{
		return ($mode !== self::MATCH_ONLY && $routeName === $this->route) ||
			($mode !== self::MATCH_SELF && in_array($routeName, $this->matchOnlyRoutes, true))
		;
	}

	#[\Override]
	public function end(): MenuLeafNode|MenuBranchNode|MenuRootNode
	{
		return parent::end();
	}
}
