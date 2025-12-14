CREATE TABLE IF NOT EXISTS `glpi_plugin_dporegister_processing_softwares` (
    `id` int(11) NOT NULL auto_increment,
    `plugin_dporegister_processings_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugins_dporegister_processings (id)',
    `softwares_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_softwares (id)',
    PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;