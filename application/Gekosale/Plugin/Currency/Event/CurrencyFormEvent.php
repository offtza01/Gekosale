<?php
/*
 * Gekosale Open-Source E-Commerce Platform
 *
 * This file is part of the Gekosale package.
 *
 * (c) Adam Piotrowski <adam@gekosale.com>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Gekosale\Plugin\Currency\Event;

use Gekosale\Core\Event\FormEvent;

/**
 * Class CurrencyFormEvent
 *
 * @package Gekosale\Plugin\Currency\Event
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
final class CurrencyFormEvent extends FormEvent
{

    const FORM_INIT_EVENT = 'currency.form.init';
}