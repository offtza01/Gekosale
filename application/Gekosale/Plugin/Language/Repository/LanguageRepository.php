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
namespace Gekosale\Plugin\Language\Repository;

use Gekosale\Core\Model\Language,
    Gekosale\Core\Repository;

use Symfony\Component\Intl\Intl;

/**
 * Class LanguageRepository
 *
 * @package Gekosale\Plugin\Language\Repository
 * @author  Adam Piotrowski <adam@gekosale.com>
 */
class LanguageRepository extends Repository
{

    /**
     * Returns all currencies
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Language::all();
    }

    /**
     * Returns a language record
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return Language::with('currency')->findOrFail($id);
    }

    /**
     * Deletes language model by ID
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return Language::destroy($id);
        });
    }

    /**
     * Saves language data
     *
     * @param      $Data
     * @param null $id
     */
    public function save($Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {
            $language = Language::firstOrCreate([
                'id' => $id
            ]);

            $language->name        = $Data['name'];
            $language->locale      = $Data['locale'];
            $language->translation = $Data['translation'];
            $language->currency_id = $Data['currency_id'];
            $language->save();
        });
    }

    /**
     * Returns data required for populating a form
     *
     * @param $id
     *
     * @return array
     */
    public function getPopulateData($id)
    {
        $languageData = $this->find($id);
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();

        $accessor->setValue($populateData, '[required_data]', [
            'name'        => $languageData->name,
            'translation' => $languageData->translation,
            'locale'      => $languageData->locale,
        ]);

        $accessor->setValue($populateData, '[currency_data]', [
            'currency_id' => $languageData->currency_id
        ]);

        return $populateData;
    }

    /**
     * Gets all currencies and returns them as key-value pairs
     *
     * @return array
     */
    public function getAllLocaleToSelect()
    {
        $locales = Intl::getLocaleBundle()->getLocaleNames();

        $Data = [];

        foreach ($locales as $locale => $name) {
            $Data[$locale] = sprintf('%s (%s)', $name, $locale);
        }

        return $Data;
    }
}