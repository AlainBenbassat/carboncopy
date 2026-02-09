<?php

require_once 'carboncopy.civix.php';

use CRM_Carboncopy_ExtensionUtil as E;

function carboncopy_civicrm_config(&$config): void {
  _carboncopy_civix_civicrm_config($config);
}

function carboncopy_civicrm_install(): void {
  _carboncopy_civix_civicrm_install();
}

function carboncopy_civicrm_enable(): void {
  CRM_Carboncopy_LocationType::init();
  _carboncopy_civix_civicrm_enable();
}

function carboncopy_civicrm_alterMailParams(&$params, $context): void {
  if ($params['contactId']) {
    $contactId = $params['contactId'];
  }
  else {
    $contactId = CRM_Carboncopy_Contact::getContactIdFromEmail($params['job_id'], $params['toEmail']);
  }

  if ($contactId) {
    $params['cc'] = CRM_Carboncopy_Contact::getCcToInclude($params['contactId'], $params['cc'] ?? '');
    $params['bcc'] = CRM_Carboncopy_Contact::getBccToInclude($params['contactId'], $params['bcc'] ?? '');
  }
}
