<?php

use CRM_Carboncopy_ExtensionUtil as E;

class CRM_Carboncopy_LocationType {
  private static $cache = [];

  public static function init() {
    self::getIdCC();
    self::getIdBCC();
  }

  public static function getIdCC(): int {
    return self::getOrCreateId('cc_to', E::ts('CC To'));
  }

  public static function getIdBCC(): int {
    return self::getOrCreateId('bcc_to', E::ts('BCC To'));
  }

  private static function getOrCreateId(string $name, string $displayName): int {
    if (isset(self::$cache[$name])) {
      return self::$cache[$name];
    }

    $locationType = \Civi\Api4\LocationType::get(FALSE)
      ->addSelect('id')
      ->addWhere('name', '=', $name)
      ->execute()
      ->first();

    if ($locationType) {
      self::$cache[$name] = $locationType['id'];
      return self::$cache[$name];
    }

    $result = \Civi\Api4\LocationType::create(FALSE)
      ->addValue('name', $name)
      ->addValue('display_name', $displayName)
      ->addValue('is_active', TRUE)
      ->execute()
      ->first();

    self::$cache[$name] = $result['id'];
    return self::$cache[$name];
  }

}
