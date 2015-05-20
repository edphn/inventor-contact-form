<?php

defined('_JEXEC') or die;

class ContactFormValidator
{
	/**
	 * Data to be validated.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * The validation errors.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Create new instance of ContactFormValidator.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Determine whether validation passes.
	 *
	 * @return bool
	 */
	public function passes()
	{
		return ! $this->fails();
	}

	/**
	 * Determine whether validation fails.
	 *
	 * @return bool
	 */
	public function fails()
	{
		$this->validate();
		return (bool) count($this->errors);
	}

	/**
	 * Perform validation.
	 *
	 * @return void
	 */
	protected function validate()
	{
		if ( ! $this->data['name']) {
			$this->errors['name'] = 'Name is required.';
		}

		if ( ! $this->data['email']) {
			$this->errors['email'] = 'Email is required.';
		} elseif ( ! filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
			$this->errors['email'] = 'Email is incorrect';
		}

		if ( ! $this->data['message']) {
			$this->errors['message'] = 'Message is required.';
		}
	}
}

class Mailer
{
	/**
	 * Data from form submission.
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * Module parameters.
	 *
	 * @var array
	 */
	private $params = array();

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
		return $this->params['message_template'];
	}

	/**
	 * Prepare additional headers.
	 *
	 * @return string|mixed
	 */
	private function prepareHeaders()
	{
		$headers = '';

		if ($this->params['cc']) {
			$headers .= sprintf("Cc: %s\r\n", $this->params['cc']);
		}

		if ($this->params['bcc']) {
			$headers .= sprintf("Bcc: %s\r\n", $this->params['bcc']);
		}

		return $headers ?: null;
	}
}