<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/classes/ContactFormValidator.php';
require_once __DIR__ . '/classes/FormBuilder.php';
require_once __DIR__ . '/classes/Mailer.php';

$moduleId = md5($module->id);

$labels = array(
    'name' => $params->get('name'),
    'email' => $params->get('email'),
    'phone' => $params->get('phone'),
    'message' => $params->get('message'),
    'submit' => $params->get('submit')
);

// Map form data into variables.
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Handle POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['moduleId'] === $moduleId) {

    $validator = new ContactFormValidator($_POST, $labels);

    if ($validator->passes()) {
        $mailer = new Mailer($params->toArray(), $_POST);
        $mailer->send();
        $name = $email = $phone = $message = '';
    }
}

$isPhoneFieldActive = $params->get('is_phone_field_active');
$labelsPlacement = $params->get('labels_placement');
$additionalModuleClass = htmlspecialchars($params->get('moduleclass_sfx'));
$action = $app->input->server->get('REQUEST_URI', '', 'string');

require JModuleHelper::getLayoutPath('mod_inventor_contact_form', $params->get('layout', 'default'));
