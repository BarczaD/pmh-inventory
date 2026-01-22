<?php
namespace app\models;

class LogEvent
{
    // --- 100: Munkaállomás ---
    const WORKSTATION_CREATE = 111;
    const WORKSTATION_UPDATE = 112;
    const WORKSTATION_DELETE = 113;

    // --- 200: CPU ---
    const CPU_CREATE = 211;
    const CPU_UPDATE = 212;
    const CPU_DELETE = 213;

    // --- 300: Brand ---
    const BRAND_CREATE = 311;
    const BRAND_UPDATE = 312;
    const BRAND_DELETE = 313;

    // --- 400: Kolléga ---
    const COLLEAGUE_CREATE = 411;
    const COLLEAGUE_UPDATE = 412;
    const COLLEAGUE_DELETE = 413;

    // --- 500: Karbantartás ---
    const MAINTENANCE_CREATE = 511;
    const MAINTENANCE_UPDATE = 512;
    const MAINTENANCE_DELETE = 513;

    // --- 600: Monitor ---
    const MONITOR_CREATE = 611;
    const MONITOR_UPDATE = 612;
    const MONITOR_DELETE = 613;

    // --- 700: Iroda  ---
    const OFFICE_CREATE = 711;
    const OFFICE_UPDATE = 712;
    const OFFICE_DELETE = 713;

    // --- 800: User ---
    const USER_CREATE = 811;
    const USER_PASSWORD_CHANGE = 812;
    const USER_DELETE = 813;

    /**
     * Map IDs to human-readable Hungarian labels.
     */
    public static function getList(): array
    {
        return [
            self::WORKSTATION_CREATE => 'Munkaállomás létrehozva',
            self::WORKSTATION_UPDATE => 'Munkaállomás módosítva',
            self::WORKSTATION_DELETE => 'Munkaállomás törölve',

            self::CPU_CREATE => 'CPU hozzáadva',
            self::CPU_UPDATE => 'CPU módosítva',
            self::CPU_DELETE => 'CPU törölve',

            self::BRAND_CREATE => 'Brand felvéve',
            self::BRAND_UPDATE => 'Brand módosítva',
            self::BRAND_DELETE => 'Brand törölve',

            self::COLLEAGUE_CREATE => 'Kolléga regisztrálva',
            self::COLLEAGUE_UPDATE => 'Kolléga adatai módosítva',
            self::COLLEAGUE_DELETE => 'Kolléga törölve',

            self::MAINTENANCE_CREATE => 'Karbantartás rögzítve',
            self::MAINTENANCE_UPDATE => 'Karbantartás módosítva',
            self::MAINTENANCE_DELETE => 'Karbantartás törölve',

            self::MONITOR_CREATE => 'Monitor hozzáadva',
            self::MONITOR_UPDATE => 'Monitor módosítva',
            self::MONITOR_DELETE => 'Monitor törölve',

            self::OFFICE_CREATE => 'Iroda rögzítve',
            self::OFFICE_UPDATE => 'Iroda módosítva',
            self::OFFICE_DELETE => 'Iroda törölve',

            self::USER_CREATE => 'User regisztrálva',
            self::USER_PASSWORD_CHANGE => 'User jelszót módosított',
            self::USER_DELETE => 'User törölve',
        ];
    }

    /**
     * Get only the entity name based on the ID range.
     * Use this to color-code your table or add icons.
     */
    public static function getCategoryName(int $id): string
    {
        $range = (int)($id / 100);
        $map = [
            1 => 'Munkaállomás',
            2 => 'CPU',
            3 => 'Brand',
            4 => 'Kolléga',
            5 => 'Karbantartás',
            6 => 'Monitor',
            7 => 'Iroda',
        ];
        return $map[$range] ?? 'Egyéb';
    }

    public static function getLabel(int $id): string
    {
        return self::getList()[$id] ?? "Ismeretlen ($id)";
    }
}