<?php

/**
 * Gekosale, Open Source E-Commerce Solution
 * http://www.gekosale.pl
 *
 * Copyright (c) 2009-2011 Gekosale
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms
 * of the GNU General Public License Version 3, 29 June 2007 as published by the
 * Free Software
 * Foundation (http://opensource.org/licenses/gpl-3.0.html).
 * If you did not receive a copy of the license and are unable to obtain it
 * through the
 * world-wide-web, please send an email to license@verison.pl so we can send you
 * a copy immediately.
 */
namespace FormEngine\Elements;

use Gekosale\App as App;
use FormEngine\FE as FE;

class TechnicalAttributeEditor extends Field
{

	public function __construct ($attributes)
	{
		$attributes['attributes'] = App::getModel('technicaldata')->getTechnicalDataFull();
		parent::__construct($attributes);
		
		App::getRegistry()->xajaxInterface->registerFunction(array(
			'DeleteAttribute',
			$this,
			'deleteAttribute'
		));
		
		App::getRegistry()->xajaxInterface->registerFunction(array(
			'RenameAttribute',
			$this,
			'renameAttribute'
		));
		
		App::getRegistry()->xajaxInterface->registerFunction(array(
			'RenameValue',
			$this,
			'renameValue'
		));
		
		$this->_attributes['deleteAttributeFunction'] = 'xajax_DeleteAttribute';
		$this->_attributes['renameAttributeFunction'] = 'xajax_RenameAttribute';
		$this->_attributes['renameValueFunction'] = 'xajax_RenameValue';
	}

	public function renameAttribute ($request)
	{
		App::getModel('technicaldata')->RenameAttribute($request['id'], $request['name'], $request['languageid']);
		return $request;
	}

	public function renameValue ($request)
	{
		App::getModel('technicaldata')->RenameValue($request['id'], $request['name'], $request['languageid']);
		return $request;
	}

	public function deleteAttribute ($request)
	{
		App::getModel('technicaldata')->DeleteDataGroup($request['id'], $request['set_id']);
		
		return Array(
			'status' => true
		);
	}

	protected function _PrepareAttributes_JS ()
	{
		$attributes = Array(
			$this->_FormatAttribute_JS('name', 'sName'),
			$this->_FormatAttribute_JS('label', 'sLabel'),
			$this->_FormatAttribute_JS('comment', 'sComment'),
			$this->_FormatAttribute_JS('error', 'sError'),
			$this->_FormatAttribute_JS('set', 'sSetId'),
			$this->_FormatAttribute_JS('attributes', 'aoAttributes', FE::TYPE_OBJECT),
			$this->_FormatAttribute_JS('onAfterDelete', 'fOnAfterDelete', FE::TYPE_FUNCTION),
			$this->_FormatAttribute_JS('deleteAttributeFunction', 'fDeleteAttribute', FE::TYPE_FUNCTION),
			$this->_FormatAttribute_JS('renameAttributeFunction', 'fRenameAttribute', FE::TYPE_FUNCTION),
			$this->_FormatAttribute_JS('renameValueFunction', 'fRenameValue', FE::TYPE_FUNCTION),
			$this->_FormatRepeatable_JS(),
			$this->_FormatRules_JS(),
			$this->_FormatDependency_JS(),
			$this->_FormatDefaults_JS()
		);
		return $attributes;
	}
}