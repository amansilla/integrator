<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Integrator\Builder\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveUseVisitor extends NodeVisitorAbstract
{
    /**
     * @var string
     */
    protected const STATEMENT_NAMESPACE = 'Stmt_Namespace';

    /**
     * @var string
     */
    protected const STATEMENT_USE = 'Stmt_Use';

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string|null
     */
    protected $alias;

    /**
     * @param string $className
     * @param string|null $alias
     */
    public function __construct(string $className, ?string $alias = null)
    {
        $this->className = trim($className, '\\');
        $this->alias = $alias;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return int|\PhpParser\Node|array<\PhpParser\Node>|null
     */
    public function leaveNode(Node $node)
    {
        if ($node->getType() !== static::STATEMENT_NAMESPACE) {
            return $node;
        }

        if (!$this->useRemoved($node->stmts)) {
            $node = $this->removeUse($node);
        }

        return $node;
    }

    /**
     * @param array<\PhpParser\Node\Stmt> $stmts
     *
     * @return bool
     */
    protected function useRemoved(array $stmts): bool
    {
        foreach ($stmts as $stmt) {
            /** @var \PhpParser\Node\Stmt\Use_ $stmt */
            if ($stmt->getType() !== static::STATEMENT_USE) {
                continue;
            }
            foreach ($stmt->uses as $use) {
                if ($use->name->toString() === $this->className) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node
     */
    protected function removeUse(Node $node): Node
    {
        $uses = [];
        foreach ($node->stmts as $stmt) {
            /** @var \PhpParser\Node\Stmt\Use_ $stmt */
            if ($stmt->getType() !== static::STATEMENT_USE) {
                continue;
            }
            foreach ($stmt->uses as $use) {
                if ($use->name->toString() !== $this->className) {
                    $uses[] = $stmt;
                }
            }
        }

        $node->stmts = $uses;

        return $node;
    }
}
