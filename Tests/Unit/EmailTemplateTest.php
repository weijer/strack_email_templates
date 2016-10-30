<?php
namespace MKcom\Utility\Tests\Unit;

/*
 * This file is part of the MKcom.SMS77 package.
 */

use MKcom\Utility\EmailTemplate;
use MKcom\Utility\Exception\EmailTemplateNotFoundException;
use PHPUnit_Framework_TestCase;

/**
 * Class EmailTemplateTest
 *
 * @package MKcom\Utility\Tests\Unit
 */
class EmailTemplateTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @return void
     */
    public function aTemplateCanBeLoaded()
    {
        $fileContent = file_get_contents(__DIR__ . '/Templates/TestTemplate.html');

        $fileContent = str_replace('{{firstName}}', 'John', $fileContent);
        $fileContent = str_replace('{{firstName2}}', 'Max', $fileContent);

        $emailTemplate = new EmailTemplate(__DIR__.'/Templates/TestTemplate.html', array(
            'firstName' => 'John',
            'firstName2' => 'Max',
        ));

        $this->assertEquals('This is a dummy template', $emailTemplate->getSubject());
        $this->assertEquals($fileContent, $emailTemplate->getBody());
    }

    /**
     * @test
     *
     * @return void
     */
    public function anExceptionWillBeThrownOnInvalidArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $emailTemplate = new EmailTemplate(NULL);
    }

    /**
     * @test
     *
     * @return void
     */
    public function anExceptionWillBeThrownOnNotExistingTemplate()
    {
        $this->expectException(EmailTemplateNotFoundException::class);
        $emailTemplate = new EmailTemplate('notExistingTemplate.html');
    }

}
