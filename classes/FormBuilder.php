<?php

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
     * Create hidden input field.
     *
     * @param string $name
     * @param string $value
     * @return string
     */
    public function hidden($name, $value)
    {
        return $this->input('hidden', $name, $value);
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
     * Create button element.
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
