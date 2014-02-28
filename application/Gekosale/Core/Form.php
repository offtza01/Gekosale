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
namespace Gekosale\Core;

/**
 * Class Form
 *
 * @package Gekosale\Core
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
abstract class Form extends Component
{
    /**
     * Shortcut for adding Form
     *
     * @param array $options
     *
     * @return Form\Elements\Form
     */
    public function addForm(array $options)
    {
        return new Form\Elements\Form($options);
    }

    /**
     * Shortcut for adding Fieldset node
     *
     * @param array $options
     *
     * @return Form\Elements\Fieldset
     */
    public function addFieldset(array $options)
    {
        return new Form\Elements\Fieldset($options);
    }

    /**
     * Shortcut for adding FieldsetLanguage node
     *
     * @param array $options
     *
     * @return Form\Elements\FieldsetLanguage
     */
    public function addFieldsetLanguage(array $options)
    {
        return new Form\Elements\FieldsetLanguage($options);
    }

    /**
     * Shortcut for adding TextField element
     *
     * @param array $options
     *
     * @return Form\Elements\TextField
     */
    public function addTextField(array $options)
    {
        return new Form\Elements\TextField($options);
    }

    /**
     * Shortcut for adding Select element
     *
     * @param array $options
     *
     * @return Form\Elements\Select
     */
    public function addSelect(array $options)
    {
        return new Form\Elements\Select($options);
    }

    /**
     * Shortcut for adding Checkbox element
     *
     * @param array $options
     *
     * @return Form\Elements\Checkbox
     */
    public function addCheckBox(array $options)
    {
        return new Form\Elements\Checkbox($options);
    }

    /**
     * Shortcut for adding StaticText element
     *
     * @param array $options
     *
     * @return Form\Elements\StaticText
     */
    public function addStaticText(array $options)
    {
        return new Form\Elements\StaticText($options);
    }

    /**
     * Shortcut for adding filter CommaToDotChanger
     *
     * @return Form\Filters\CommaToDotChanger
     */
    public function addFilterCommaToDotChanger()
    {
        return new Form\Filters\CommaToDotChanger();
    }

    /**
     * Shortcut for adding filter NoCode
     *
     * @return Form\Filters\NoCode
     */
    public function addFilterNoCode()
    {
        return new Form\Filters\NoCode();
    }

    /**
     * Shortcut for adding filter Trim
     *
     * @return Form\Filters\Trim
     */
    public function addFilterTrim()
    {
        return new Form\Filters\Trim();
    }

    /**
     * Shortcut for adding filter Secure
     *
     * @return Form\Filters\Secure
     */
    public function addFilterSecure()
    {
        return new Form\Filters\Secure();
    }

    /**
     * Shortcut for adding rule Format
     *
     * @param $errorMessage
     * @param $pattern
     *
     * @return Form\Rules\Format
     */
    public function addRuleFormat($errorMessage, $pattern)
    {
        return new Form\Rules\Format($errorMessage, $pattern);
    }

    /**
     * Shortcut for adding rule Required
     *
     * @param $errorMessage
     *
     * @return Form\Rules\Required
     */
    public function addRuleRequired($errorMessage)
    {
        return new Form\Rules\Required($errorMessage);
    }

    /**
     * Shortcut for adding rule Unique
     *
     * @param       $errorMessage
     * @param array $options
     *
     * @return Form\Rules\Unique
     */
    public function addRuleUnique($errorMessage, array $options)
    {
        return new Form\Rules\Unique($errorMessage, $options, $this->container);
    }

    /**
     * Shortcut for adding rule LanguageUnique
     *
     * @param       $errorMessage
     * @param array $options
     *
     * @return Form\Rules\LanguageUnique
     */
    public function addRuleLanguageUnique($errorMessage, array $options)
    {
        return new Form\Rules\LanguageUnique($errorMessage, $options, $this->container);
    }

    /**
     * Processes options for using them in Select
     *
     * @param $options
     *
     * @return array
     */
    public function makeOptions($options)
    {
        return Form\Option::Make($options);
    }

    /**
     * Shortcut for adding Tree element
     *
     * @param array $options
     *
     * @return Form\Elements\Tree
     */
    public function addTree(array $options)
    {
        return new Form\Elements\Tree($options, $this->container);
    }
}