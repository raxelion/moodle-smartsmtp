# SmartSMTP Manager for Moodle

**Plugin type:** Local + Message output  
**Moodle versions:** 4.5, 5.2  
**License:** GNU GPL v3

## Description

SmartSMTP Manager allows Moodle administrators to configure multiple SMTP accounts
and route different notification types to different mail servers. This prevents
Gmail and other providers from blocking accounts due to high sending volume.

The plugin consists of two components that work together:

- `local_smartsmtp` — account management, routing rules, logs, and settings
- `message_smartsmtp` — message output processor that routes Moodle notifications through the selected SMTP account

## Features

### Free version
- Register up to 2 SMTP accounts
- Assign notification types to specific accounts
- Automatic fallback if an account reaches its daily limit
- Email sending logs
- Compatible with Gmail, Outlook, and custom SMTP servers

### Premium version ($79 USD / site / year)
- Unlimited SMTP accounts
- Round-robin load balancing between accounts
- Priority support

More information at [raxelion.com/smartsmtp-premium](https://raxelion.com/smartsmtp-premium)

## Requirements

- Moodle 4.5 or higher
- Server requirements follow the official [Moodle compatibility table](https://moodledev.io/general/releases)

## Installation

1. Download the plugin package
2. Extract `local/smartsmtp/` to your Moodle root under `local/`
3. Extract `message/output/smartsmtp/` to your Moodle root under `message/output/`
4. Go to `Site Administration → Notifications`
5. Follow the installation wizard

## Configuration

After installation go to:
`Site Administration → Plugins → Local plugins → SmartSMTP Manager`

1. Add your first SMTP account
2. Mark it as default
3. Optionally configure notification rules
4. Test the connection

To activate the message processor go to:
`Site Administration → Messaging → Message outputs`
and enable **SmartSMTP**.

## Support

- Issues: https://raxelion.com/smartsmtp/docs
- Documentation: https://raxelion.com/smartsmtp/docs

## License

GNU General Public License v3.0