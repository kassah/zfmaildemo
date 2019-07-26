<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $mail = new Mail\Message();
        $mail->setBody('This is the text of the email.');
        $mail->setFrom('Freeaqingme@example.org', "Sender's name");
        $mail->addTo('Matthew@example.com', 'Name of recipient');
        $mail->setSubject('TestSubject');

        $transport = new SmtpTransport();
        $options   = new SmtpOptions([
            'name' => 'zf',
            'host' => 'mailhog',
            'port' => 1025,
        ]);
        $transport->setOptions($options);
        $transport->send($mail);
        return new ViewModel();
    }
}
