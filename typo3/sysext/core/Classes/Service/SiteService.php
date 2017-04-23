<?php
declare(strict_types=1);

namespace TYPO3\CMS\Core\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Domain stuff
 */
class SiteService implements SingletonInterface
{

    /** @var array */
    protected $sites = [];

    /**
     * Initialize domain configuration
     * @param array $sites
     */
    public function __construct(array $sites = [])
    {
        $this->sites = (count($sites) === 0) ? (array)$GLOBALS['TYPO3_CONF_VARS']['SYS']['sites'] : $sites;
    }

    /**
     * Get first configured domain from all sites
     *
     * @return string
     */
    public function getFirstDomain()
    {
        $firstSite = $this->getFirstSite();
        return $this->getFirstDomainFromSiteArray($firstSite);
    }

    /**
     * @param int $pageId
     * @return string
     */
    public function getFirstDomainForPage(int $pageId): string
    {
        $rootPageIds = $this->getRootPageIdByPageId($pageId);
        $siteByPageId = $this->getSiteForRootPageId($rootPageIds);
        return $this->getFirstDomainFromSiteArray($siteByPageId);
    }

    /**
     * Returns the configured domain from a site array or an empty string.
     *
     * @param array $site
     * @return string
     */
    protected function getFirstDomainFromSiteArray(array $site): string
    {
        return (empty($site['domains'][0])) ? '' : $site['domains'][0];
    }

    /**
     * Get start page id of given domain
     *
     * @param string $domain
     * @return int
     */
    public function getRootPageOfDomain(string $domain)
    {
        foreach ($this->sites as $pageId => $site) {
            if(!is_array($site['domains'])) {
                continue;
            }
            if (in_array($domain, $site['domains'], true)) {
                return $pageId;
            }
        }
    }

    /**
     * Get all domains
     *
     * @return array
     */
    public function getAllDomains(): array
    {
        $domainList = [];
        foreach ($this->sites as $site) {
            if(!is_array($site['domains'])) {
                continue;
            }
            $domainList = array_merge($domainList, $site['domains']);
        }

        return $domainList;
    }

    /**
     * Retrieves the first configured site.
     *
     * @return array
     */
    protected function getFirstSite()
    {
        return (array)reset($this->sites);
    }

    /**
     * Retrieves the configured site for a rootPageId.
     *
     * @param int $pageId
     * @return array
     */
    protected function getSiteForRootPageId(int $pageId): array
    {
        return is_array($this->sites[$pageId]) ? $this->sites[$pageId] : [];
    }

    /**
     * @param integer $pageId
     * @return int
     */
    protected function getRootPageIdByPageId(int $pageId): int
    {
        //@todo we need to resolve the rootPageId
        return $pageId;
    }
}
