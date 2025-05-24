# AI Hashtag Generator with OpenRouter API

![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)

A web application that generates relevant hashtags from text input using OpenRouter's AI models.

## Features

- 🚀 AI-powered hashtag generation
- 📱 Responsive Tailwind CSS design
- 📋 Click-to-copy hashtags
- 🛡️ Secure API key handling
- 🔄 Rate limiting support
- 📊 Error handling and logging
- 🔒 SSL verification

## Installation

### Requirements
- WAMP/LAMP stack
- PHP 8.3+
- cURL enabled
- Composer (for Tailwind CSS)

1. Clone repository:
```bash
git clone https://github.com/yourusername/ai-hashtag-generator.git
cd ai-hashtag-generator
```

2. Install dependencies:
```bash
composer require tailwindcss
```

3. Configure environment:
```bash
cp .env.example .env
```

4. Set permissions:
```bash
chmod -R 755 tmp/
chmod -R 755 logs/
```

## Configuration

### Environment Variables (`.env`)
```ini
OPENROUTER_API_KEY=your_api_key_here
OPENROUTER_ENDPOINT=https://openrouter.ai/api/v1/chat/completions
CA_BUNDLE_PATH=C:/wamp64/bin/php/php8.3.6/extras/ssl/cacert.pem
```

### php.ini Settings
```ini
[curl]
curl.cainfo = "C:/wamp64/bin/php/php8.3.6/extras/ssl/cacert.pem"
openssl.cafile = "C:/wamp64/bin/php/php8.3.6/extras/ssl/cacert.pem"
```

## Usage

1. Start WAMP server
2. Navigate to `http://localhost/ai-hashtag-generator`
3. Enter text and click "Generate Hashtags"

![Demo Screenshot](/screenshots/demo.png)

## Security

- 🔑 Never commit `.env` file
- 🔒 Use HTTPS in production
- ⏱️ Implement rate limiting
- 🧹 Sanitize all user inputs
- 📉 Monitor API usage via [OpenRouter Dashboard](https://openrouter.ai/keys)

## Roadmap

- [ ] Model selection dropdown
- [ ] Hashtag popularity analysis
- [ ] Multi-language support
- [ ] API response caching
- [ ] User authentication
- [ ] Usage statistics dashboard

## Contributing

1. Fork the repository
2. Create feature branch:
```bash
git checkout -b feature/amazing-feature
```
3. Commit changes
4. Push to branch
5. Open pull request

## Contact  
✉️ For support or inquiries:  
[![LinkedIn](https://img.shields.io/badge/LinkedIn-amanullahykhan-blue)](https://www.linkedin.com/in/amanullahykhan/)  
[![GitHub](https://img.shields.io/badge/GitHub-amanullahykhan-black)](https://github.com/amanullahykhan)  

## License

MIT License - see [LICENSE](LICENSE) for details

## Acknowledgments

- OpenRouter.ai for the AI API
- Tailwind CSS for styling
- PHP cURL for secure requests
```

This README includes:

1. Clear installation instructions
2. Configuration requirements
3. Security best practices
4. Development roadmap
5. Contribution guidelines
6. License information
7. Responsive badges
8. Visual demo screenshot
9. Environment setup guide

You should also create these additional files:
1. `.gitignore` - to exclude sensitive files
2. `LICENSE` - MIT license text
3. `.env.example` - template for environment variables
4. `security.md` - detailed security practices

Would you like me to create any of these additional files as well?
