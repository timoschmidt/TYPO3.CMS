<?php
namespace TYPO3\CMS\Core\Tests\Unit\Service;

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

use TYPO3\CMS\Core\Service\SiteService;

/**
 * Unit test for the SiteService
 */
class SiteServiceTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{

    /**
     * @test
     */
    public function canGetFirstDomain()
    {
        $sites = [
            32 => [
                'domains' => ['mysite.com']
            ]
        ];
        $siteService = new SiteService($sites);
        $this->assertSame('mysite.com', $siteService->getFirstDomain());
    }

    /**
     * @test
     */
    public function canGetFirstDomainByArraySorting()
    {
        $sites = [
            78 => [
                'domains' => ['mymicrosite.com']
            ],
            32 => [
                'domains' => ['mysite.com']
            ]
        ];

        $siteService = new SiteService($sites);
        $this->assertSame('mymicrosite.com', $siteService->getFirstDomain());

        // also a secomd request should still give the same domain
        $this->assertSame('mymicrosite.com', $siteService->getFirstDomain());

    }

    /**
     * @test
     */
    public function canGetFirstDomainByPage()
    {
        $sites = [
            32 => [
                'domains' => ['mysite.com']
            ],
            78 => [
                'domains' => ['mymicrosite.com']
            ]
        ];

        $siteService = new SiteService($sites);
        $this->assertSame('mymicrosite.com', $siteService->getFirstDomainForPage(78));
    }

    /**
     * @test
     */
    public function canGetRootPageForDomain()
    {
        $sites = [
            32 => [
                'domains' => ['mysite.com']
            ],
            78 => [
                'domains' => ['mymicrosite.com']
            ]
        ];

        $siteService = new SiteService($sites);
        $this->assertSame(78, $siteService->getRootPageOfDomain('mymicrosite.com'));
    }

    /**
     * @test
     */
    public function canGetAllDomains()
    {
        $sites = [
            32 => [
                'domains' => ['mysite.com']
            ],
            78 => [
                'domains' => ['mymicrosite.com']
            ]
        ];

        $siteService = new SiteService($sites);
        $this->assertSame(['mysite.com','mymicrosite.com'], $siteService->getAllDomains());
    }
}