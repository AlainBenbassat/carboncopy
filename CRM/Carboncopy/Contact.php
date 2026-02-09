<?php

class CRM_Carboncopy_Contact {
  public static function getContactIdFromEmail(?int $jobId, ?string $email): int {
    if (empty($jobId) || empty($email)) {
      return 0;
    }

    $sql = "
      select
        mr.contact_id
      from
        civicrm_mailing_recipients mr
      inner join
        civicrm_mailing_job mj on mr.mailing_id = mj.mailing_id  and mj.id = %1
      inner join
        civicrm_email e on e.id = mr.email_id and e.email = %2
    ";
    $sqlParams = [
      1 => [$jobId, 'Integer'],
      2 => [$email, 'String'],
    ];

    return CRM_Core_DAO::singleValueQuery($sql, $sqlParams);
  }

  public static function getCcToInclude(int $contactId, ?string $existingValue): string {
    return self::getEmailsToInclude($contactId, CRM_Carboncopy_LocationType::getIdCC(), $existingValue);
  }

  public static function getBccToInclude(int $contactId, ?string $existingValue): string {
    return self::getEmailsToInclude($contactId, CRM_Carboncopy_LocationType::getIdBCC(), $existingValue);
  }

  private static function getEmailsToInclude(int $contactId, int $locationTypeId, ?string $existingValue): string {
    $emailsAsString = $existingValue ?? '';

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
