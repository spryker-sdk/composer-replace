<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business;

use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdater;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdaterInterface;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidator;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;

class ComposerReplaceBusinessFactory
{
    /**
     * @var \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    protected $config;

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

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    protected function getConfig(): ComposerReplaceConfig
    {
        if (!$this->config) {
            $this->config = new ComposerReplaceConfig();
        }

        return $this->config;
    }
}
