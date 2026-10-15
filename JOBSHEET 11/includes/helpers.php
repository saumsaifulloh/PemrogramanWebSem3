<?php
/**
 * Escape output for safe HTML rendering (XSS protection).
 */
function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
