<?php

namespace AppBundle\Tests\Command;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class NotifyQuotesCommandTest extends WebTestCase {

    public function testExecution()
    {
        $referenceRepository = $this
            ->loadFixtures([
                'AppBundle\DataFixtures\ORM\LoadUserRoleData',
                'AppBundle\DataFixtures\ORM\LoadUserGroupData',
                'AppBundle\DataFixtures\ORM\LoadUserData',
                'AppBundle\DataFixtures\ORM\LoadArticleData',
                'AppBundle\DataFixtures\ORM\LoadQuoteData',
            ])
            ->getReferenceRepository();

        $article = $referenceRepository->getReference('article-1');

        $output = $this->runCommand('notify:quotes');

        $outputLines = explode(PHP_EOL, $output);

        $this->assertEquals(
            sprintf('Sending an email to: %s', $article->getUser()->getEmail()),
            $outputLines[1]
        );

        $this->assertEquals(
            sprintf('Done'),
            $outputLines[2]
        );

        $this->markTestIncomplete('Would like to enable email profiler to test the spool is not empty');
    }
}
