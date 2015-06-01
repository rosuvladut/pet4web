<?php

namespace pet4web\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use pet4web\Comments as ChildComments;
use pet4web\CommentsQuery as ChildCommentsQuery;
use pet4web\Petitions as ChildPetitions;
use pet4web\PetitionsQuery as ChildPetitionsQuery;
use pet4web\Signatures as ChildSignatures;
use pet4web\SignaturesQuery as ChildSignaturesQuery;
use pet4web\Users as ChildUsers;
use pet4web\UsersQuery as ChildUsersQuery;
use pet4web\Map\PetitionsTableMap;

/**
 * Base class that represents a row from the 'petitions' table.
 *
 *
 *
* @package    propel.generator.pet4web.Base
*/
abstract class Petitions implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\pet4web\\Map\\PetitionsTableMap';


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
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the message field.
     * @var        string
     */
    protected $message;

    /**
     * The value for the state field.
     * @var        string
     */
    protected $state;

    /**
     * The value for the target field.
     * @var        int
     */
    protected $target;

    /**
     * The value for the signed field.
     * @var        int
     */
    protected $signed;

    /**
     * The value for the userid field.
     * @var        int
     */
    protected $userid;

    /**
     * The value for the category field.
     * @var        string
     */
    protected $category;

    /**
     * The value for the created field.
     * @var        \DateTime
     */
    protected $created;

    /**
     * @var        ChildUsers
     */
    protected $aUsers;

    /**
     * @var        ObjectCollection|ChildComments[] Collection to store aggregation of ChildComments objects.
     */
    protected $collCommentss;
    protected $collCommentssPartial;

    /**
     * @var        ObjectCollection|ChildSignatures[] Collection to store aggregation of ChildSignatures objects.
     */
    protected $collSignaturess;
    protected $collSignaturessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComments[]
     */
    protected $commentssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSignatures[]
     */
    protected $signaturessScheduledForDeletion = null;

    /**
     * Initializes internal state of pet4web\Base\Petitions object.
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
        $this->new = (boolean) $b;
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
        $this->deleted = (boolean) $b;
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
     * Compares this with another <code>Petitions</code> instance.  If
     * <code>obj</code> is an instance of <code>Petitions</code>, delegates to
     * <code>equals(Petitions)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
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
     * @return $this|Petitions The current object, for fluid interface
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [message] column value.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the [state] column value.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the [target] column value.
     *
     * @return int
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get the [signed] column value.
     *
     * @return int
     */
    public function getSigned()
    {
        return $this->signed;
    }

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Get the [category] column value.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = NULL)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTime ? $this->created->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [message] column.
     *
     * @param string $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setMessage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->message !== $v) {
            $this->message = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_MESSAGE] = true;
        }

        return $this;
    } // setMessage()

    /**
     * Set the value of [state] column.
     *
     * @param string $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_STATE] = true;
        }

        return $this;
    } // setState()

    /**
     * Set the value of [target] column.
     *
     * @param int $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setTarget($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->target !== $v) {
            $this->target = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_TARGET] = true;
        }

        return $this;
    } // setTarget()

    /**
     * Set the value of [signed] column.
     *
     * @param int $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setSigned($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->signed !== $v) {
            $this->signed = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_SIGNED] = true;
        }

        return $this;
    } // setSigned()

    /**
     * Set the value of [userid] column.
     *
     * @param int $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_USERID] = true;
        }

        if ($this->aUsers !== null && $this->aUsers->getId() !== $v) {
            $this->aUsers = null;
        }

        return $this;
    } // setUserid()

    /**
     * Set the value of [category] column.
     *
     * @param string $v new value
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->category !== $v) {
            $this->category = $v;
            $this->modifiedColumns[PetitionsTableMap::COL_CATEGORY] = true;
        }

        return $this;
    } // setCategory()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d") !== $this->created->format("Y-m-d")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PetitionsTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setCreated()

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
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PetitionsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PetitionsTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PetitionsTableMap::translateFieldName('Message', TableMap::TYPE_PHPNAME, $indexType)];
            $this->message = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PetitionsTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PetitionsTableMap::translateFieldName('Target', TableMap::TYPE_PHPNAME, $indexType)];
            $this->target = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PetitionsTableMap::translateFieldName('Signed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->signed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PetitionsTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PetitionsTableMap::translateFieldName('Category', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PetitionsTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = PetitionsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\pet4web\\Petitions'), 0, $e);
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
        if ($this->aUsers !== null && $this->userid !== $this->aUsers->getId()) {
            $this->aUsers = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(PetitionsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPetitionsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsers = null;
            $this->collCommentss = null;

            $this->collSignaturess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Petitions::setDeleted()
     * @see Petitions::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPetitionsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
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
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
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
                PetitionsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUsers !== null) {
                if ($this->aUsers->isModified() || $this->aUsers->isNew()) {
                    $affectedRows += $this->aUsers->save($con);
                }
                $this->setUsers($this->aUsers);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->commentssScheduledForDeletion !== null) {
                if (!$this->commentssScheduledForDeletion->isEmpty()) {
                    \pet4web\CommentsQuery::create()
                        ->filterByPrimaryKeys($this->commentssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentssScheduledForDeletion = null;
                }
            }

            if ($this->collCommentss !== null) {
                foreach ($this->collCommentss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->signaturessScheduledForDeletion !== null) {
                if (!$this->signaturessScheduledForDeletion->isEmpty()) {
                    \pet4web\SignaturesQuery::create()
                        ->filterByPrimaryKeys($this->signaturessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->signaturessScheduledForDeletion = null;
                }
            }

            if ($this->collSignaturess !== null) {
                foreach ($this->collSignaturess as $referrerFK) {
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

        $this->modifiedColumns[PetitionsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PetitionsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PetitionsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_MESSAGE)) {
            $modifiedColumns[':p' . $index++]  = 'message';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'target';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_SIGNED)) {
            $modifiedColumns[':p' . $index++]  = 'signed';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userid';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'category';
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO petitions (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'message':
                        $stmt->bindValue($identifier, $this->message, PDO::PARAM_STR);
                        break;
                    case 'state':
                        $stmt->bindValue($identifier, $this->state, PDO::PARAM_STR);
                        break;
                    case 'target':
                        $stmt->bindValue($identifier, $this->target, PDO::PARAM_INT);
                        break;
                    case 'signed':
                        $stmt->bindValue($identifier, $this->signed, PDO::PARAM_INT);
                        break;
                    case 'userid':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
                        break;
                    case 'category':
                        $stmt->bindValue($identifier, $this->category, PDO::PARAM_STR);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PetitionsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTitle();
                break;
            case 2:
                return $this->getMessage();
                break;
            case 3:
                return $this->getState();
                break;
            case 4:
                return $this->getTarget();
                break;
            case 5:
                return $this->getSigned();
                break;
            case 6:
                return $this->getUserid();
                break;
            case 7:
                return $this->getCategory();
                break;
            case 8:
                return $this->getCreated();
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
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

        if (isset($alreadyDumpedObjects['Petitions'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Petitions'][$this->hashCode()] = true;
        $keys = PetitionsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getMessage(),
            $keys[3] => $this->getState(),
            $keys[4] => $this->getTarget(),
            $keys[5] => $this->getSigned(),
            $keys[6] => $this->getUserid(),
            $keys[7] => $this->getCategory(),
            $keys[8] => $this->getCreated(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[8]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[8]];
            $result[$keys[8]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'Users';
                }

                $result[$key] = $this->aUsers->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCommentss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commentss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commentss';
                        break;
                    default:
                        $key = 'Commentss';
                }

                $result[$key] = $this->collCommentss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSignaturess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'signaturess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'signaturess';
                        break;
                    default:
                        $key = 'Signaturess';
                }

                $result[$key] = $this->collSignaturess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\pet4web\Petitions
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PetitionsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\pet4web\Petitions
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setMessage($value);
                break;
            case 3:
                $this->setState($value);
                break;
            case 4:
                $this->setTarget($value);
                break;
            case 5:
                $this->setSigned($value);
                break;
            case 6:
                $this->setUserid($value);
                break;
            case 7:
                $this->setCategory($value);
                break;
            case 8:
                $this->setCreated($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PetitionsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMessage($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setState($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTarget($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSigned($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUserid($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCategory($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCreated($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\pet4web\Petitions The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PetitionsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PetitionsTableMap::COL_ID)) {
            $criteria->add(PetitionsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_TITLE)) {
            $criteria->add(PetitionsTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_MESSAGE)) {
            $criteria->add(PetitionsTableMap::COL_MESSAGE, $this->message);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_STATE)) {
            $criteria->add(PetitionsTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_TARGET)) {
            $criteria->add(PetitionsTableMap::COL_TARGET, $this->target);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_SIGNED)) {
            $criteria->add(PetitionsTableMap::COL_SIGNED, $this->signed);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_USERID)) {
            $criteria->add(PetitionsTableMap::COL_USERID, $this->userid);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_CATEGORY)) {
            $criteria->add(PetitionsTableMap::COL_CATEGORY, $this->category);
        }
        if ($this->isColumnModified(PetitionsTableMap::COL_CREATED)) {
            $criteria->add(PetitionsTableMap::COL_CREATED, $this->created);
        }

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
        $criteria = ChildPetitionsQuery::create();
        $criteria->add(PetitionsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
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
     * @param      object $copyObj An object of \pet4web\Petitions (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setMessage($this->getMessage());
        $copyObj->setState($this->getState());
        $copyObj->setTarget($this->getTarget());
        $copyObj->setSigned($this->getSigned());
        $copyObj->setUserid($this->getUserid());
        $copyObj->setCategory($this->getCategory());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComments($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSignaturess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSignatures($relObj->copy($deepCopy));
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
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \pet4web\Petitions Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsers(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setUserid(NULL);
        } else {
            $this->setUserid($v->getId());
        }

        $this->aUsers = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addPetitions($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUsers(ConnectionInterface $con = null)
    {
        if ($this->aUsers === null && ($this->userid !== null)) {
            $this->aUsers = ChildUsersQuery::create()->findPk($this->userid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsers->addPetitionss($this);
             */
        }

        return $this->aUsers;
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
        if ('Comments' == $relationName) {
            return $this->initCommentss();
        }
        if ('Signatures' == $relationName) {
            return $this->initSignaturess();
        }
    }

    /**
     * Clears out the collCommentss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentss()
     */
    public function clearCommentss()
    {
        $this->collCommentss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentss collection loaded partially.
     */
    public function resetPartialCommentss($v = true)
    {
        $this->collCommentssPartial = $v;
    }

    /**
     * Initializes the collCommentss collection.
     *
     * By default this just sets the collCommentss collection to an empty array (like clearcollCommentss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentss($overrideExisting = true)
    {
        if (null !== $this->collCommentss && !$overrideExisting) {
            return;
        }
        $this->collCommentss = new ObjectCollection();
        $this->collCommentss->setModel('\pet4web\Comments');
    }

    /**
     * Gets an array of ChildComments objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPetitions is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     * @throws PropelException
     */
    public function getCommentss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                // return empty collection
                $this->initCommentss();
            } else {
                $collCommentss = ChildCommentsQuery::create(null, $criteria)
                    ->filterByPetitions($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentssPartial && count($collCommentss)) {
                        $this->initCommentss(false);

                        foreach ($collCommentss as $obj) {
                            if (false == $this->collCommentss->contains($obj)) {
                                $this->collCommentss->append($obj);
                            }
                        }

                        $this->collCommentssPartial = true;
                    }

                    return $collCommentss;
                }

                if ($partial && $this->collCommentss) {
                    foreach ($this->collCommentss as $obj) {
                        if ($obj->isNew()) {
                            $collCommentss[] = $obj;
                        }
                    }
                }

                $this->collCommentss = $collCommentss;
                $this->collCommentssPartial = false;
            }
        }

        return $this->collCommentss;
    }

    /**
     * Sets a collection of ChildComments objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPetitions The current object (for fluent API support)
     */
    public function setCommentss(Collection $commentss, ConnectionInterface $con = null)
    {
        /** @var ChildComments[] $commentssToDelete */
        $commentssToDelete = $this->getCommentss(new Criteria(), $con)->diff($commentss);


        $this->commentssScheduledForDeletion = $commentssToDelete;

        foreach ($commentssToDelete as $commentsRemoved) {
            $commentsRemoved->setPetitions(null);
        }

        $this->collCommentss = null;
        foreach ($commentss as $comments) {
            $this->addComments($comments);
        }

        $this->collCommentss = $commentss;
        $this->collCommentssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comments objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comments objects.
     * @throws PropelException
     */
    public function countCommentss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentssPartial && !$this->isNew();
        if (null === $this->collCommentss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentss());
            }

            $query = ChildCommentsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPetitions($this)
                ->count($con);
        }

        return count($this->collCommentss);
    }

    /**
     * Method called to associate a ChildComments object to this object
     * through the ChildComments foreign key attribute.
     *
     * @param  ChildComments $l ChildComments
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function addComments(ChildComments $l)
    {
        if ($this->collCommentss === null) {
            $this->initCommentss();
            $this->collCommentssPartial = true;
        }

        if (!$this->collCommentss->contains($l)) {
            $this->doAddComments($l);
        }

        return $this;
    }

    /**
     * @param ChildComments $comments The ChildComments object to add.
     */
    protected function doAddComments(ChildComments $comments)
    {
        $this->collCommentss[]= $comments;
        $comments->setPetitions($this);
    }

    /**
     * @param  ChildComments $comments The ChildComments object to remove.
     * @return $this|ChildPetitions The current object (for fluent API support)
     */
    public function removeComments(ChildComments $comments)
    {
        if ($this->getCommentss()->contains($comments)) {
            $pos = $this->collCommentss->search($comments);
            $this->collCommentss->remove($pos);
            if (null === $this->commentssScheduledForDeletion) {
                $this->commentssScheduledForDeletion = clone $this->collCommentss;
                $this->commentssScheduledForDeletion->clear();
            }
            $this->commentssScheduledForDeletion[]= clone $comments;
            $comments->setPetitions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Petitions is new, it will return
     * an empty collection; or if this Petitions has previously
     * been saved, it will retrieve related Commentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Petitions.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComments[] List of ChildComments objects
     */
    public function getCommentssJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentsQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getCommentss($query, $con);
    }

    /**
     * Clears out the collSignaturess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSignaturess()
     */
    public function clearSignaturess()
    {
        $this->collSignaturess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSignaturess collection loaded partially.
     */
    public function resetPartialSignaturess($v = true)
    {
        $this->collSignaturessPartial = $v;
    }

    /**
     * Initializes the collSignaturess collection.
     *
     * By default this just sets the collSignaturess collection to an empty array (like clearcollSignaturess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSignaturess($overrideExisting = true)
    {
        if (null !== $this->collSignaturess && !$overrideExisting) {
            return;
        }
        $this->collSignaturess = new ObjectCollection();
        $this->collSignaturess->setModel('\pet4web\Signatures');
    }

    /**
     * Gets an array of ChildSignatures objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPetitions is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSignatures[] List of ChildSignatures objects
     * @throws PropelException
     */
    public function getSignaturess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSignaturessPartial && !$this->isNew();
        if (null === $this->collSignaturess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSignaturess) {
                // return empty collection
                $this->initSignaturess();
            } else {
                $collSignaturess = ChildSignaturesQuery::create(null, $criteria)
                    ->filterByPetitions($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSignaturessPartial && count($collSignaturess)) {
                        $this->initSignaturess(false);

                        foreach ($collSignaturess as $obj) {
                            if (false == $this->collSignaturess->contains($obj)) {
                                $this->collSignaturess->append($obj);
                            }
                        }

                        $this->collSignaturessPartial = true;
                    }

                    return $collSignaturess;
                }

                if ($partial && $this->collSignaturess) {
                    foreach ($this->collSignaturess as $obj) {
                        if ($obj->isNew()) {
                            $collSignaturess[] = $obj;
                        }
                    }
                }

                $this->collSignaturess = $collSignaturess;
                $this->collSignaturessPartial = false;
            }
        }

        return $this->collSignaturess;
    }

    /**
     * Sets a collection of ChildSignatures objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $signaturess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPetitions The current object (for fluent API support)
     */
    public function setSignaturess(Collection $signaturess, ConnectionInterface $con = null)
    {
        /** @var ChildSignatures[] $signaturessToDelete */
        $signaturessToDelete = $this->getSignaturess(new Criteria(), $con)->diff($signaturess);


        $this->signaturessScheduledForDeletion = $signaturessToDelete;

        foreach ($signaturessToDelete as $signaturesRemoved) {
            $signaturesRemoved->setPetitions(null);
        }

        $this->collSignaturess = null;
        foreach ($signaturess as $signatures) {
            $this->addSignatures($signatures);
        }

        $this->collSignaturess = $signaturess;
        $this->collSignaturessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Signatures objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Signatures objects.
     * @throws PropelException
     */
    public function countSignaturess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSignaturessPartial && !$this->isNew();
        if (null === $this->collSignaturess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSignaturess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSignaturess());
            }

            $query = ChildSignaturesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPetitions($this)
                ->count($con);
        }

        return count($this->collSignaturess);
    }

    /**
     * Method called to associate a ChildSignatures object to this object
     * through the ChildSignatures foreign key attribute.
     *
     * @param  ChildSignatures $l ChildSignatures
     * @return $this|\pet4web\Petitions The current object (for fluent API support)
     */
    public function addSignatures(ChildSignatures $l)
    {
        if ($this->collSignaturess === null) {
            $this->initSignaturess();
            $this->collSignaturessPartial = true;
        }

        if (!$this->collSignaturess->contains($l)) {
            $this->doAddSignatures($l);
        }

        return $this;
    }

    /**
     * @param ChildSignatures $signatures The ChildSignatures object to add.
     */
    protected function doAddSignatures(ChildSignatures $signatures)
    {
        $this->collSignaturess[]= $signatures;
        $signatures->setPetitions($this);
    }

    /**
     * @param  ChildSignatures $signatures The ChildSignatures object to remove.
     * @return $this|ChildPetitions The current object (for fluent API support)
     */
    public function removeSignatures(ChildSignatures $signatures)
    {
        if ($this->getSignaturess()->contains($signatures)) {
            $pos = $this->collSignaturess->search($signatures);
            $this->collSignaturess->remove($pos);
            if (null === $this->signaturessScheduledForDeletion) {
                $this->signaturessScheduledForDeletion = clone $this->collSignaturess;
                $this->signaturessScheduledForDeletion->clear();
            }
            $this->signaturessScheduledForDeletion[]= clone $signatures;
            $signatures->setPetitions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Petitions is new, it will return
     * an empty collection; or if this Petitions has previously
     * been saved, it will retrieve related Signaturess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Petitions.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSignatures[] List of ChildSignatures objects
     */
    public function getSignaturessJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSignaturesQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getSignaturess($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUsers) {
            $this->aUsers->removePetitions($this);
        }
        $this->id = null;
        $this->title = null;
        $this->message = null;
        $this->state = null;
        $this->target = null;
        $this->signed = null;
        $this->userid = null;
        $this->category = null;
        $this->created = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCommentss) {
                foreach ($this->collCommentss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSignaturess) {
                foreach ($this->collSignaturess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommentss = null;
        $this->collSignaturess = null;
        $this->aUsers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PetitionsTableMap::DEFAULT_STRING_FORMAT);
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
