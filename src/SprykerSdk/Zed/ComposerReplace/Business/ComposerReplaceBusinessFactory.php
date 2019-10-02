<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdater;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdaterInterface;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidator;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface;

/**
 * @method \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig getConfig()
 */
class ComposerReplaceBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface
     */
    public function createComposerReplaceValidator(): ComposerReplaceValidatorInterface
    {
        return new ComposerReplaceValidator($this->getConfig());
    }

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdaterInterface
     */
    public function createComposerReplaceUpdater(): ComposerReplaceUpdaterInterface
    {
        return new ComposerReplaceUpdater($this->createComposerReplaceValidator());
    }
}
