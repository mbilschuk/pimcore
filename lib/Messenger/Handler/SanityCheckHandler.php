<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Messenger\Handler;

use Pimcore\Messenger\SanityCheckMessage;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\Document\PageSnippet;
use Pimcore\Model\Element\ElementInterface;
use Pimcore\Model\Element\Service;

/**
 * @internal
 */
class SanityCheckHandler
{
    public function __invoke(SanityCheckMessage $message)
    {
        $element = Service::getElementById($message->getType(), $message->getId(), true);
        if ($element) {
            $this->performSanityCheck($element);
        }
    }

    /**
     * @param PageSnippet|Asset|Concrete $element
     *
     * @throws \Exception
     */
    private function performSanityCheck(ElementInterface $element)
    {
        $latestNotPublishedVersion = null;

        if ($latestVersion = $element->getLatestVersion()) {
            if ($latestVersion->getDate() > $element->getModificationDate() || $latestVersion->getVersionCount() > $element->getVersionCount()) {
                $latestNotPublishedVersion = $latestVersion;
            }
        }

        $element->setUserModification(0);
        $element->save(['versionNote' => 'Sanity Check']);

        if ($latestNotPublishedVersion) {
            // we have to make sure that the previous unpublished version is on top of the list again
            // otherwise we will get wrong data in editmode
            $latestNotPublishedVersionCount = $element->getVersionCount() + 1;
            $latestNotPublishedVersion->setVersionCount($latestNotPublishedVersionCount);
            $latestNotPublishedVersion->setNote('Sanity Check');
            $latestNotPublishedVersion->save();
        }
    }
}