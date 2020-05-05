<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

interface ExpressionBuilderInterface
{
    public function build(ExpressionInterface $expression): string;
}
