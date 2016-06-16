<?php
/**
 * Mediaburst SMS Magento Integration
 *
 * Copyright © 2011 by Mediaburst Limited
 *
 * Permission to use, copy, modify, and/or distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND ISC DISCLAIMS ALL WARRANTIES WITH REGARD
 * TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND
 * FITNESS. IN NO EVENT SHALL ISC BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT,
 * OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF
 * USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER
 * TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE
 * OF THIS SOFTWARE.
 *
 * @category  Mage
 * @package   Mediaburst_Sms
 * @license   http://opensource.org/licenses/isc-license.txt
 * @copyright Copyright © 2011 by Mediaburst Limited
 * @author    Lee Saferite <lee.saferite@lokeycoding.com>
 */

/**
 * Failed Message Grid
 */
class Spletnisistemi_Smsnotify_Block_FailedGrid extends Spletnisistemi_Smsnotify_Block_AbstractMessageGrid {

    protected function _filterCollection(Varien_Data_Collection_Db $collection) {
        $collection->addFieldToFilter('status', Spletnisistemi_Smsnotify_Model_Smses::STATUS_FAILED)->setOrder('created_at', 'DESC');
        return $this;
    }

    protected function _prepareColumns() {
        $this->addColumnAfter(
            'error',
            array(
                'header' => $this->__('Error description'),
                'index'  => 'error_description',
                'filter' => false,
            ),
            'content'
        );

        $this->addColumnAfter(
            'error_code',
            array(
                'header' => $this->__('Error number'),
                'index'  => 'error_number',
                'filter' => false,
            ),
            'content'
        );

        if (Mage::getSingleton('admin/session')->isAllowed('sales/spletnisistemi_smsnotify/retry')) {
            $this->addColumnAfter(
                'action',
                array(
                    'header'    => $this->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'    => 'getId',
                    'filter'    => false,
                    'sortable'  => false,
                    'is_system' => true,
                    'actions'   => array(
                        array(
                            'caption' => $this->__('Retry'),
                            'url'     => array('base' => '*/*/retry'),
                            'field'   => 'id'
                        )
                    )
                ),
                'error'
            );
        }

        return parent::_prepareColumns();
    }
}