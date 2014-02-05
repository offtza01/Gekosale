<?php

namespace Gekosale\Plugin\OrderStatus\Model\ORM\Base;

use \Exception;
use \PDO;
use Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups as ChildOrderStatusGroups;
use Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroupsQuery as ChildOrderStatusGroupsQuery;
use Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusOrderStatusGroups as ChildOrderStatusOrderStatusGroups;
use Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusOrderStatusGroupsQuery as ChildOrderStatusOrderStatusGroupsQuery;
use Gekosale\Plugin\OrderStatus\Model\ORM\Map\OrderStatusGroupsTableMap;
use Gekosale\Plugin\Shop\Model\ORM\Shop as ChildShop;
use Gekosale\Plugin\Shop\Model\ORM\ShopQuery;
use Gekosale\Plugin\Shop\Model\ORM\Base\Shop;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class OrderStatusGroups implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Gekosale\\Plugin\\OrderStatus\\Model\\ORM\\Map\\OrderStatusGroupsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the colour field.
     * @var        string
     */
    protected $colour;

    /**
     * @var        ObjectCollection|ChildOrderStatusOrderStatusGroups[] Collection to store aggregation of ChildOrderStatusOrderStatusGroups objects.
     */
    protected $collOrderStatusOrderStatusGroupss;
    protected $collOrderStatusOrderStatusGroupssPartial;

    /**
     * @var        ObjectCollection|ChildShop[] Collection to store aggregation of ChildShop objects.
     */
    protected $collShops;
    protected $collShopsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $orderStatusOrderStatusGroupssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $shopsScheduledForDeletion = null;

    /**
     * Initializes internal state of Gekosale\Plugin\OrderStatus\Model\ORM\Base\OrderStatusGroups object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>OrderStatusGroups</code> instance.  If
     * <code>obj</code> is an instance of <code>OrderStatusGroups</code>, delegates to
     * <code>equals(OrderStatusGroups)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return OrderStatusGroups The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return OrderStatusGroups The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     * 
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [colour] column value.
     * 
     * @return   string
     */
    public function getColour()
    {

        return $this->colour;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param      int $v new value
     * @return   \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[OrderStatusGroupsTableMap::COL_ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [colour] column.
     * 
     * @param      string $v new value
     * @return   \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups The current object (for fluent API support)
     */
    public function setColour($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->colour !== $v) {
            $this->colour = $v;
            $this->modifiedColumns[OrderStatusGroupsTableMap::COL_COLOUR] = true;
        }


        return $this;
    } // setColour()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OrderStatusGroupsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OrderStatusGroupsTableMap::translateFieldName('Colour', TableMap::TYPE_PHPNAME, $indexType)];
            $this->colour = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = OrderStatusGroupsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderStatusGroupsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOrderStatusGroupsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collOrderStatusOrderStatusGroupss = null;

            $this->collShops = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see OrderStatusGroups::setDeleted()
     * @see OrderStatusGroups::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderStatusGroupsTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildOrderStatusGroupsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderStatusGroupsTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                OrderStatusGroupsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->orderStatusOrderStatusGroupssScheduledForDeletion !== null) {
                if (!$this->orderStatusOrderStatusGroupssScheduledForDeletion->isEmpty()) {
                    \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusOrderStatusGroupsQuery::create()
                        ->filterByPrimaryKeys($this->orderStatusOrderStatusGroupssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderStatusOrderStatusGroupssScheduledForDeletion = null;
                }
            }

                if ($this->collOrderStatusOrderStatusGroupss !== null) {
            foreach ($this->collOrderStatusOrderStatusGroupss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->shopsScheduledForDeletion !== null) {
                if (!$this->shopsScheduledForDeletion->isEmpty()) {
                    foreach ($this->shopsScheduledForDeletion as $shop) {
                        // need to save related object because we set the relation to null
                        $shop->save($con);
                    }
                    $this->shopsScheduledForDeletion = null;
                }
            }

                if ($this->collShops !== null) {
            foreach ($this->collShops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[OrderStatusGroupsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrderStatusGroupsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrderStatusGroupsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(OrderStatusGroupsTableMap::COL_COLOUR)) {
            $modifiedColumns[':p' . $index++]  = 'COLOUR';
        }

        $sql = sprintf(
            'INSERT INTO order_status_groups (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'COLOUR':                        
                        $stmt->bindValue($identifier, $this->colour, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderStatusGroupsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getColour();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['OrderStatusGroups'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['OrderStatusGroups'][$this->getPrimaryKey()] = true;
        $keys = OrderStatusGroupsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getColour(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collOrderStatusOrderStatusGroupss) {
                $result['OrderStatusOrderStatusGroupss'] = $this->collOrderStatusOrderStatusGroupss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShops) {
                $result['Shops'] = $this->collShops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderStatusGroupsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setColour($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = OrderStatusGroupsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setColour($arr[$keys[1]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OrderStatusGroupsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OrderStatusGroupsTableMap::COL_ID)) $criteria->add(OrderStatusGroupsTableMap::COL_ID, $this->id);
        if ($this->isColumnModified(OrderStatusGroupsTableMap::COL_COLOUR)) $criteria->add(OrderStatusGroupsTableMap::COL_COLOUR, $this->colour);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(OrderStatusGroupsTableMap::DATABASE_NAME);
        $criteria->add(OrderStatusGroupsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setColour($this->getColour());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOrderStatusOrderStatusGroupss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderStatusOrderStatusGroups($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getShops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShop($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('OrderStatusOrderStatusGroups' == $relationName) {
            return $this->initOrderStatusOrderStatusGroupss();
        }
        if ('Shop' == $relationName) {
            return $this->initShops();
        }
    }

    /**
     * Clears out the collOrderStatusOrderStatusGroupss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOrderStatusOrderStatusGroupss()
     */
    public function clearOrderStatusOrderStatusGroupss()
    {
        $this->collOrderStatusOrderStatusGroupss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOrderStatusOrderStatusGroupss collection loaded partially.
     */
    public function resetPartialOrderStatusOrderStatusGroupss($v = true)
    {
        $this->collOrderStatusOrderStatusGroupssPartial = $v;
    }

    /**
     * Initializes the collOrderStatusOrderStatusGroupss collection.
     *
     * By default this just sets the collOrderStatusOrderStatusGroupss collection to an empty array (like clearcollOrderStatusOrderStatusGroupss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderStatusOrderStatusGroupss($overrideExisting = true)
    {
        if (null !== $this->collOrderStatusOrderStatusGroupss && !$overrideExisting) {
            return;
        }
        $this->collOrderStatusOrderStatusGroupss = new ObjectCollection();
        $this->collOrderStatusOrderStatusGroupss->setModel('\Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusOrderStatusGroups');
    }

    /**
     * Gets an array of ChildOrderStatusOrderStatusGroups objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOrderStatusGroups is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildOrderStatusOrderStatusGroups[] List of ChildOrderStatusOrderStatusGroups objects
     * @throws PropelException
     */
    public function getOrderStatusOrderStatusGroupss($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderStatusOrderStatusGroupssPartial && !$this->isNew();
        if (null === $this->collOrderStatusOrderStatusGroupss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrderStatusOrderStatusGroupss) {
                // return empty collection
                $this->initOrderStatusOrderStatusGroupss();
            } else {
                $collOrderStatusOrderStatusGroupss = ChildOrderStatusOrderStatusGroupsQuery::create(null, $criteria)
                    ->filterByOrderStatusGroups($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderStatusOrderStatusGroupssPartial && count($collOrderStatusOrderStatusGroupss)) {
                        $this->initOrderStatusOrderStatusGroupss(false);

                        foreach ($collOrderStatusOrderStatusGroupss as $obj) {
                            if (false == $this->collOrderStatusOrderStatusGroupss->contains($obj)) {
                                $this->collOrderStatusOrderStatusGroupss->append($obj);
                            }
                        }

                        $this->collOrderStatusOrderStatusGroupssPartial = true;
                    }

                    reset($collOrderStatusOrderStatusGroupss);

                    return $collOrderStatusOrderStatusGroupss;
                }

                if ($partial && $this->collOrderStatusOrderStatusGroupss) {
                    foreach ($this->collOrderStatusOrderStatusGroupss as $obj) {
                        if ($obj->isNew()) {
                            $collOrderStatusOrderStatusGroupss[] = $obj;
                        }
                    }
                }

                $this->collOrderStatusOrderStatusGroupss = $collOrderStatusOrderStatusGroupss;
                $this->collOrderStatusOrderStatusGroupssPartial = false;
            }
        }

        return $this->collOrderStatusOrderStatusGroupss;
    }

    /**
     * Sets a collection of OrderStatusOrderStatusGroups objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $orderStatusOrderStatusGroupss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOrderStatusGroups The current object (for fluent API support)
     */
    public function setOrderStatusOrderStatusGroupss(Collection $orderStatusOrderStatusGroupss, ConnectionInterface $con = null)
    {
        $orderStatusOrderStatusGroupssToDelete = $this->getOrderStatusOrderStatusGroupss(new Criteria(), $con)->diff($orderStatusOrderStatusGroupss);

        
        $this->orderStatusOrderStatusGroupssScheduledForDeletion = $orderStatusOrderStatusGroupssToDelete;

        foreach ($orderStatusOrderStatusGroupssToDelete as $orderStatusOrderStatusGroupsRemoved) {
            $orderStatusOrderStatusGroupsRemoved->setOrderStatusGroups(null);
        }

        $this->collOrderStatusOrderStatusGroupss = null;
        foreach ($orderStatusOrderStatusGroupss as $orderStatusOrderStatusGroups) {
            $this->addOrderStatusOrderStatusGroups($orderStatusOrderStatusGroups);
        }

        $this->collOrderStatusOrderStatusGroupss = $orderStatusOrderStatusGroupss;
        $this->collOrderStatusOrderStatusGroupssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrderStatusOrderStatusGroups objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related OrderStatusOrderStatusGroups objects.
     * @throws PropelException
     */
    public function countOrderStatusOrderStatusGroupss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderStatusOrderStatusGroupssPartial && !$this->isNew();
        if (null === $this->collOrderStatusOrderStatusGroupss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderStatusOrderStatusGroupss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderStatusOrderStatusGroupss());
            }

            $query = ChildOrderStatusOrderStatusGroupsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrderStatusGroups($this)
                ->count($con);
        }

        return count($this->collOrderStatusOrderStatusGroupss);
    }

    /**
     * Method called to associate a ChildOrderStatusOrderStatusGroups object to this object
     * through the ChildOrderStatusOrderStatusGroups foreign key attribute.
     *
     * @param    ChildOrderStatusOrderStatusGroups $l ChildOrderStatusOrderStatusGroups
     * @return   \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups The current object (for fluent API support)
     */
    public function addOrderStatusOrderStatusGroups(ChildOrderStatusOrderStatusGroups $l)
    {
        if ($this->collOrderStatusOrderStatusGroupss === null) {
            $this->initOrderStatusOrderStatusGroupss();
            $this->collOrderStatusOrderStatusGroupssPartial = true;
        }

        if (!in_array($l, $this->collOrderStatusOrderStatusGroupss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrderStatusOrderStatusGroups($l);
        }

        return $this;
    }

    /**
     * @param OrderStatusOrderStatusGroups $orderStatusOrderStatusGroups The orderStatusOrderStatusGroups object to add.
     */
    protected function doAddOrderStatusOrderStatusGroups($orderStatusOrderStatusGroups)
    {
        $this->collOrderStatusOrderStatusGroupss[]= $orderStatusOrderStatusGroups;
        $orderStatusOrderStatusGroups->setOrderStatusGroups($this);
    }

    /**
     * @param  OrderStatusOrderStatusGroups $orderStatusOrderStatusGroups The orderStatusOrderStatusGroups object to remove.
     * @return ChildOrderStatusGroups The current object (for fluent API support)
     */
    public function removeOrderStatusOrderStatusGroups($orderStatusOrderStatusGroups)
    {
        if ($this->getOrderStatusOrderStatusGroupss()->contains($orderStatusOrderStatusGroups)) {
            $this->collOrderStatusOrderStatusGroupss->remove($this->collOrderStatusOrderStatusGroupss->search($orderStatusOrderStatusGroups));
            if (null === $this->orderStatusOrderStatusGroupssScheduledForDeletion) {
                $this->orderStatusOrderStatusGroupssScheduledForDeletion = clone $this->collOrderStatusOrderStatusGroupss;
                $this->orderStatusOrderStatusGroupssScheduledForDeletion->clear();
            }
            $this->orderStatusOrderStatusGroupssScheduledForDeletion[]= clone $orderStatusOrderStatusGroups;
            $orderStatusOrderStatusGroups->setOrderStatusGroups(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrderStatusGroups is new, it will return
     * an empty collection; or if this OrderStatusGroups has previously
     * been saved, it will retrieve related OrderStatusOrderStatusGroupss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrderStatusGroups.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildOrderStatusOrderStatusGroups[] List of ChildOrderStatusOrderStatusGroups objects
     */
    public function getOrderStatusOrderStatusGroupssJoinOrderStatus($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderStatusOrderStatusGroupsQuery::create(null, $criteria);
        $query->joinWith('OrderStatus', $joinBehavior);

        return $this->getOrderStatusOrderStatusGroupss($query, $con);
    }

    /**
     * Clears out the collShops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addShops()
     */
    public function clearShops()
    {
        $this->collShops = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collShops collection loaded partially.
     */
    public function resetPartialShops($v = true)
    {
        $this->collShopsPartial = $v;
    }

    /**
     * Initializes the collShops collection.
     *
     * By default this just sets the collShops collection to an empty array (like clearcollShops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShops($overrideExisting = true)
    {
        if (null !== $this->collShops && !$overrideExisting) {
            return;
        }
        $this->collShops = new ObjectCollection();
        $this->collShops->setModel('\Gekosale\Plugin\Shop\Model\ORM\Shop');
    }

    /**
     * Gets an array of ChildShop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOrderStatusGroups is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildShop[] List of ChildShop objects
     * @throws PropelException
     */
    public function getShops($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collShopsPartial && !$this->isNew();
        if (null === $this->collShops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShops) {
                // return empty collection
                $this->initShops();
            } else {
                $collShops = ShopQuery::create(null, $criteria)
                    ->filterByOrderStatusGroups($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collShopsPartial && count($collShops)) {
                        $this->initShops(false);

                        foreach ($collShops as $obj) {
                            if (false == $this->collShops->contains($obj)) {
                                $this->collShops->append($obj);
                            }
                        }

                        $this->collShopsPartial = true;
                    }

                    reset($collShops);

                    return $collShops;
                }

                if ($partial && $this->collShops) {
                    foreach ($this->collShops as $obj) {
                        if ($obj->isNew()) {
                            $collShops[] = $obj;
                        }
                    }
                }

                $this->collShops = $collShops;
                $this->collShopsPartial = false;
            }
        }

        return $this->collShops;
    }

    /**
     * Sets a collection of Shop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $shops A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOrderStatusGroups The current object (for fluent API support)
     */
    public function setShops(Collection $shops, ConnectionInterface $con = null)
    {
        $shopsToDelete = $this->getShops(new Criteria(), $con)->diff($shops);

        
        $this->shopsScheduledForDeletion = $shopsToDelete;

        foreach ($shopsToDelete as $shopRemoved) {
            $shopRemoved->setOrderStatusGroups(null);
        }

        $this->collShops = null;
        foreach ($shops as $shop) {
            $this->addShop($shop);
        }

        $this->collShops = $shops;
        $this->collShopsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Shop objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Shop objects.
     * @throws PropelException
     */
    public function countShops(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collShopsPartial && !$this->isNew();
        if (null === $this->collShops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShops) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShops());
            }

            $query = ShopQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrderStatusGroups($this)
                ->count($con);
        }

        return count($this->collShops);
    }

    /**
     * Method called to associate a ChildShop object to this object
     * through the ChildShop foreign key attribute.
     *
     * @param    ChildShop $l ChildShop
     * @return   \Gekosale\Plugin\OrderStatus\Model\ORM\OrderStatusGroups The current object (for fluent API support)
     */
    public function addShop(ChildShop $l)
    {
        if ($this->collShops === null) {
            $this->initShops();
            $this->collShopsPartial = true;
        }

        if (!in_array($l, $this->collShops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddShop($l);
        }

        return $this;
    }

    /**
     * @param Shop $shop The shop object to add.
     */
    protected function doAddShop($shop)
    {
        $this->collShops[]= $shop;
        $shop->setOrderStatusGroups($this);
    }

    /**
     * @param  Shop $shop The shop object to remove.
     * @return ChildOrderStatusGroups The current object (for fluent API support)
     */
    public function removeShop($shop)
    {
        if ($this->getShops()->contains($shop)) {
            $this->collShops->remove($this->collShops->search($shop));
            if (null === $this->shopsScheduledForDeletion) {
                $this->shopsScheduledForDeletion = clone $this->collShops;
                $this->shopsScheduledForDeletion->clear();
            }
            $this->shopsScheduledForDeletion[]= $shop;
            $shop->setOrderStatusGroups(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrderStatusGroups is new, it will return
     * an empty collection; or if this OrderStatusGroups has previously
     * been saved, it will retrieve related Shops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrderStatusGroups.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildShop[] List of ChildShop objects
     */
    public function getShopsJoinContact($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ShopQuery::create(null, $criteria);
        $query->joinWith('Contact', $joinBehavior);

        return $this->getShops($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrderStatusGroups is new, it will return
     * an empty collection; or if this OrderStatusGroups has previously
     * been saved, it will retrieve related Shops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrderStatusGroups.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildShop[] List of ChildShop objects
     */
    public function getShopsJoinCurrency($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ShopQuery::create(null, $criteria);
        $query->joinWith('Currency', $joinBehavior);

        return $this->getShops($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrderStatusGroups is new, it will return
     * an empty collection; or if this OrderStatusGroups has previously
     * been saved, it will retrieve related Shops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrderStatusGroups.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildShop[] List of ChildShop objects
     */
    public function getShopsJoinVat($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ShopQuery::create(null, $criteria);
        $query->joinWith('Vat', $joinBehavior);

        return $this->getShops($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrderStatusGroups is new, it will return
     * an empty collection; or if this OrderStatusGroups has previously
     * been saved, it will retrieve related Shops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrderStatusGroups.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildShop[] List of ChildShop objects
     */
    public function getShopsJoinCompany($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ShopQuery::create(null, $criteria);
        $query->joinWith('Company', $joinBehavior);

        return $this->getShops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->colour = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collOrderStatusOrderStatusGroupss) {
                foreach ($this->collOrderStatusOrderStatusGroupss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collShops) {
                foreach ($this->collShops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOrderStatusOrderStatusGroupss = null;
        $this->collShops = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrderStatusGroupsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
