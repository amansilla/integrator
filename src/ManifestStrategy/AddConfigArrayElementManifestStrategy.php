<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Integrator\ManifestStrategy;

use ReflectionClass;
use SprykerSdk\Integrator\Dependency\Console\InputOutputInterface;
use SprykerSdk\Integrator\IntegratorConfig;

/**
 * Currently, this strategy only supports adding constants to the array.
 * String support may be added in the future.
 */
class AddConfigArrayElementManifestStrategy extends AbstractManifestStrategy
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return 'add-config-array-element';
    }

    /**
     * @param array<mixed> $manifest
     * @param string $moduleName
     * @param \SprykerSdk\Integrator\Dependency\Console\InputOutputInterface $inputOutput
     * @param bool $isDry
     *
     * @return bool
     */
    public function apply(array $manifest, string $moduleName, InputOutputInterface $inputOutput, bool $isDry): bool
    {
        [$targetClassName, $targetMethodName] = explode('::', $manifest[IntegratorConfig::MANIFEST_KEY_TARGET]);

        if (!class_exists($targetClassName)) {
            $inputOutput->writeln(sprintf(
                'Target module `%s.%s` does not exists in your system.',
                $this->classHelper->getOrganisationName($targetClassName),
                $this->classHelper->getModuleName($targetClassName),
            ), InputOutputInterface::DEBUG);

            return false;
        }

        $targetClassInfo = (new ReflectionClass($targetClassName));

        if (!$targetClassInfo->hasMethod($targetMethodName)) {
            $inputOutput->writeln(sprintf(
                'Your version of module `%s.%s` does not contain required configuration method `%s()`. Please, update it to use full functionality.',
                $this->classHelper->getOrganisationName($targetClassName),
                $this->classHelper->getModuleName($targetClassName),
                $targetMethodName,
            ), InputOutputInterface::DEBUG);

            return false;
        }

        foreach ($this->config->getProjectNamespaces() as $namespace) {
            $classInformationTransfer = $this->createClassBuilderFacade()->resolveClass($targetClassName, $namespace);
            if (!$classInformationTransfer) {
                continue;
            }

            [$valueClassName, $valueConstName] = explode('::', $manifest[IntegratorConfig::MANIFEST_KEY_VALUE]);

            $classInformationTransfer = $this->createClassBuilderFacade()->wireClassConstant(
                $classInformationTransfer,
                $targetMethodName,
                $valueClassName,
                $valueConstName,
                $manifest[IntegratorConfig::MANIFEST_KEY_POSITION][IntegratorConfig::MANIFEST_KEY_POSITION_BEFORE] ?? '',
                $manifest[IntegratorConfig::MANIFEST_KEY_POSITION][IntegratorConfig::MANIFEST_KEY_POSITION_AFTER] ?? '',
            );

            if ($isDry) {
                $inputOutput->writeln((string)$this->createClassBuilderFacade()->printDiff($classInformationTransfer));
            } else {
                $this->createClassBuilderFacade()->storeClass($classInformationTransfer);
            }

            $inputOutput->writeln(sprintf(
                'Element `%s` was added to `%s::%s`',
                $manifest[IntegratorConfig::MANIFEST_KEY_VALUE],
                $classInformationTransfer->getClassName(),
                $targetMethodName,
            ), InputOutputInterface::DEBUG);
        }

        return true;
    }
}
