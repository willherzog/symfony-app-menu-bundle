<?php

namespace WHSymfony\WHAppMenuBundle\Menu;

use WHPHP\TreeBuilder\TreeBuilderInterface;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
interface AppMenu extends TreeBuilderInterface
{
	static public function getMenuName(): string;
}
