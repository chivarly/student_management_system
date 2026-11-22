<?php

/**
 * Map a department code from the database to a whitelisted CSS class.
 * Course-to-department relationships always come from the database.
 */
function departmentClass(?string $code): string
{
    $classes = [
        "EDUC" => "educ",
        "CSD" => "csd",
        "ENG" => "eng",
        "TECH" => "tech",
        "NURS" => "nurs",
        "ENTREP" => "entrep"
    ];

    return $classes[strtoupper(trim((string) $code))] ?? "default";
}
