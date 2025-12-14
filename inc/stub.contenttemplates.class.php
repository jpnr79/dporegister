<?php
// Stub for GLPI 11+ content templates compatibility if not present
namespace Glpi\ContentTemplates\Parameters;
if (!class_exists('Glpi\\ContentTemplates\\Parameters\\CommonITILObjectParameters')) {
    class CommonITILObjectParameters {}
}