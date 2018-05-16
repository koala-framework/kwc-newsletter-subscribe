# kwc-newsletter-subscribe
A Koala-Framework component for subscribing to newsletters implemented with [kwc-newsletter](https://github.com/koala-framework/kwc-newsletter).

### Installation
Set the newsletters api-url in your `config.ini`

    [production]
    kwcNewsletterSubscribe.apiUrl = https://newsletter.example.com/api/v1/subscribers

If you use multiple domains, the subscribe component needs to know which newsletter-domain to subscribe.  
To do this you need to set the country for every domain in your `config.ini` like follows:

    kwc.domains.at.country = at
