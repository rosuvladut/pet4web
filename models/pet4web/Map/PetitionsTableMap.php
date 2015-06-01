<?php

namespace pet4web\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use pet4web\Petitions;
use pet4web\PetitionsQuery;


/**
 * This class defines the structure of the 'petitions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PetitionsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pet4web.Map.PetitionsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'petitions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\pet4web\\Petitions';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'pet4web.Petitions';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'petitions.id';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'petitions.title';

    /**
     * the column name for the message field
     */
    const COL_MESSAGE = 'petitions.message';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'petitions.state';

    /**
     * the column name for the target field
     */
    const COL_TARGET = 'petitions.target';

    /**
     * the column name for the signed field
     */
    const COL_SIGNED = 'petitions.signed';

    /**
     * the column name for the userid field
     */
    const COL_USERID = 'petitions.userid';

    /**
     * the column name for the category field
     */
    const COL_CATEGORY = 'petitions.category';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'petitions.created';

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
        self::TYPE_PHPNAME       => array('Id', 'Title', 'Message', 'State', 'Target', 'Signed', 'Userid', 'Category', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'title', 'message', 'state', 'target', 'signed', 'userid', 'category', 'created', ),
        self::TYPE_COLNAME       => array(PetitionsTableMap::COL_ID, PetitionsTableMap::COL_TITLE, PetitionsTableMap::COL_MESSAGE, PetitionsTableMap::COL_STATE, PetitionsTableMap::COL_TARGET, PetitionsTableMap::COL_SIGNED, PetitionsTableMap::COL_USERID, PetitionsTableMap::COL_CATEGORY, PetitionsTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'title', 'message', 'state', 'target', 'signed', 'userid', 'category', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Title' => 1, 'Message' => 2, 'State' => 3, 'Target' => 4, 'Signed' => 5, 'Userid' => 6, 'Category' => 7, 'Created' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'title' => 1, 'message' => 2, 'state' => 3, 'target' => 4, 'signed' => 5, 'userid' => 6, 'category' => 7, 'created' => 8, ),
        self::TYPE_COLNAME       => array(PetitionsTableMap::COL_ID => 0, PetitionsTableMap::COL_TITLE => 1, PetitionsTableMap::COL_MESSAGE => 2, PetitionsTableMap::COL_STATE => 3, PetitionsTableMap::COL_TARGET => 4, PetitionsTableMap::COL_SIGNED => 5, PetitionsTableMap::COL_USERID => 6, PetitionsTableMap::COL_CATEGORY => 7, PetitionsTableMap::COL_CREATED => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'title' => 1, 'message' => 2, 'state' => 3, 'target' => 4, 'signed' => 5, 'userid' => 6, 'category' => 7, 'created' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('petitions');
        $this->setPhpName('Petitions');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\pet4web\\Petitions');
        $this->setPackage('pet4web');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 120, null);
        $this->addColumn('message', 'Message', 'VARCHAR', true, 800, null);
        $this->addColumn('state', 'State', 'VARCHAR', true, 30, null);
        $this->addColumn('target', 'Target', 'INTEGER', true, null, null);
        $this->addColumn('signed', 'Signed', 'INTEGER', true, null, null);
        $this->addForeignKey('userid', 'Userid', 'INTEGER', 'users', 'id', true, null, null);
        $this->addColumn('category', 'Category', 'VARCHAR', true, 50, null);
        $this->addColumn('created', 'Created', 'DATE', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Users', '\\pet4web\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':userid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Comments', '\\pet4web\\Comments', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':petid',
    1 => ':id',
  ),
), null, null, 'Commentss', false);
        $this->addRelation('Signatures', '\\pet4web\\Signatures', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':petid',
    1 => ':id',
  ),
), null, null, 'Signaturess', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
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
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
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
        return $withPrefix ? PetitionsTableMap::CLASS_DEFAULT : PetitionsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Petitions object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PetitionsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PetitionsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PetitionsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PetitionsTableMap::OM_CLASS;
            /** @var Petitions $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PetitionsTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PetitionsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PetitionsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Petitions $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PetitionsTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PetitionsTableMap::COL_ID);
            $criteria->addSelectColumn(PetitionsTableMap::COL_TITLE);
            $criteria->addSelectColumn(PetitionsTableMap::COL_MESSAGE);
            $criteria->addSelectColumn(PetitionsTableMap::COL_STATE);
            $criteria->addSelectColumn(PetitionsTableMap::COL_TARGET);
            $criteria->addSelectColumn(PetitionsTableMap::COL_SIGNED);
            $criteria->addSelectColumn(PetitionsTableMap::COL_USERID);
            $criteria->addSelectColumn(PetitionsTableMap::COL_CATEGORY);
            $criteria->addSelectColumn(PetitionsTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.message');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.target');
            $criteria->addSelectColumn($alias . '.signed');
            $criteria->addSelectColumn($alias . '.userid');
            $criteria->addSelectColumn($alias . '.category');
            $criteria->addSelectColumn($alias . '.created');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PetitionsTableMap::DATABASE_NAME)->getTable(PetitionsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PetitionsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PetitionsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PetitionsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Petitions or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Petitions object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \pet4web\Petitions) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PetitionsTableMap::DATABASE_NAME);
            $criteria->add(PetitionsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PetitionsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PetitionsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PetitionsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the petitions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PetitionsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Petitions or Criteria object.
     *
     * @param mixed               $criteria Criteria or Petitions object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Petitions object
        }

        if ($criteria->containsKey(PetitionsTableMap::COL_ID) && $criteria->keyContainsValue(PetitionsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PetitionsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PetitionsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PetitionsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PetitionsTableMap::buildTableMap();
