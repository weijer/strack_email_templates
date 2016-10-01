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
     * @param $templatePath string
     * @param $values       array
     * @throws EmailTemplateNotFoundException
     */
    public function __construct($templatePath, $values = array())
    {
        if (!is_string($templatePath) || empty($templatePath)) {
            throw new \InvalidArgumentException('Argument "templatePath" is not defined (empty or not a string).', 1475321772);
        }

        $template = file_get_contents($templatePath);

        if (empty($template)) {
            throw new EmailTemplateNotFoundException(sprintf('Template file (%s) could not be found or is empty.', $templatePath), 1475321855);
        }

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