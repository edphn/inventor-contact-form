<?php

class ContactFormValidator
{
    /**
     * Data to be validated.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Labels for fields.
     *
     * @var array
     */
    protected $labels = [];

    /**
     * The validation errors.
     *
     * @var array
     */
    protected $errors = [];

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
            $this->errors['name'] = JText::_('MOD_INVENTOR_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
        }

        if ( ! $this->data['email']) {

            $this->errors['email'] = JText::_('MOD_INVENTOR_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
        } elseif ( ! filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = JText::_('MOD_INVENTOR_CONTACT_FORM_FRONT_VALIDATION_EMAIL');
        }

        if ( ! $this->data['message']) {
            $this->errors['message'] = JText::_('MOD_INVENTOR_CONTACT_FORM_FRONT_VALIDATION_REQUIRED');
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
