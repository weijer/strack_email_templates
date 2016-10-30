<?php
namespace MKcom\Utility;

/*
 * This file is part of the MKcom.Utility.EmailTemplates package.
 */

use MKcom\Utility\Exception\EmailTemplateNotFoundException;

/**
 * Class EmailTemplate
 *
 * @package MKcom\Utility
 */
class EmailTemplate
{

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * EmailTemplate constructor.
     *
     * @param string $pathToTemplateFile
     * @param array $values
     * @throws EmailTemplateNotFoundException
     */
    public function __construct($pathToTemplateFile, $values = array())
    {
        if (!is_string($pathToTemplateFile) || empty($pathToTemplateFile)) {
            throw new \InvalidArgumentException('Argument "templatePath" is not defined (empty or not a string).', 1475321772);
        }

        if (!is_file($pathToTemplateFile)) {
            throw new EmailTemplateNotFoundException('Email template not found.', 1477848986);
        }

        $template = file_get_contents($pathToTemplateFile);

        foreach ($values as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $this->body = $template;

        $parsedXml = simplexml_load_string($template);

        $this->subject = $parsedXml->head->subject->__toString();
        $this->subject = preg_replace('/(^[ \n\t]*|\n)/m', '', $this->subject);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return (string)$this->body;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return (string)$this->subject;
    }

}
