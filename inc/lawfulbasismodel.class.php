<?php
/*
 -------------------------------------------------------------------------
 DPO Register plugin for GLPI
 Copyright (C) 2018 by the DPO Register Development Team.

 https://github.com/karhel/glpi-dporegister
 -------------------------------------------------------------------------

 LICENSE

 This file is part of DPO Register.

 DPO Register is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 DPO Register is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with DPO Register. If not, see <http://www.gnu.org/licenses/>.

 --------------------------------------------------------------------------

  @package   dporegister
  @author    Karhel Tmarr
  @copyright Copyright (c) 2010-2013 Uninstall plugin team
  @license   GPLv3+
             http://www.gnu.org/licenses/gpl.txt
  @link      https://github.com/karhel/glpi-dporegister
  @since     2018
 --------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access this file directly");
}

class PluginDporegisterLawfulBasisModel extends CommonDropdown
{
    static $rightname = 'plugin_dporegister_lawfulbasismodel';
    public static $gdprValue = null;

    // --------------------------------------------------------------------
    //  PLUGIN MANAGEMENT - DATABASE INITIALISATION
    // --------------------------------------------------------------------

    /**
     * Install or update PluginDporegisterLawfulbasis
     *
     * @param Migration $migration Migration instance
     * @param string    $version   Plugin current version
     *
     * @return boolean
     */
    public static function install(Migration $migration, $version)
    {
        // All schema changes and data inserts must be handled by SQL migration files only.
        // No direct SQL, table creation, or data population here.
        return true;
    }

    /**
     * Uninstall PluginDporegisterLawfulbasis
     *
     * @return boolean
     */
    public static function uninstall()
    {
        // All schema changes and log purges must be handled by SQL migration files only.
        // No direct SQL or table drops here.
        return true;
    }

    // --------------------------------------------------------------------
    //  GLPI PLUGIN COMMON
    // --------------------------------------------------------------------

    //! @copydoc CommonDBTM::canUpdateItem()
    function canUpdateItem(): bool
    {

        // If it's from GDPR, prevent update
        if ($this->fields['is_gdpr']) return false;

        return parent::canUpdateItem();
    }

    //! @copydoc CommonDBTM::canDeleteItem()
    function canDeleteItem(): bool
    {

        // If it's from GDPR, prevent delete
        if ($this->fields['is_gdpr']) return false;

        return parent::canDeleteItem();
    }

    //! @copydoc CommonDBTM::canPurgeItem()
    function canPurgeItem(): bool
    {

        // If it's from GDPR, prevent purge
        if ($this->fields['is_gdpr']) return false;

        return parent::canPurgeItem();
    }

    //! @copydoc CommonGLPI::getTypeName($nb)
    public static function getTypeName($nb = 0)
    {
        return _n('LawfulBasis', 'LawfulBasises', $nb, 'dporegister');
    }

    //! @copydoc CommonDropdown::getAdditionalFields()
    public function getAdditionalFields()
    {
        return [
            [
                'name' => 'content',
                'label' => __('Content'),
                'type' => 'textarea',
                'rows' => 6
            ]
        ];
    }


    public static function rawSearchOptionsToAdd()
    {
        $tab = [];

        $tab[] = [
            'id' => 'lawfulbasis',
            'name' => self::getTypeName(0)
        ];

        $tab[] = [
            'id' => '7',
            'table' => self::getTable(),
            'field' => 'name',
            'name' => __('Name'),
            'searchtype' => ['equals', 'notequals'],
            'datatype' => 'dropdown',
            'massiveaction' => true
        ];

        return $tab;
    }

    // --------------------------------------------------------------------
    //  SPECIFICS FOR THE CURRENT OBJECT CLASS
    // --------------------------------------------------------------------

    protected static function insertGDPRValuesInDatabase($gdprValues)
    {
        foreach ($gdprValues as $values) {

            // Test if lawfulbasis already exists
            if (!countElementsInTable(
                self::getTable(),
                ['name' => $values[0]]
            )) {

                // Add the object in the database
                $object = new self();
                $object->add([
                    'name' => $values[0],
                    'content' => addslashes($values[1]),
                    'is_gdpr' => true,
                ]);
            }
        }
    }
}
