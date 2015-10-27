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

class FormBuilder
{
    /**
     * Open new HTML form.
     *
     * @param string $action
     * @param string $method
     * @param array $options
     * @return string
     */
    public function open($action, $method = 'post', array $options = [])
    {
        $options['action'] = $action;
        $options['method'] = $method;

        return sprintf('<form %s>', $this->createAttributes($options));
    }

    /**
     * Close HTML form.
     *
     * @return string
     */
    public function close()
    {
        return '</form>';
    }

    /**
     * Create attributes string.
     *
     * @param array $options
     * @return string
     */
    private function createAttributes(array $options)
    {
        $options = array_filter($options);

        array_walk($options, function(&$value, $key) {
            $value = sprintf('%s="%s"', $key, $value);
        });

        return implode(' ', $options);
    }

    /**
     * Create input field.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array $options
     * @return string
     */
    private function input($type, $name, $value = null, $options = [])
    {
        $options['type'] = $type;
        $options['name'] = $name;
        $options['value'] = $value;

        return sprintf('<input %s>', $this->createAttributes($options));
    }

    /**
     * Create label element.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function label($value, $options)
    {
        return sprintf('<label %s>%s</label>', $this->createAttributes($options), $value);
    }

    /**
     * Create text input field.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @return string
     */
    public function text($name, $value = null, $options = [])
    {
        return $this->input('text', $name, $value, $options);
    }

    /**
     * Create textarea field.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @return string
     */
    public function textarea($name, $value = null, $options = [])
    {
        $options['name'] = $name;

        return sprintf('<textarea %s>%s</textarea>', $this->createAttributes($options), $value);
    }

    /**
     * Create button element
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function button($value, $options = [])
    {
        return sprintf('<button %s>%s</button>', $this->createAttributes($options), $value);
    }
}
