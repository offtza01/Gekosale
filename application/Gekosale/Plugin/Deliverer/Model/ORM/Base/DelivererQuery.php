<?php

namespace Gekosale\Plugin\Deliverer\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\Deliverer\Model\ORM\Deliverer as ChildDeliverer;
use Gekosale\Plugin\Deliverer\Model\ORM\DelivererQuery as ChildDelivererQuery;
use Gekosale\Plugin\Deliverer\Model\ORM\Map\DelivererTableMap;
use Gekosale\Plugin\File\Model\ORM\File;
use Gekosale\Plugin\Producer\Model\ORM\ProducerDeliverer;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'deliverer' table.
 *
 * 
 *
 * @method     ChildDelivererQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDelivererQuery orderByPhotoId($order = Criteria::ASC) Order by the photo_id column
 *
 * @method     ChildDelivererQuery groupById() Group by the id column
 * @method     ChildDelivererQuery groupByPhotoId() Group by the photo_id column
 *
 * @method     ChildDelivererQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDelivererQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDelivererQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDelivererQuery leftJoinFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the File relation
 * @method     ChildDelivererQuery rightJoinFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the File relation
 * @method     ChildDelivererQuery innerJoinFile($relationAlias = null) Adds a INNER JOIN clause to the query using the File relation
 *
 * @method     ChildDelivererQuery leftJoinProducerDeliverer($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProducerDeliverer relation
 * @method     ChildDelivererQuery rightJoinProducerDeliverer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProducerDeliverer relation
 * @method     ChildDelivererQuery innerJoinProducerDeliverer($relationAlias = null) Adds a INNER JOIN clause to the query using the ProducerDeliverer relation
 *
 * @method     ChildDelivererQuery leftJoinDelivererProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the DelivererProduct relation
 * @method     ChildDelivererQuery rightJoinDelivererProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DelivererProduct relation
 * @method     ChildDelivererQuery innerJoinDelivererProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the DelivererProduct relation
 *
 * @method     ChildDeliverer findOne(ConnectionInterface $con = null) Return the first ChildDeliverer matching the query
 * @method     ChildDeliverer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDeliverer matching the query, or a new ChildDeliverer object populated from the query conditions when no match is found
 *
 * @method     ChildDeliverer findOneById(int $id) Return the first ChildDeliverer filtered by the id column
 * @method     ChildDeliverer findOneByPhotoId(int $photo_id) Return the first ChildDeliverer filtered by the photo_id column
 *
 * @method     array findById(int $id) Return ChildDeliverer objects filtered by the id column
 * @method     array findByPhotoId(int $photo_id) Return ChildDeliverer objects filtered by the photo_id column
 *
 */
abstract class DelivererQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \Gekosale\Plugin\Deliverer\Model\ORM\Base\DelivererQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gekosale\\Plugin\\Deliverer\\Model\\ORM\\Deliverer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDelivererQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDelivererQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Gekosale\Plugin\Deliverer\Model\ORM\DelivererQuery) {
            return $criteria;
        }
        $query = new \Gekosale\Plugin\Deliverer\Model\ORM\DelivererQuery();
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
     * @return ChildDeliverer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DelivererTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DelivererTableMap::DATABASE_NAME);
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
     * @return   ChildDeliverer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, PHOTO_ID FROM deliverer WHERE ID = :p0';
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
            $obj = new ChildDeliverer();
            $obj->hydrate($row);
            DelivererTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDeliverer|array|mixed the result, formatted by the current formatter
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
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DelivererTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DelivererTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DelivererTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DelivererTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DelivererTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the photo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPhotoId(1234); // WHERE photo_id = 1234
     * $query->filterByPhotoId(array(12, 34)); // WHERE photo_id IN (12, 34)
     * $query->filterByPhotoId(array('min' => 12)); // WHERE photo_id > 12
     * </code>
     *
     * @see       filterByFile()
     *
     * @param     mixed $photoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByPhotoId($photoId = null, $comparison = null)
    {
        if (is_array($photoId)) {
            $useMinMax = false;
            if (isset($photoId['min'])) {
                $this->addUsingAlias(DelivererTableMap::COL_PHOTO_ID, $photoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($photoId['max'])) {
                $this->addUsingAlias(DelivererTableMap::COL_PHOTO_ID, $photoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DelivererTableMap::COL_PHOTO_ID, $photoId, $comparison);
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\File\Model\ORM\File object
     *
     * @param \Gekosale\Plugin\File\Model\ORM\File|ObjectCollection $file The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByFile($file, $comparison = null)
    {
        if ($file instanceof \Gekosale\Plugin\File\Model\ORM\File) {
            return $this
                ->addUsingAlias(DelivererTableMap::COL_PHOTO_ID, $file->getId(), $comparison);
        } elseif ($file instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DelivererTableMap::COL_PHOTO_ID, $file->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFile() only accepts arguments of type \Gekosale\Plugin\File\Model\ORM\File or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the File relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function joinFile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('File');

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
            $this->addJoinObject($join, 'File');
        }

        return $this;
    }

    /**
     * Use the File relation File object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\File\Model\ORM\FileQuery A secondary query class using the current class as primary query
     */
    public function useFileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'File', '\Gekosale\Plugin\File\Model\ORM\FileQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Producer\Model\ORM\ProducerDeliverer object
     *
     * @param \Gekosale\Plugin\Producer\Model\ORM\ProducerDeliverer|ObjectCollection $producerDeliverer  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByProducerDeliverer($producerDeliverer, $comparison = null)
    {
        if ($producerDeliverer instanceof \Gekosale\Plugin\Producer\Model\ORM\ProducerDeliverer) {
            return $this
                ->addUsingAlias(DelivererTableMap::COL_ID, $producerDeliverer->getDelivererId(), $comparison);
        } elseif ($producerDeliverer instanceof ObjectCollection) {
            return $this
                ->useProducerDelivererQuery()
                ->filterByPrimaryKeys($producerDeliverer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProducerDeliverer() only accepts arguments of type \Gekosale\Plugin\Producer\Model\ORM\ProducerDeliverer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProducerDeliverer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function joinProducerDeliverer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProducerDeliverer');

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
            $this->addJoinObject($join, 'ProducerDeliverer');
        }

        return $this;
    }

    /**
     * Use the ProducerDeliverer relation ProducerDeliverer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Producer\Model\ORM\ProducerDelivererQuery A secondary query class using the current class as primary query
     */
    public function useProducerDelivererQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProducerDeliverer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProducerDeliverer', '\Gekosale\Plugin\Producer\Model\ORM\ProducerDelivererQuery');
    }

    /**
     * Filter the query by a related \Gekosale\Plugin\Deliverer\Model\ORM\DelivererProduct object
     *
     * @param \Gekosale\Plugin\Deliverer\Model\ORM\DelivererProduct|ObjectCollection $delivererProduct  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function filterByDelivererProduct($delivererProduct, $comparison = null)
    {
        if ($delivererProduct instanceof \Gekosale\Plugin\Deliverer\Model\ORM\DelivererProduct) {
            return $this
                ->addUsingAlias(DelivererTableMap::COL_ID, $delivererProduct->getDelivererId(), $comparison);
        } elseif ($delivererProduct instanceof ObjectCollection) {
            return $this
                ->useDelivererProductQuery()
                ->filterByPrimaryKeys($delivererProduct->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDelivererProduct() only accepts arguments of type \Gekosale\Plugin\Deliverer\Model\ORM\DelivererProduct or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DelivererProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function joinDelivererProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DelivererProduct');

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
            $this->addJoinObject($join, 'DelivererProduct');
        }

        return $this;
    }

    /**
     * Use the DelivererProduct relation DelivererProduct object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Gekosale\Plugin\Deliverer\Model\ORM\DelivererProductQuery A secondary query class using the current class as primary query
     */
    public function useDelivererProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDelivererProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DelivererProduct', '\Gekosale\Plugin\Deliverer\Model\ORM\DelivererProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDeliverer $deliverer Object to remove from the list of results
     *
     * @return ChildDelivererQuery The current query, for fluid interface
     */
    public function prune($deliverer = null)
    {
        if ($deliverer) {
            $this->addUsingAlias(DelivererTableMap::COL_ID, $deliverer->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the deliverer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DelivererTableMap::DATABASE_NAME);
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
            DelivererTableMap::clearInstancePool();
            DelivererTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildDeliverer or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildDeliverer object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DelivererTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DelivererTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        DelivererTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DelivererTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // DelivererQuery
