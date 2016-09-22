<?php
namespace MKcom\Utilities\Email;

/*
 * This file is part of the MKcom.Utilities package.
 */

use TYPO3\Flow\Annotations as Flow;

/**
 * Class EmailTemplateHelper
 *
 * @package MKcom\Utilities\Email
 *
 * @Flow\Scope("singleton")
 */
class EmailTemplateHelper
{

    /**
     * @var string
     */
    protected $messageBody;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @param $templatePath string
     * @param $values array
     * @return boolean
     */
    public function parse($templatePath, $values = array())
    {
        if (!is_string($templatePath) || empty($templatePath)) {
            return FALSE;
        }

        $template = file_get_contents($templatePath);

        if (empty($template)) {
            return FALSE;
        }

        $parsedXml = simplexml_load_string($template);

        $this->messageBody = $parsedXml->messageBody->asXml();
        $this->messageBody = preg_replace('/(<messageBody.*>|<\/messageBody>)/', '', $this->messageBody);
        $this->messageBody = preg_replace('/^\n/', '', $this->messageBody);
        $this->messageBody = preg_replace('/^[ \t]*/m', '', $this->messageBody);

        foreach ($values as $key => $value) {
            $this->messageBody = str_replace('###' . strtoupper($key) . '###', $value, $this->messageBody);
        }

        $this->subject = $parsedXml->subject->__toString();
        $this->subject = preg_replace('/(^[ \n\t]*|\n)/m', '', $this->subject);

        return TRUE;
    }

    /**
     * @return string
     */
    public function getLastMessageBody()
    {
        return (string)$this->messageBody;
    }

    /**
     * @return string
     */
    public function getLastSubject()
    {
        return (string)$this->subject;
    }

}