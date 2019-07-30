<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

class IndexController extends AbstractActionController
{
    /** @var  TransportInterface */
    private $mailTransport;

    public function __construct(TransportInterface $mailTransport) {
        $this->mailTransport = $mailTransport;
    }


    public function indexAction()
    {
        $mail = new Message();
        $mail->setBody('This is the text of the email.');
        $mail->setFrom('Freeaqingme@example.org', "Sender's name");
        $mail->addTo('Matthew@example.com', 'Name of recipient');
        $mail->setSubject('TestSubject');

        $this->mailTransport->send($mail);
        return new ViewModel();
    }
}
