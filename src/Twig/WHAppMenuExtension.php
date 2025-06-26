<?php

namespace WHSymfony\WHAppMenuBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use WHPHP\TreeBuilder\TreeBuilderInterface;

use WHSymfony\WHAppMenuBundle\Menu\TreeBuilder\{MenuBranchNode,MenuLeafNode};
use WHSymfony\WHAppMenuBundle\Menu\TreeBuilder\MenuNodeInterface;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class WHAppMenuExtension extends AbstractExtension
{
	private ?string $currentRoute = null;
	private bool $currentRouteMatched = false;

	public function __construct(
		protected readonly RequestStack $requestStack,
		// TODO: This needs to be an array of user classes extending from AbstractAppMenu, keyed by alias
		protected readonly TreeBuilderInterface $appMenu
	) {}

	/**
	 * @inheritDoc
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('admin_menu_nodes', [$this, 'getNodes']),
			new TwigFunction('admin_menu_node_classes', [$this, 'getNodeHtmlClasses'])
		];
	}

	public function getNodes(string $menuAlias): iterable
	{
		$this->currentRoute = null;
		$this->currentRouteMatched = false;

		// TODO: The $menuAlias argument should be used to identify the desired menu object from those in the constructor
		return $this->appMenu->getTreeNodes();
	}

	public function getNodeHtmlClasses(MenuNodeInterface $node): string
	{
		if( !isset($this->currentRoute) ) {
			$this->currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
		}

		$classes = [];

		if( $node instanceof MenuBranchNode ) {
			$classes[] = 'menu-branch';
			$classes[] = $node->slug;

			if( !$this->currentRouteMatched && $node->matchesRoute($this->currentRoute) ) {
				$classes[] = 'current-parent';
			}
		} elseif( $node instanceof MenuLeafNode ) {
			$classes[] = 'menu-leaf';

			if( $node->isFauxBranch() ) {
				$classes[] = 'faux-branch';
			}

			$classes[] = $node->slug;

			if( !$this->currentRouteMatched ) {
				if( $node->matchesRoute($this->currentRoute, MenuLeafNode::MATCH_ONLY) ) {
					$classes[] = 'current-parent';

					$this->currentRouteMatched = true;
				} elseif( $node->matchesRoute($this->currentRoute, MenuLeafNode::MATCH_SELF) ) {
					$classes[] = 'current-page';

					$this->currentRouteMatched = true;
				}
			}
		}

		return implode(' ', $classes);
	}
}
