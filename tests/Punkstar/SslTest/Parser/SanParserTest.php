<?php

namespace Punkstar\SslTest\Parser;

use PHPUnit\Framework\TestCase;
use Punkstar\Ssl\Parser\SanParser;

class SanParserTest extends TestCase
{
    /**
     * @test
     */
    public function testParse()
    {
        $input = "DNS:sni65533.cloudflaressl.com, DNS:*.brycemcdonnell.com, DNS:*.cubecountry.com, DNS:*.cylindric.net, DNS:*.drop22.net, DNS:*.ectv.ca, DNS:*.enigmagen.co.uk, DNS:*.enigmagen.com, DNS:*.enigmagen.org, DNS:*.fangpleng.com, DNS:*.inandaroundboston.co.uk, DNS:*.interviewmyass.co.uk, DNS:*.kibakoapp.com, DNS:*.lefortovo-wiki.ru, DNS:*.londondevilettes.ca, DNS:*.luminexcorp.de, DNS:*.marilynsgarments.com, DNS:*.nicksays.co.uk, DNS:*.nothavingawedding.com, DNS:*.obx-vacation-rentals.com, DNS:*.perf.watch, DNS:*.plainandsimple.store, DNS:*.pocketcluster.io, DNS:*.rpackage.io, DNS:*.rpkg.io, DNS:*.severehypertension.net, DNS:*.starepod.com, DNS:*.thedevranch.net, DNS:*.thenewswall.co.uk, DNS:*.trackssl.com, DNS:*.xbvids.com, DNS:brycemcdonnell.com, DNS:cubecountry.com, DNS:cylindric.net, DNS:drop22.net, DNS:ectv.ca, DNS:enigmagen.co.uk, DNS:enigmagen.com, DNS:enigmagen.org, DNS:fangpleng.com, DNS:inandaroundboston.co.uk, DNS:interviewmyass.co.uk, DNS:kibakoapp.com, DNS:lefortovo-wiki.ru, DNS:londondevilettes.ca, DNS:luminexcorp.de, DNS:marilynsgarments.com, DNS:nicksays.co.uk, DNS:nothavingawedding.com, DNS:obx-vacation-rentals.com, DNS:perf.watch, DNS:plainandsimple.store, DNS:pocketcluster.io, DNS:rpackage.io, DNS:rpkg.io, DNS:severehypertension.net, DNS:starepod.com, DNS:thedevranch.net, DNS:thenewswall.co.uk, DNS:trackssl.com, DNS:xbvids.com";
        $output = [
            "sni65533.cloudflaressl.com",
            "*.brycemcdonnell.com",
            "*.cubecountry.com",
            "*.cylindric.net",
            "*.drop22.net",
            "*.ectv.ca",
            "*.enigmagen.co.uk",
            "*.enigmagen.com",
            "*.enigmagen.org",
            "*.fangpleng.com",
            "*.inandaroundboston.co.uk",
            "*.interviewmyass.co.uk",
            "*.kibakoapp.com",
            "*.lefortovo-wiki.ru",
            "*.londondevilettes.ca",
            "*.luminexcorp.de",
            "*.marilynsgarments.com",
            "*.nicksays.co.uk",
            "*.nothavingawedding.com",
            "*.obx-vacation-rentals.com",
            "*.perf.watch",
            "*.plainandsimple.store",
            "*.pocketcluster.io",
            "*.rpackage.io",
            "*.rpkg.io",
            "*.severehypertension.net",
            "*.starepod.com",
            "*.thedevranch.net",
            "*.thenewswall.co.uk",
            "*.trackssl.com",
            "*.xbvids.com",
            "brycemcdonnell.com",
            "cubecountry.com",
            "cylindric.net",
            "drop22.net",
            "ectv.ca",
            "enigmagen.co.uk",
            "enigmagen.com",
            "enigmagen.org",
            "fangpleng.com",
            "inandaroundboston.co.uk",
            "interviewmyass.co.uk",
            "kibakoapp.com",
            "lefortovo-wiki.ru",
            "londondevilettes.ca",
            "luminexcorp.de",
            "marilynsgarments.com",
            "nicksays.co.uk",
            "nothavingawedding.com",
            "obx-vacation-rentals.com",
            "perf.watch",
            "plainandsimple.store",
            "pocketcluster.io",
            "rpackage.io",
            "rpkg.io",
            "severehypertension.net",
            "starepod.com",
            "thedevranch.net",
            "thenewswall.co.uk",
            "trackssl.com",
            "xbvids.com"
        ];

        $sanParser = new SanParser();
        $result = $sanParser->parse($input);

        $this->assertInternalType('array', $result);
        $this->assertCount(count($output), $result);

        foreach ($output as $outputItem) {
            $this->assertContains($outputItem, $result);
        }
    }
}
