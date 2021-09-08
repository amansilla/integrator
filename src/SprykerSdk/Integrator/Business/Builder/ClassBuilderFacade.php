<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace SprykerSdk\Integrator\Business\Builder;


use SprykerSdk\Shared\Integrator\IntegratorFactoryAwareTrait;
use SprykerSdk\Shared\Transfer\ClassInformationTransfer;
use SprykerSdk\Shared\Common\AbstractFacade;


class ClassBuilderFacade extends AbstractFacade
{
    use IntegratorFactoryAwareTrait;
    /**
     * @param string $targetClassName
     * @param string $customOrganisation
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function resolveClass(string $targetClassName, string $customOrganisation = ''): ClassInformationTransfer
    {
        return $this->getFactory()
            ->createClassResolver()
            ->resolveClass($targetClassName, $customOrganisation);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     *
     * @return bool
     */
    public function storeClass(ClassInformationTransfer $classInformationTransfer): bool
    {
        return $this->getFactory()
            ->createClassFileWriter()
            ->storeClass($classInformationTransfer);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     *
     * @return string|null
     */
    public function printDiff(ClassInformationTransfer $classInformationTransfer): ?string
    {
        return $this->getFactory()
            ->createClassDiffPrinter()
            ->printDiff($classInformationTransfer);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $constantName
     * @param $value
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function setConstant(ClassInformationTransfer $classInformationTransfer, string $constantName, $value): ClassInformationTransfer
    {
        return $this->getFactory()
            ->createClassConstantModifier()
            ->setConstant($classInformationTransfer, $constantName, $value);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $targetMethodName
     * @param string $classNameToAdd
     * @param string|null $before
     * @param string|null $after
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function wireClassInstance(
        ClassInformationTransfer $classInformationTransfer,
        string $targetMethodName,
        string $classNameToAdd,
        string $before = '',
        string $after = ''
    ): ClassInformationTransfer {
        return $this->getFactory()
            ->createClassInstanceClassModifier()
            ->wireClassInstance($classInformationTransfer, $targetMethodName, $classNameToAdd, $before, $after);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $classNameToRemove
     * @param string $targetMethodName
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer|null
     */
    public function unwireClassInstance(
        ClassInformationTransfer $classInformationTransfer,
        string $classNameToRemove,
        string $targetMethodName
    ): ?ClassInformationTransfer {
        return $this->getFactory()
            ->createClassInstanceClassModifier()
            ->unwireClassInstance($classInformationTransfer, $classNameToRemove, $targetMethodName);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $targetMethodName
     * @param string $classNameToAdd
     * @param string $constantName
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function wireClassConstant(
        ClassInformationTransfer $classInformationTransfer,
        string $targetMethodName,
        string $classNameToAdd,
        string $constantName
    ): ClassInformationTransfer {
        return $this->getFactory()
            ->createClassListModifier()
            ->wireClassConstant($classInformationTransfer, $targetMethodName, $classNameToAdd, $constantName);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $classNameToRemove
     * @param string $targetMethodName
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer|null
     */
    public function unwireClassConstant(
        ClassInformationTransfer $classInformationTransfer,
        string $classNameToRemove,
        string $targetMethodName
    ): ?ClassInformationTransfer {
        return $this->getFactory()
            ->createClassListModifier()
            ->unwireClassConstant($classInformationTransfer, $classNameToRemove, $targetMethodName);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $methodName
     * @param bool|int|float|string|array|null $value
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function setMethodReturnValue(ClassInformationTransfer $classInformationTransfer, string $methodName, $value): ClassInformationTransfer
    {
        return $this->getFactory()
            ->createCommonClassModifier()
            ->setMethodReturnValue($classInformationTransfer, $methodName, $value);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $targetMethodName
     * @param string $key
     * @param string $classNameToAdd
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function wireGlueRelationship(
        ClassInformationTransfer $classInformationTransfer,
        string $targetMethodName,
        string $key,
        string $classNameToAdd
    ): ClassInformationTransfer {
        return $this->getFactory()
            ->createGlueRelationshipModifier()
            ->wireGlueRelationship($classInformationTransfer, $targetMethodName, $key, $classNameToAdd);
    }

    /**
     * @param \SprykerSdk\Shared\Transfer\ClassInformationTransfer $classInformationTransfer
     * @param string $targetMethodName
     * @param string $key
     * @param string $classNameToAdd
     *
     * @return \SprykerSdk\Shared\Transfer\ClassInformationTransfer
     */
    public function unwireGlueRelationship(
        ClassInformationTransfer $classInformationTransfer,
        string $targetMethodName,
        string $key,
        string $classNameToAdd
    ): ClassInformationTransfer {
        return $this->getFactory()
            ->createGlueRelationshipModifier()
            ->unwireGlueRelationship($classInformationTransfer, $targetMethodName, $key, $classNameToAdd);
    }
}
