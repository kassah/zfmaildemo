<?php


namespace Application\Mail\Transport;

use Exception;
use Mailgun\Mailgun;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Message;
use Zend\Mime\Mime;
use Zend\Mime\Message as MimeMessage;

/**
 * Class MailgunTransport
 * Use this transport for all our emailing. This will allow us to switch email providers down the road.
 * @package Application\Mail\Transport\MailgunTransport
 */
class MailgunTransport implements TransportInterface
{
    private $domain;
    private $apiKey;
    private $toOverride;
    private $from;

    /**
     * @param string $domain
     * @param string $apiKey
     */
    public function __construct($domain, $apiKey, $toOverride, $from)
    {
        $this->domain = (string)$domain;
        $this->apiKey = (string)$apiKey;
        $this->toOverride = (string)$toOverride;
        $this->from = (string)$from;
    }

    /**
     * @param Message $message
     * @return string|null
     */
    private function extractText(Message $message)
    {
        $body = $message->getBody();
        if (is_string($body)) {
            return $body;
        }
        if (!$body instanceof MimeMessage) {
            return null;
        }
        foreach ($body->getParts() as $part) {
            if ($part->type === 'text/plain' && $part->disposition !== Mime::DISPOSITION_ATTACHMENT) {
                return $part->getContent();
            }
        }
        return null;
    }

    /**
     * https://www.mailgun.com/blog/delivering-html-emails-mailgun-go
     * DO use inline CSS
     * DO use HTML TABLES for layout
     * DO use images (prefer .png)
     * DO inline images
     * DON’T use HTML5
     * DON’T use animation CSS
     * DON’T link to an external stylesheet
     * DON’T use CSS styles in the HEAD
     * DON’T use javascript
     * DON’T use flash
     * @param Message $message
     * @return string|null
     */
    private function extractHtml(Message $message)
    {
        $body = $message->getBody();
        // If body is not a MimeMessage object, then the body is just the text version
        if (is_string($body) || !$body instanceof MimeMessage) {
            return null;
        }
        foreach ($body->getParts() as $part) {
            if ($part->type === 'text/html' && $part->disposition !== Mime::DISPOSITION_ATTACHMENT) {
                return $part->getContent();
            }
        }
        return null;
    }

    /**
     * Sends Message over Mailgun API
     *
     * @param Message $message
     * @return \Mailgun\Model\Message\SendResponse
     */
    public function send(Message $message) {
        $mailgunClient = Mailgun::create($this->apiKey);
        $domain = $this->domain;

        //default email address to send email from for application if from is not provided
        if ($message->getFrom()->count() == 0) {
            $from = $this->from;
        } else {
            //Just one sender
            $from = $message->getFrom()->rewind()->toString();
        };

        $text = $this->extractText($message);
        $html = $this->extractHtml($message);

        if ($this->toOverride === '') {
            $to = [];
            foreach ($message->getTo() as $address) {
                $to[] = $address->toString();
            }
        } else {
            $to = [$this->toOverride];
        }

        $response = $mailgunClient->messages()->send($domain, [
            'from' => $from,
            'to' => implode(',', $to),
            'subject' => $message->getSubject(),
            'text' => $text,
            'html' => $html,
        ]);
    }
}
