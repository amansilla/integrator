<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Integrator\Business\Helper;

use SprykerSdk\Integrator\Business\Helper\ClassHelper;
use SprykerSdkTest\Integrator\BaseTestCase;

class ClassHelperTest extends BaseTestCase
{
    public function testGetShortClassName()
    {
        $shortClassName = $this->createClassHelper()->getShortClassName(ClassHelper::class);
        $this->assertEquals('ClassHelper', $shortClassName);
    }

    public function testGetShortClassNameOneLevel()
    {
        $shortClassName = $this->createClassHelper()->getShortClassName('\ClassHelper');
        $this->assertEquals('ClassHelper', $shortClassName);
    }

    public function testGetShortClassNameByEmptyString()
    {
        $shortClassName = $this->createClassHelper()->getShortClassName('');
        $this->assertEquals('', $shortClassName);
    }

    public function testGetClassNamespace()
    {
        $clsssNamespace = $this->createClassHelper()->getClassNamespace(ClassHelper::class);
        $this->assertEquals('SprykerSdk\Integrator\Business\Helper', $clsssNamespace);
    }

    public function testGetOrganisationName()
    {
        $organisationName = $this->createClassHelper()->getOrganisationName(ClassHelper::class);
        $this->assertEquals('SprykerSdk', $organisationName);
    }

    public function testGetOrganisationNameByOneLevel()
    {
        $organisationName = $this->createClassHelper()->getOrganisationName('\ClassHelper');
        $this->assertEquals('ClassHelper', $organisationName);
    }

    public function testGetOrganisationNameByEmptyClassName()
    {
        $organisationName = $this->createClassHelper()->getOrganisationName('');
        $this->assertEquals('', $organisationName);
    }

    public function testGetModuleName()
    {
        $moduleName = $this->createClassHelper()->getModuleName(ClassHelper::class);
        $this->assertEquals('Business', $moduleName);
    }

    public function testGetModuleNameByOneLevelClassName()
    {
        $moduleName = $this->createClassHelper()->getModuleName('ClassHelper');
        $this->assertEquals('', $moduleName);
    }

    public function testGetLayerName()
    {
        $layerName = $this->createClassHelper()->getLayerName(ClassHelper::class);
        $this->assertEquals('Integrator', $layerName);
    }

    public function testGetLayerNameByOneLevelClassName()
    {
        $layerName = $this->createClassHelper()->getLayerName('ClassHelper');
        $this->assertEquals('', $layerName);
    }

    public function testGetLayerNameByEmptyClassName()
    {
        $layerName = $this->createClassHelper()->getLayerName('');
        $this->assertEquals('', $layerName);
    }

    public function createClassHelper(): ClassHelper
    {
        return new ClassHelper();
    }
}
