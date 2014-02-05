<?php

namespace Gekosale\Plugin\Crosssell\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\Crosssell\Model\ORM\Crosssell as ChildCrosssell;
use Gekosale\Plugin\Crosssell\Model\ORM\CrosssellQuery as ChildCrosssellQuery;
use Gekosale\Plugin\Crosssell\Model\ORM\Map\CrosssellTableMap;
use Gekosale\Plugin\Product\Model\ORM\Product;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'crosssell' table.
 *
 * 
 *
 * @method     ChildCrosssellQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCrosssellQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildCrosssellQuery orderByHierarchy($order = Criteria::ASC) Order by the hierarchy column
 * @method     ChildCrosssellQuery orderByRelatedProductId($order = Criteria::ASC) Order by the related_product_id column
 *
 * @method     ChildCrosssellQuery groupById() Group by the id column
 * @method     ChildCrosssellQuery groupByProductId() Group by the product_id column
 * @method     ChildCrosssellQuery groupByHierarchy() Group by the hierarchy column
 * @method     ChildCrosssellQuery groupByRelatedProductId() Group by the related_product_id column
 *
 * @method     ChildCrosssellQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCrosssellQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCrosssellQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCrosssellQuery leftJoinProductRelatedByProductId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductRelatedByProductId relation
 * @method     ChildCrosssellQuery rightJoinProductRelatedByProductId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductRelatedByProductId relation
 * @method     ChildCrosssellQuery innerJoinProductRelatedByProductId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductRelatedByProductId relation
 *
 * @method     ChildCrosssellQuery leftJoinProductRelatedByRelatedProductId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductRelatedByRelatedProductId relation
 * @method     ChildCrosssellQuery rightJoinProductRelatedByRelatedProductId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductRelatedByRelatedProductId relation
 * @method     ChildCrosssellQuery innerJoinProductRelatedByRelatedProductId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductRelatedByRelatedProductId relation
 *
 * @method     ChildCrosssell findOne(ConnectionInterface $con = null) Return the first ChildCrosssell matching the query
 * @method     ChildCrosssell findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCrosssell matching the query, or a new ChildCrosssell object populated from the query conditions when no match is found
 *
 * @method     ChildCrosssell findOneById(int $id) Return the first ChildCrosssell filtered by the id column
 * @method     ChildCrosssell findOneByProductId(int $product_id) Return the first ChildCrosssell filtered by the product_id column
 * @method     ChildCrosssell findOneByHierarchy(int $hierarchy) Return the first ChildCrosssell filtered by the hierarchy column
 * @method     ChildCrosssell findOneByRelatedProductId(int $related_product_id) Return the first ChildCrosssell filtered by the related_product_id column
 *
 * @method     array findById(int $id) Return ChildCrosssell objects filtered by the id column
 * @method     array findByProductId(int $product_id) Return ChildCrosssell objects filtered by the product_id column
 * @method     array findByHierarchy(int $hierarchy) Return ChildCrosssell objects filtered by the hierarchy column
 * @method     array findByRelatedProductId(int $related_product_id) Return ChildCrosssell objects filtered by the related_product_id column
 *
 */
abstract class CrosssellQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Gekosale\Plugin\Crosssell\Model\ORM\Base\CrosssellQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gekosale\\Plugin\\Crosssell\\Model\\ORM\\Crosssell', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCrosssellQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCrosssellQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Gekosale\Plugin\Crosssell\Model\ORM\CrosssellQuery) {
            return $criteria;
        }
        $query = new \Gekosale\Plugin\Crosssell\Model\ORM\CrosssellQuery();
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
     * @return ChildCrosssell|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrosssellTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CrosssellTableMap::DATABASE_NAME);
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
     * @return   ChildCrosssell A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PRODUCT_ID, HIERARCHY, RELATED_PRODUCT_ID FROM crosssell WHERE ID = :p0';
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
            $obj = new ChildCrosssell();
            $obj->hydrate($row);
            CrosssellTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCrosssell|array|mixed the result, formatted by the current formatter
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
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CrosssellTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CrosssellTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrosssellTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProductRelatedByProductId()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrosssellTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the hierarchy column
     *
     * Example usage:
     * <code>
     * $query->filterByHierarchy(1234); // WHERE hierarchy = 1234
     * $query->filterByHierarchy(array(12, 34)); // WHERE hierarchy IN (12, 34)
     * $query->filterByHierarchy(array('min' => 12)); // WHERE hierarchy > 12
     * </code>
     *
     * @param     mixed $hierarchy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByHierarchy($hierarchy = null, $comparison = null)
    {
        if (is_array($hierarchy)) {
            $useMinMax = false;
            if (isset($hierarchy['min'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_HIERARCHY, $hierarchy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hierarchy['max'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_HIERARCHY, $hierarchy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrosssellTableMap::COL_HIERARCHY, $hierarchy, $comparison);
    }

    /**
     * Filter the query on the related_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRelatedProductId(1234); // WHERE related_product_id = 1234
     * $query->filterByRelatedProductId(array(12, 34)); // WHERE related_product_id IN (12, 34)
     * $query->filterByRelatedProductId(array('min' => 12)); // WHERE related_product_id > 12
     * </code>
     *
     * @see       filterByProductRelatedByRelatedProductId()
     *
     * @param     mixed $relatedProductId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByRelatedProductId($relatedProductId = null, $comparison = null)
    {
        if (is_array($relatedProductId)) {
            $useMinMax = false;
            if (isset($relatedProductId['min'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_RELATED_PRODUCT_ID, $relatedProductId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($relatedProductId['max'])) {
                $this->addUsingAlias(CrosssellTableMap::COL_RELATED_PRODUCT_ID, $relatedProductId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrosssellTableMap::COL_RELATED_PRODUCT_ID, $relatedProductId, $comparison);
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Product\Model\ORM\Product object
     *
     * @param \Gekosale\Plugin\Product\Model\ORM\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByProductRelatedByProductId($product, $comparison = null)
    {
        if ($product instanceof \Gekosale\Plugin\Product\Model\ORM\Product) {
            return $this
                ->addUsingAlias(CrosssellTableMap::COL_PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrosssellTableMap::COL_PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductRelatedByProductId() only accepts arguments of type \Gekosale\Plugin\Product\Model\ORM\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductRelatedByProductId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function joinProductRelatedByProductId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductRelatedByProductId');

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
            $this->addJoinObject($join, 'ProductRelatedByProductId');
        }

        return $this;
    }

    /**
     * Use the ProductRelatedByProductId relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Product\Model\ORM\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductRelatedByProductIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductRelatedByProductId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductRelatedByProductId', '\Gekosale\Plugin\Product\Model\ORM\ProductQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Product\Model\ORM\Product object
     *
     * @param \Gekosale\Plugin\Product\Model\ORM\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function filterByProductRelatedByRelatedProductId($product, $comparison = null)
    {
        if ($product instanceof \Gekosale\Plugin\Product\Model\ORM\Product) {
            return $this
                ->addUsingAlias(CrosssellTableMap::COL_RELATED_PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CrosssellTableMap::COL_RELATED_PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductRelatedByRelatedProductId() only accepts arguments of type \Gekosale\Plugin\Product\Model\ORM\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductRelatedByRelatedProductId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function joinProductRelatedByRelatedProductId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductRelatedByRelatedProductId');

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
            $this->addJoinObject($join, 'ProductRelatedByRelatedProductId');
        }

        return $this;
    }

    /**
     * Use the ProductRelatedByRelatedProductId relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Product\Model\ORM\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductRelatedByRelatedProductIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductRelatedByRelatedProductId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductRelatedByRelatedProductId', '\Gekosale\Plugin\Product\Model\ORM\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCrosssell $crosssell Object to remove from the list of results
     *
     * @return ChildCrosssellQuery The current query, for fluid interface
     */
    public function prune($crosssell = null)
    {
        if ($crosssell) {
            $this->addUsingAlias(CrosssellTableMap::COL_ID, $crosssell->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the crosssell table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CrosssellTableMap::DATABASE_NAME);
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
            CrosssellTableMap::clearInstancePool();
            CrosssellTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCrosssell or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCrosssell object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CrosssellTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CrosssellTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        CrosssellTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CrosssellTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CrosssellQuery
