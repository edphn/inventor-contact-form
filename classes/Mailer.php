<?php

defined('_JEXEC') or die;

class Mailer
{
    /**
     * Data from form submission.
     *
     * @var array
     */
    private $data = [];

    /**
     * Module parameters.
     *
     * @var array
     */
    private $params = [];

    /**
     * Create new instance of MailSender class.
     *
     * @param array $params
     * @param array $data
     */
    public function __construct(array $params, array $data)
    {
        $this->params = $params;
        $this->data = $data;
    }

    /**
     * Send mail.
     *
     * @return void
     */
    public function send()
    {
        $recipient = $this->params['to'];
        $subject = $this->params['subject'];
        $message = $this->prepareMessageBody();
        $headers = $this->prepareHeaders();

        mail($recipient, $subject, $message, $headers);
    }

    /**
     * Prepare message body. Interpolate variables into template.
     *
     * @return string
     */
    private function prepareMessageBody()
    {
        $phrases = array('name', 'email', 'phone', 'message');

        $placeholders = array_map(function($item) {
            return sprintf('{%s}', $item);
        }, $phrases);

        $replacements = array_map(function($item) {
            return $this->data[$item];
        }, $phrases);

        return str_replace($placeholders, $replacements, $this->params['message_template']);
    }

    /**
     * Prepare additional headers.
     *
     * @return string|mixed
     */
    private function prepareHeaders()
    {
        $headers = 'Content-type: text/html; charset=utf-8';

        if ($this->params['cc']) {
            $headers .= sprintf('Cc: %s\r\n', $this->params['cc']);
        }

        if ($this->params['bcc']) {
            $headers .= sprintf('Bcc: %s\r\n', $this->params['bcc']);
        }

        return $headers ?: null;
    }
}
