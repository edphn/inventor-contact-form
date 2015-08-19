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
	 * Labels for fields.
	 *
	 * @var array
	 */
	protected $labels = array();

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
	 * @param array $labels
	 */
	public function __construct(array $data, array $labels)
	{
		$this->data = $data;
		$this->labels = $labels;
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
			$this->errors['name'] = JText::_('MOD_WIREFLY_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
		}

		if ( ! $this->data['email']) {

			$this->errors['email'] = JText::_('MOD_WIREFLY_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
		} elseif ( ! filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
			$this->errors['email'] = JText::_('MOD_WIREFLY_CONTACT_FORM_FRONT_VALIDATION_EMAIL');
		}

		if ( ! $this->data['message']) {
			$this->errors['message'] = JText::_('MOD_WIREFLY_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
		}
	}

	/**
	 * Return validation errors.
	 *
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Determine whether there is validation error
	 * for given field name.
	 *
	 * @param string $fieldName
	 * @return bool
	 */
	public function hasError($fieldName)
	{
		return isset($this->errors[$fieldName]);
	}

	/**
	 * Return error for given field name.
	 *
	 * @param string $fieldName
	 * @return string
	 */
	public function error($fieldName)
	{
		return $this->errors[$fieldName];
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
		$phrases = array('name', 'email', 'phone', 'message');

		$placeholders = array_map(function($item) {
			return sprintf("{%s}", $item);
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
			$headers .= sprintf("Cc: %s\r\n", $this->params['cc']);
		}

		if ($this->params['bcc']) {
			$headers .= sprintf("Bcc: %s\r\n", $this->params['bcc']);
		}

		return $headers ?: null;
	}
}
