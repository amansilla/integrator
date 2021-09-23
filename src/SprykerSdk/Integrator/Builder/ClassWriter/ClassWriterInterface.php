<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Integrator\Builder\ClassWriter;

use SprykerSdk\Integrator\Transfer\ClassInformationTransfer;

interface ClassWriterInterface
{
    /**
     * @param \SprykerSdk\Integrator\Transfer\ClassInformationTransfer $classInformationTransfer
     *
     * @return bool
     */
    public function storeClass(ClassInformationTransfer $classInformationTransfer): bool;
}
