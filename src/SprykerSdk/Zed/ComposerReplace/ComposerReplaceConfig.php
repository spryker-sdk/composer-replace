<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace;

class ComposerReplaceConfig
{
    /**
     * @var string
     */
    public const TYPE_MISSING = 'missing';

    /**
     * @var string
     */
    public const TYPE_OBSOLETE = 'obsolete';

    /**
     * Specification:
     * - Returns base path to non-split repositories.
     * - Directory must contain a composer.json where the replace section can be found.
     * - Internally we assume that the modules are inside a /Bundles/ModuleName directory.
     *
     * @api
     *
     * @return array<string>
     */
    public function getPathToRepositories(): array
    {
        return [
            'vendor/spryker/spryker/',
            'vendor/spryker/spryker-shop/',
        ];
    }
}
