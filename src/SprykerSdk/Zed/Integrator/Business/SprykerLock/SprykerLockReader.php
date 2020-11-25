<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace SprykerSdk\Zed\Integrator\Business\SprykerLock;

use SprykerSdk\Zed\Integrator\IntegratorConfig;

class SprykerLockReader
{
    /**
     * @var \SprykerSdk\Zed\Integrator\IntegratorConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Zed\Integrator\IntegratorConfig $config
     */
    public function __construct(IntegratorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string[][]
     */
    public function getLockFileData(): array
    {
        $integratorLockFilePath = $this->config->getIntegratorLockFilePath();

        if (!file_exists($integratorLockFilePath)) {
            return [];
        }

        $lockData = json_decode(file_get_contents($integratorLockFilePath), true);

        if (json_last_error()) {
            return [];
        }

        return $lockData;
    }
}
