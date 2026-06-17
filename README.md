# SmartSMTP for Moodle

SmartSMTP is an advanced email routing plugin for Moodle that allows administrators to configure multiple SMTP accounts with intelligent rule-based routing, ensuring reliable email delivery for your Moodle site.

## Description

Moodle sites often rely on a single SMTP server for all outgoing email, which can lead to deliverability issues, rate limiting, or a single point of failure. SmartSMTP solves this by letting administrators configure multiple SMTP accounts and define routing rules that determine which account handles each message, based on the message type, component, or recipient.

## Features (Free version)

- Up to 2 SMTP mailboxes
- Up to 2 routing rules
- Full admin interface for managing accounts and rules
- Built-in logging of sent messages
- Compatible with Moodle 4.5 - 5.2

## Premium version

The premium version unlocks:

- Unlimited SMTP mailboxes
- Unlimited routing rules
- Round-robin load balancing across accounts
- Name-granularity routing (route by sender name, not just component)
- Priority email support

For pricing and purchase, visit [raxelion.com](https://raxelion.com)

## Installation

This plugin consists of two components that must both be installed:

1. Copy the `local/smartsmtp` folder into your Moodle `/local/` directory
2. Copy the `message/output/smartsmtp` folder into your Moodle `/message/output/` directory
3. Log in as an administrator and visit **Site administration > Notifications** to complete the installation
4. Go to **Site administration > Plugins > Local plugins > SmartSMTP** to configure your SMTP accounts and routing rules
5. Go to **Site administration > Plugins > Message outputs > SmartSMTP** to enable the message output

## Requirements

- Moodle 4.5 or higher
- PHP 8.0 or higher

## Configuration

After installation, add your SMTP account(s) under the SmartSMTP local plugin settings page. Then create routing rules to determine which account should handle messages from specific Moodle components (e.g. password resets, forum notifications, new user registration).

## Support

For questions, bug reports, or feature requests:

- Email: contacto@raxelion.com
- Website: https://raxelion.com

## License

This plugin is licensed under the GNU GPL v3 or later. See the LICENSE file for details.

## Maintained by

Raxelion Software Strategies
https://raxelion.com
