# MKcom.Utility.EmailTemplates

Simple class for parsing email templates written in HTML with variable data.

## Installation

### via Composer

**Note:** This package is not registered on packagist.org.

```bash
$ composer config repositories.mkcom/utility-emailtemplates vcs git@github.com:mkeitsch/utility-emailtemplates.git

$ composer require mkcom/utility-emailtemplates
```

## Using EmailTemplates

Create a simple HTML file for an email template.

Use `subject` instead of `title` for your email subject in the head section.
 
Double curly braces `{{}}` are used for defining variables. You can use it wherever you want in the template. I recommend using camelCased variable names. These are tested. But you can use and test whatever you want.

```html
<!DOCTYPE html>
<html>
    <head>
        <subject>
            My Subject For A New Email
        </subject>
    </head>
    <body>
        Hey {{firstName}},

        this is a my email template.

        Greetings {{senderName}} :)
    </body>
</html>
```

Create a new email template by just instantiating the `EmailTemplate` class with the location of the template file and an array of variables that should be inserted as arguments.

```php
$emailTemplate = new EmailTemplate(__DIR__.'/Templates/myEmailTemplate.html', array(
    'firstName' => 'John',
    'senderName' => 'Max',
));

$emailBody = $emailTemplate->getBody();
$emailSubject = $emailTemplate->getSubject();
```
