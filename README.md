# PDF-Signatures
A package to find PDF digital signatures, returned your information.

## Installation:

```bash
$ composer require lukelt/pdf-signatures
```

## OpenSSL
The package needs OpenSSL to run. Download or install in your environment.

Download: **https://www.openssl.org/source/**.

If your environment is Windows, you can download the executable from this link: **https://slproweb.com/products/Win32OpenSSL.html**

### Recommendation

Preferably place the OpenSSL bin folder in your environment variable. For code reduction in your application.

example: C:/Program Files/OpenSSL-Win64/bin

## Examples

```php
use Lukelt\PdfSignatures\PdfSignatures;
require_once('vendor/autoload.php');

$data = PdfSignatures::find('pdf_teste.pdf');
```

It is possible to define the OpenSSL path

```php
use Lukelt\PdfSignatures\PdfSignatures;
require_once('vendor/autoload.php');

PdfSignatures::defineOpenSSL("C:/Program Files/OpenSSL-Win64/bin");
$data = PdfSignatures::find('pdf_teste.pdf');
```
