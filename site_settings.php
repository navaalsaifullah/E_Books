<?php
/**
 * Global site branding — logo, name, page titles
 */
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'E - Books');
    define('SITE_FOOTER_NAME', 'E - Books Store');
}

/**
 * Logo path relative to E_Books root
 */
function site_logo_path(bool $fromUsers = true): string
{
    return $fromUsers ? '../Images/logo.png' : './Images/logo.png';
}

/**
 * Dynamic browser tab title
 */
function page_title(string $page = ''): string
{
    if ($page === '' || $page === 'Home') {
        return SITE_NAME;
    }
    return $page . ' | ' . SITE_NAME;
}
