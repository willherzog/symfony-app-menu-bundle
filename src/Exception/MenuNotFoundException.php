<?php

namespace WHSymfony\WHAppMenuBundle\Exception;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MenuNotFoundException extends \InvalidArgumentException
{
	public function __construct(string $menuAlias, int $code = 0, ?\Throwable $previous = null)
	{
		parent::__construct(sprintf('Menu "%s" does not exist.', $menuAlias), $code, $previous);
	}
}
