SSTP
====

Sakura Script Transfer Protocol
[http://usada.sakura.vg/contents/sstp.html](http://usada.sakura.vg/contents/sstp.html)

## Install

Add the package to your composer.json and run composer update.

```json
{
    "require": {
        "kinzal/sstp": "dev-master"
    }
}

```

## Example

```php
$sstp = new SSTP();
$sstp->message = '
    SEND SSTP/1.1
    Sender: カードキャプター
    Script: \h\s0汝のあるべき姿に戻れ。\e
    Option: nodescript,notranslate
    Charset: Shift_JIS
';
$response = $sstp->send('127.0.0.1', 9801, 2);

echo $response; // -> SSTP/1.1 200 OK\r\n

```
