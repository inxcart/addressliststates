<?php
/**
 * Copyright (C) 2017 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2017 thirty bees
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_TB_VERSION_')) {
    exit;
}

/**
 * Class AddressListStates
 */
class AddressListStates extends Module
{
    /**
     * AddressListStates constructor.
     */
    public function __construct()
    {
        $this->name = 'addressliststates';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'thirty bees';

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('States on address list ');
        $this->description = $this->l('Show states on the address list of the admin panel');
    }

    /**
     * Install the module
     *
     * @return bool
     */
    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        $this->registerHook('actionAdminAddressesListingFieldsModifier');

        return true;
    }

    /**
     * Edit address grid display
     *
     * @param array $params
     */
    public function hookActionAdminAddressesListingFieldsModifier($params)
    {
        if (!isset($params['join'])) {
            $params['join'] = '';
        }
        $params['join'] .= "\n\t\tLEFT JOIN `"._DB_PREFIX_.bqSQL(State::$definition['table'])."` st ON (st.`id_state` = a.`id_state`)";
        $params['fields']['st!name'] = [
            'title'           => $this->l('State'),
            'align'           => 'center',
            'class'           => 'fixed-width-xs',
            'filter_key'      => 'st!name',
            'type'            => 'text',
        ];
    }
}
