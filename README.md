# mystoq/sdk

> Official PHP SDK for [Mystoq](https://mystoq.com) -
> the simplest way to launch a cash-on-delivery online store in Algeria & MENA.

[![Packagist](https://img.shields.io/badge/composer-mystoq%2Fsdk-orange)](https://packagist.org/packages/mystoq/sdk)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D%208.1-blue)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

## Install

```bash
composer require mystoq/sdk
```

## Quickstart

```php
use Mystoq\Client;

$mystoq = new Client(
    apiKey: getenv("MYSTOQ_API_KEY"),
    tenant: "your-store",
);

$products = $mystoq->listProducts(["limit" => 20]);

$order = $mystoq->createOrder([
    "customer" => ["name" => "Yaakoub", "phone" => "+213555123456"],
    "items"    => [["product_id" => "p_123", "quantity" => 2]],
    "shipping" => ["wilaya" => "Annaba"],
    "payment_method" => "cod",
]);

echo "Order #" . $order["id"];
```

## Why Mystoq

- 5-minute storefront for cash-on-delivery (95% of Algerian online payments are COD)
- Yalidine + Maystro + Stop Desk integrations
- WhatsApp Commerce + FakeShield (AI fraud detection)
- Built in Algeria, for Algerian merchants

→ https://mystoq.com

## Other SDKs

JavaScript: [`mystoq-js-sdk`](https://github.com/hartemyaakoub/mystoq-js-sdk) ·
Python: [`mystoq-python-sdk`](https://github.com/hartemyaakoub/mystoq-python-sdk) ·
CLI: [`mystoq-cli`](https://github.com/hartemyaakoub/mystoq-cli)

## License

MIT - by [Hartem Yaakoub](https://hartem.tkawen.com) ·
[TKAWEN ecosystem](https://tkawen.com).
