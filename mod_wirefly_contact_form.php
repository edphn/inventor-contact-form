<?php

defined('_JEXEC') or die;

// Require helper file.
require_once __DIR__ . '/helper.php';

// Handle POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $validator = new ContactFormValidator($_POST);

    if ($validator->passes()) {
        $mailer = new Mailer($params->toArray(), $_POST);
        $mailer->send();
    } else {
        // Handle invalid data.
    }

}

// Map variables used within template.
$name = $params->get('name');
$email = $params->get('email');
$phone = $params->get('phone');
$message = $params->get('message');
$action = $app->input->server->get('REQUEST_URI', '', 'string');

require JModuleHelper::getLayoutPath('mod_wirefly_contact_form', $params->get('layout', 'default'));
