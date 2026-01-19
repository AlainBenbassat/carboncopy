<?php

class CRM_Carboncopy_Contact {
  public static function getCcToInclude(int $contactId, ?string $existingValue): string {
    return self::getEmailsToInclude($contactId, CRM_Carboncopy_LocationType::getIdCC(), $existingValue);
  }

  public static function getBccToInclude(int $contactId, ?string $existingValue): string {
    return self::getEmailsToInclude($contactId, CRM_Carboncopy_LocationType::getIdBCC(), $existingValue);
  }

  private static function getEmailsToInclude(int $contactId, int $locationTypeId, ?string $existingValue): string {
    $emailsAsString = $existingValue . '';

    $emails = \Civi\Api4\Email::get(FALSE)
      ->addSelect('email')
      ->addWhere('contact_id', '=', $contactId)
      ->addWhere('location_type_id', '=', $locationTypeId)
      ->addWhere('on_hold', '=', 0)
      ->execute();
    foreach ($emails as $email) {
      if ($emailsAsString) {
        $emailsAsString .= ',';
      }

      $emailsAsString .= $email['email'];
    }

    return $emailsAsString;
  }
}
