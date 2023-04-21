<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/20
 * Time: 22:33
 */

namespace app\ExtraExpand\server;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

//发送邮件类

class EmailSender
{
    private $mailer;
    private $senderAddress;

    public function __construct(TransportInterface $transport, string $senderAddress)
    {
        $this->mailer = new Mailer($transport);
        $this->senderAddress = $senderAddress;
    }

    public function sendEmail(string $subject, string $textBody, string $htmlBody, array $attachments, array $toRecipients, array $ccRecipients = [], array $bccRecipients = [])
    {
        $email = (new Email())
            ->from(new Address($this->senderAddress))
            ->to(...$toRecipients)
            ->cc(...$ccRecipients)
            ->bcc(...$bccRecipients)
            ->subject($subject)
            ->text($textBody)
            ->html($htmlBody);

        foreach ($attachments as $attachment) {
            $email->attachFromPath($attachment['path'], $attachment['filename']);
        }

        $this->mailer->send($email);
    }
}