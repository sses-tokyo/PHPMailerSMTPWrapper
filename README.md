# PHPMailerSMTPWrapper

## Description

This is the PHPMailerWrapper for SMTP.

## Installation & loading

PHPMailerSMTPWrapper is available on [Packagist](https://packagist.org/packages/sses-tokyo/php-mailer-smtp-wrapper) (using semantic versioning), and installation via composer is the recommended way to install PHPMailerSMTPWrapper. Just add this line to your `composer.json` file:

```json
"sses-tokyo/php-mailer-smtp-wrapper": "^1.0"
```

or run

```sh
composer require sses-tokyo/php-mailer-smtp-wrapper
```

## A Simple Example

```php
<?php
require 'vendor/autoload.php';

use SSESTokyo\PHPMailerSMTPWrapper\PHPMailerSMTPWrapper;

$debug    = 0;
$secure   = 'tls';
$host     = 'example.com';
$port     = '587';
$user     = 'test@example.com';
$password = '***';
$mail = new PHPMailerSMTPWrapper($debug, $secure, $host, $port, $user, $password);

$to = 'test@example.com';
$subject = 'PHPMailerSMTPWrapper';
$body = 'This is a test mail.';
$fromname = $user;
$fromaddress = $user;
$res = $mail->send($to, $subject, $body, $fromname, $fromaddress);
echo $res;
