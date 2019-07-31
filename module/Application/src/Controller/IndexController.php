<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\View\Renderer\RendererInterface;

class IndexController extends AbstractActionController
{
    /** @var  TransportInterface */
    private $mailTransport;

    /** @var RendererInterface */
    private $viewRenderer;

    public function __construct(TransportInterface $mailTransport, RendererInterface $viewRenderer) {
        $this->mailTransport = $mailTransport;
        $this->viewRenderer = $viewRenderer;
    }


    public function indexAction()
    {
        $mail = new Message();
        $mail->setFrom('Freeaqingme@example.org', "Sender's name");
        $mail->addTo('Matthew@example.com', 'Name of recipient');
        $mail->setSubject('TestSubject');

        $body = new MimeMessage();

        // Generate Text Part
        $viewEmailText = new ViewModel();
        $viewEmailText->setTemplate('application/email/welcomeText');
        $emailText = $this->viewRenderer->render($viewEmailText);

        // MIME Add Text Part
        $textPart = new Part($emailText);
        $textPart->type = "text/plain";
        $body->addPart($textPart);

        // Generate HTML Part
        $viewEmailHtml  = new ViewModel();
        $viewEmailHtml->setTemplate('application/email/welcomeHtml');
        $emailHtml = $this->viewRenderer->render($viewEmailHtml);

        // MIME Add HTML Part
        $htmlPart = new Part($emailHtml);
        $htmlPart->type = "text/html";
        $body->addPart($htmlPart);

        // Save body to Message
        $mail->setBody($body);

        $this->mailTransport->send($mail);
        return new ViewModel();
    }
}
