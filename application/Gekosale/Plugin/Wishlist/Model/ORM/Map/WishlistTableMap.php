<?php

namespace Gekosale\Plugin\Wishlist\Model\ORM\Map;

use Gekosale\Plugin\Wishlist\Model\ORM\Wishlist;
use Gekosale\Plugin\Wishlist\Model\ORM\WishlistQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'wishlist' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WishlistTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Gekosale.Plugin.Wishlist.Model.ORM.Map.WishlistTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'wishlist';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Gekosale\\Plugin\\Wishlist\\Model\\ORM\\Wishlist';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Gekosale.Plugin.Wishlist.Model.ORM.Wishlist';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'wishlist.ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const COL_PRODUCT_ID = 'wishlist.PRODUCT_ID';

    /**
     * the column name for the PRODUCT_ATTRIBUTE_ID field
     */
    const COL_PRODUCT_ATTRIBUTE_ID = 'wishlist.PRODUCT_ATTRIBUTE_ID';

    /**
     * the column name for the CLIENT_ID field
     */
    const COL_CLIENT_ID = 'wishlist.CLIENT_ID';

    /**
     * the column name for the WISH_PRICE field
     */
    const COL_WISH_PRICE = 'wishlist.WISH_PRICE';

    /**
     * the column name for the SHOP_ID field
     */
    const COL_SHOP_ID = 'wishlist.SHOP_ID';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ProductId', 'ProductAttributeId', 'ClientId', 'WishPrice', 'ShopId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'productId', 'productAttributeId', 'clientId', 'wishPrice', 'shopId', ),
        self::TYPE_COLNAME       => array(WishlistTableMap::COL_ID, WishlistTableMap::COL_PRODUCT_ID, WishlistTableMap::COL_PRODUCT_ATTRIBUTE_ID, WishlistTableMap::COL_CLIENT_ID, WishlistTableMap::COL_WISH_PRICE, WishlistTableMap::COL_SHOP_ID, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_PRODUCT_ID', 'COL_PRODUCT_ATTRIBUTE_ID', 'COL_CLIENT_ID', 'COL_WISH_PRICE', 'COL_SHOP_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'product_id', 'product_attribute_id', 'client_id', 'wish_price', 'shop_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ProductId' => 1, 'ProductAttributeId' => 2, 'ClientId' => 3, 'WishPrice' => 4, 'ShopId' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'productId' => 1, 'productAttributeId' => 2, 'clientId' => 3, 'wishPrice' => 4, 'shopId' => 5, ),
        self::TYPE_COLNAME       => array(WishlistTableMap::COL_ID => 0, WishlistTableMap::COL_PRODUCT_ID => 1, WishlistTableMap::COL_PRODUCT_ATTRIBUTE_ID => 2, WishlistTableMap::COL_CLIENT_ID => 3, WishlistTableMap::COL_WISH_PRICE => 4, WishlistTableMap::COL_SHOP_ID => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_PRODUCT_ID' => 1, 'COL_PRODUCT_ATTRIBUTE_ID' => 2, 'COL_CLIENT_ID' => 3, 'COL_WISH_PRICE' => 4, 'COL_SHOP_ID' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'product_id' => 1, 'product_attribute_id' => 2, 'client_id' => 3, 'wish_price' => 4, 'shop_id' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('wishlist');
        $this->setPhpName('Wishlist');
        $this->setClassName('\\Gekosale\\Plugin\\Wishlist\\Model\\ORM\\Wishlist');
        $this->setPackage('Gekosale.Plugin.Wishlist.Model.ORM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addForeignKey('PRODUCT_ID', 'ProductId', 'INTEGER', 'product', 'ID', true, 10, null);
        $this->addColumn('PRODUCT_ATTRIBUTE_ID', 'ProductAttributeId', 'INTEGER', false, null, 0);
        $this->addForeignKey('CLIENT_ID', 'ClientId', 'INTEGER', 'client', 'ID', true, 10, null);
        $this->addColumn('WISH_PRICE', 'WishPrice', 'DECIMAL', false, 16, 0);
        $this->addForeignKey('SHOP_ID', 'ShopId', 'INTEGER', 'shop', 'ID', false, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Client', '\\Gekosale\\Plugin\\Client\\Model\\ORM\\Client', RelationMap::MANY_TO_ONE, array('client_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Product', '\\Gekosale\\Plugin\\Product\\Model\\ORM\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Shop', '\\Gekosale\\Plugin\\Shop\\Model\\ORM\\Shop', RelationMap::MANY_TO_ONE, array('shop_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? WishlistTableMap::CLASS_DEFAULT : WishlistTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Wishlist object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WishlistTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WishlistTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WishlistTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WishlistTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WishlistTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = WishlistTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WishlistTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WishlistTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(WishlistTableMap::COL_ID);
            $criteria->addSelectColumn(WishlistTableMap::COL_PRODUCT_ID);
            $criteria->addSelectColumn(WishlistTableMap::COL_PRODUCT_ATTRIBUTE_ID);
            $criteria->addSelectColumn(WishlistTableMap::COL_CLIENT_ID);
            $criteria->addSelectColumn(WishlistTableMap::COL_WISH_PRICE);
            $criteria->addSelectColumn(WishlistTableMap::COL_SHOP_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ATTRIBUTE_ID');
            $criteria->addSelectColumn($alias . '.CLIENT_ID');
            $criteria->addSelectColumn($alias . '.WISH_PRICE');
            $criteria->addSelectColumn($alias . '.SHOP_ID');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(WishlistTableMap::DATABASE_NAME)->getTable(WishlistTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(WishlistTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(WishlistTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new WishlistTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Wishlist or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Wishlist object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WishlistTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Gekosale\Plugin\Wishlist\Model\ORM\Wishlist) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WishlistTableMap::DATABASE_NAME);
            $criteria->add(WishlistTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = WishlistQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { WishlistTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { WishlistTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the wishlist table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WishlistQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Wishlist or Criteria object.
     *
     * @param mixed               $criteria Criteria or Wishlist object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WishlistTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Wishlist object
        }

        if ($criteria->containsKey(WishlistTableMap::COL_ID) && $criteria->keyContainsValue(WishlistTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WishlistTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = WishlistQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // WishlistTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WishlistTableMap::buildTableMap();
