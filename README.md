# WebRox 3.0.0

WebRox is a Content Management System (CMS) for Mu Online servers. It provides a fast, secure framework for server owners to manage their website: donations (Stripe, PayPal, Mercado Pago), VIP, Castle Siege, Discord integration, rankings, downloads, and more.

## Getting Started

These instructions will help you deploy your website using WebRox.

## Prerequisites

- Apache mod_rewrite
- PHP 8.3
- ionCube Loader v14 (required to run the encoded application)
- PHP modules: PDO (SQL Server/MySQL), cURL, OpenSSL, GD, JSON, MBstring
- SQL Server or MySQL for the game database

## Installing

1. Download the latest release of WebRox.
2. Upload the ZIP file contents to your web server.
3. Run the installer by going to example.com/install and follow the given instructions.
4. After installation, remove or restrict access to the /install folder if desired.

## Item names (optional)

To show correct item names on the site, copy your MuServer Item.txt (from Data\Item\Item.txt) into the folder storage/item/ on the server. Then in Admin go to Configurações and use Sincronizar Itens (Item.txt).

## Custom templates

Every custom template layout must include the copyright output in the footer: `<?= copyright() ?>`

## Features

- Donations with Stripe, PayPal, Mercado Pago
- VIP system and in-game integration
- Castle Siege plugin
- Discord login and account linking
- Rankings, downloads, news, slider
- Multi-language (PT, EN, ES)
- Responsive layout and dark/light theme

## Other Software

WebRox is possible thanks to the following open source projects.

- PHPMailer
- Guzzle
- Stripe PHP SDK
- League Plates
- Cocur Slugify

## Author

Rox Gaming

## License

WebRox runs only on servers authorized by Rox Gaming and is free only for clients with an active license. See the LICENSE file for details.

## Support

WebRox Official Website - https://roxgaming.net
