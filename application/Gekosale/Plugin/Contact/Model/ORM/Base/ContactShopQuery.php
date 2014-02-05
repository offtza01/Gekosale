<?php

namespace Gekosale\Plugin\Contact\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\Contact\Model\ORM\ContactShop as ChildContactShop;
use Gekosale\Plugin\Contact\Model\ORM\ContactShopQuery as ChildContactShopQuery;
use Gekosale\Plugin\Contact\Model\ORM\Map\ContactShopTableMap;
use Gekosale\Plugin\Shop\Model\ORM\Shop;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'contact_shop' table.
 *
 * 
 *
 * @method     ChildContactShopQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContactShopQuery orderByContactId($order = Criteria::ASC) Order by the contact_id column
 * @method     ChildContactShopQuery orderByShopId($order = Criteria::ASC) Order by the shop_id column
 *
 * @method     ChildContactShopQuery groupById() Group by the id column
 * @method     ChildContactShopQuery groupByContactId() Group by the contact_id column
 * @method     ChildContactShopQuery groupByShopId() Group by the shop_id column
 *
 * @method     ChildContactShopQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContactShopQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContactShopQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContactShopQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method     ChildContactShopQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method     ChildContactShopQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method     ChildContactShopQuery leftJoinShop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Shop relation
 * @method     ChildContactShopQuery rightJoinShop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Shop relation
 * @method     ChildContactShopQuery innerJoinShop($relationAlias = null) Adds a INNER JOIN clause to the query using the Shop relation
 *
 * @method     ChildContactShop findOne(ConnectionInterface $con = null) Return the first ChildContactShop matching the query
 * @method     ChildContactShop findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContactShop matching the query, or a new ChildContactShop object populated from the query conditions when no match is found
 *
 * @method     ChildContactShop findOneById(int $id) Return the first ChildContactShop filtered by the id column
 * @method     ChildContactShop findOneByContactId(int $contact_id) Return the first ChildContactShop filtered by the contact_id column
 * @method     ChildContactShop findOneByShopId(int $shop_id) Return the first ChildContactShop filtered by the shop_id column
 *
 * @method     array findById(int $id) Return ChildContactShop objects filtered by the id column
 * @method     array findByContactId(int $contact_id) Return ChildContactShop objects filtered by the contact_id column
 * @method     array findByShopId(int $shop_id) Return ChildContactShop objects filtered by the shop_id column
 *
 */
abstract class ContactShopQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Gekosale\Plugin\Contact\Model\ORM\Base\ContactShopQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gekosale\\Plugin\\Contact\\Model\\ORM\\ContactShop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContactShopQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContactShopQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Gekosale\Plugin\Contact\Model\ORM\ContactShopQuery) {
            return $criteria;
        }
        $query = new \Gekosale\Plugin\Contact\Model\ORM\ContactShopQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildContactShop|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ContactShopTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContactShopTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildContactShop A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CONTACT_ID, SHOP_ID FROM contact_shop WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildContactShop();
            $obj->hydrate($row);
            ContactShopTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildContactShop|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContactShopTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContactShopTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactShopTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the contact_id column
     *
     * Example usage:
     * <code>
     * $query->filterByContactId(1234); // WHERE contact_id = 1234
     * $query->filterByContactId(array(12, 34)); // WHERE contact_id IN (12, 34)
     * $query->filterByContactId(array('min' => 12)); // WHERE contact_id > 12
     * </code>
     *
     * @see       filterByContact()
     *
     * @param     mixed $contactId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByContactId($contactId = null, $comparison = null)
    {
        if (is_array($contactId)) {
            $useMinMax = false;
            if (isset($contactId['min'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_CONTACT_ID, $contactId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contactId['max'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_CONTACT_ID, $contactId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactShopTableMap::COL_CONTACT_ID, $contactId, $comparison);
    }

    /**
     * Filter the query on the shop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShopId(1234); // WHERE shop_id = 1234
     * $query->filterByShopId(array(12, 34)); // WHERE shop_id IN (12, 34)
     * $query->filterByShopId(array('min' => 12)); // WHERE shop_id > 12
     * </code>
     *
     * @see       filterByShop()
     *
     * @param     mixed $shopId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByShopId($shopId = null, $comparison = null)
    {
        if (is_array($shopId)) {
            $useMinMax = false;
            if (isset($shopId['min'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_SHOP_ID, $shopId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shopId['max'])) {
                $this->addUsingAlias(ContactShopTableMap::COL_SHOP_ID, $shopId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContactShopTableMap::COL_SHOP_ID, $shopId, $comparison);
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Contact\Model\ORM\Contact object
     *
     * @param \Gekosale\Plugin\Contact\Model\ORM\Contact|ObjectCollection $contact The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof \Gekosale\Plugin\Contact\Model\ORM\Contact) {
            return $this
                ->addUsingAlias(ContactShopTableMap::COL_CONTACT_ID, $contact->getId(), $comparison);
        } elseif ($contact instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContactShopTableMap::COL_CONTACT_ID, $contact->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type \Gekosale\Plugin\Contact\Model\ORM\Contact or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Contact\Model\ORM\ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\Gekosale\Plugin\Contact\Model\ORM\ContactQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Shop\Model\ORM\Shop object
     *
     * @param \Gekosale\Plugin\Shop\Model\ORM\Shop|ObjectCollection $shop The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function filterByShop($shop, $comparison = null)
    {
        if ($shop instanceof \Gekosale\Plugin\Shop\Model\ORM\Shop) {
            return $this
                ->addUsingAlias(ContactShopTableMap::COL_SHOP_ID, $shop->getId(), $comparison);
        } elseif ($shop instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContactShopTableMap::COL_SHOP_ID, $shop->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShop() only accepts arguments of type \Gekosale\Plugin\Shop\Model\ORM\Shop or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Shop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function joinShop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Shop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Shop');
        }

        return $this;
    }

    /**
     * Use the Shop relation Shop object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Shop\Model\ORM\ShopQuery A secondary query class using the current class as primary query
     */
    public function useShopQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Shop', '\Gekosale\Plugin\Shop\Model\ORM\ShopQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildContactShop $contactShop Object to remove from the list of results
     *
     * @return ChildContactShopQuery The current query, for fluid interface
     */
    public function prune($contactShop = null)
    {
        if ($contactShop) {
            $this->addUsingAlias(ContactShopTableMap::COL_ID, $contactShop->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the contact_shop table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContactShopTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContactShopTableMap::clearInstancePool();
            ContactShopTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildContactShop or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildContactShop object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContactShopTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContactShopTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ContactShopTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ContactShopTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ContactShopQuery
