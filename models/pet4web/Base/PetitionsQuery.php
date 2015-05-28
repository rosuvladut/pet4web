<?php

namespace pet4web\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use pet4web\Petitions as ChildPetitions;
use pet4web\PetitionsQuery as ChildPetitionsQuery;
use pet4web\Map\PetitionsTableMap;

/**
 * Base class that represents a query for the 'petitions' table.
 *
 *
 *
 * @method     ChildPetitionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPetitionsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPetitionsQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildPetitionsQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildPetitionsQuery orderByTarget($order = Criteria::ASC) Order by the target column
 * @method     ChildPetitionsQuery orderBySigned($order = Criteria::ASC) Order by the signed column
 * @method     ChildPetitionsQuery orderByUserid($order = Criteria::ASC) Order by the userid column
 * @method     ChildPetitionsQuery orderByCategory($order = Criteria::ASC) Order by the category column
 *
 * @method     ChildPetitionsQuery groupById() Group by the id column
 * @method     ChildPetitionsQuery groupByTitle() Group by the title column
 * @method     ChildPetitionsQuery groupByMessage() Group by the message column
 * @method     ChildPetitionsQuery groupByState() Group by the state column
 * @method     ChildPetitionsQuery groupByTarget() Group by the target column
 * @method     ChildPetitionsQuery groupBySigned() Group by the signed column
 * @method     ChildPetitionsQuery groupByUserid() Group by the userid column
 * @method     ChildPetitionsQuery groupByCategory() Group by the category column
 *
 * @method     ChildPetitionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPetitionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPetitionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPetitionsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildPetitionsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildPetitionsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildPetitionsQuery leftJoinComments($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comments relation
 * @method     ChildPetitionsQuery rightJoinComments($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comments relation
 * @method     ChildPetitionsQuery innerJoinComments($relationAlias = null) Adds a INNER JOIN clause to the query using the Comments relation
 *
 * @method     ChildPetitionsQuery leftJoinSignatures($relationAlias = null) Adds a LEFT JOIN clause to the query using the Signatures relation
 * @method     ChildPetitionsQuery rightJoinSignatures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Signatures relation
 * @method     ChildPetitionsQuery innerJoinSignatures($relationAlias = null) Adds a INNER JOIN clause to the query using the Signatures relation
 *
 * @method     \pet4web\UsersQuery|\pet4web\CommentsQuery|\pet4web\SignaturesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPetitions findOne(ConnectionInterface $con = null) Return the first ChildPetitions matching the query
 * @method     ChildPetitions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPetitions matching the query, or a new ChildPetitions object populated from the query conditions when no match is found
 *
 * @method     ChildPetitions findOneById(int $id) Return the first ChildPetitions filtered by the id column
 * @method     ChildPetitions findOneByTitle(string $title) Return the first ChildPetitions filtered by the title column
 * @method     ChildPetitions findOneByMessage(string $message) Return the first ChildPetitions filtered by the message column
 * @method     ChildPetitions findOneByState(string $state) Return the first ChildPetitions filtered by the state column
 * @method     ChildPetitions findOneByTarget(int $target) Return the first ChildPetitions filtered by the target column
 * @method     ChildPetitions findOneBySigned(int $signed) Return the first ChildPetitions filtered by the signed column
 * @method     ChildPetitions findOneByUserid(int $userid) Return the first ChildPetitions filtered by the userid column
 * @method     ChildPetitions findOneByCategory(string $category) Return the first ChildPetitions filtered by the category column *

 * @method     ChildPetitions requirePk($key, ConnectionInterface $con = null) Return the ChildPetitions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOne(ConnectionInterface $con = null) Return the first ChildPetitions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPetitions requireOneById(int $id) Return the first ChildPetitions filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByTitle(string $title) Return the first ChildPetitions filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByMessage(string $message) Return the first ChildPetitions filtered by the message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByState(string $state) Return the first ChildPetitions filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByTarget(int $target) Return the first ChildPetitions filtered by the target column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneBySigned(int $signed) Return the first ChildPetitions filtered by the signed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByUserid(int $userid) Return the first ChildPetitions filtered by the userid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPetitions requireOneByCategory(string $category) Return the first ChildPetitions filtered by the category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPetitions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPetitions objects based on current ModelCriteria
 * @method     ChildPetitions[]|ObjectCollection findById(int $id) Return ChildPetitions objects filtered by the id column
 * @method     ChildPetitions[]|ObjectCollection findByTitle(string $title) Return ChildPetitions objects filtered by the title column
 * @method     ChildPetitions[]|ObjectCollection findByMessage(string $message) Return ChildPetitions objects filtered by the message column
 * @method     ChildPetitions[]|ObjectCollection findByState(string $state) Return ChildPetitions objects filtered by the state column
 * @method     ChildPetitions[]|ObjectCollection findByTarget(int $target) Return ChildPetitions objects filtered by the target column
 * @method     ChildPetitions[]|ObjectCollection findBySigned(int $signed) Return ChildPetitions objects filtered by the signed column
 * @method     ChildPetitions[]|ObjectCollection findByUserid(int $userid) Return ChildPetitions objects filtered by the userid column
 * @method     ChildPetitions[]|ObjectCollection findByCategory(string $category) Return ChildPetitions objects filtered by the category column
 * @method     ChildPetitions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PetitionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \pet4web\Base\PetitionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\pet4web\\Petitions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPetitionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPetitionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPetitionsQuery) {
            return $criteria;
        }
        $query = new ChildPetitionsQuery();
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
     * @return ChildPetitions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PetitionsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PetitionsTableMap::DATABASE_NAME);
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
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPetitions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, message, state, target, signed, userid, category FROM petitions WHERE id = :p0';
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
            /** @var ChildPetitions $obj */
            $obj = new ChildPetitions();
            $obj->hydrate($row);
            PetitionsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPetitions|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
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
    public function findPks($keys, ConnectionInterface $con = null)
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
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PetitionsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PetitionsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%'); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $state)) {
                $state = str_replace('*', '%', $state);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the target column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget(1234); // WHERE target = 1234
     * $query->filterByTarget(array(12, 34)); // WHERE target IN (12, 34)
     * $query->filterByTarget(array('min' => 12)); // WHERE target > 12
     * </code>
     *
     * @param     mixed $target The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (is_array($target)) {
            $useMinMax = false;
            if (isset($target['min'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_TARGET, $target['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($target['max'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_TARGET, $target['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_TARGET, $target, $comparison);
    }

    /**
     * Filter the query on the signed column
     *
     * Example usage:
     * <code>
     * $query->filterBySigned(1234); // WHERE signed = 1234
     * $query->filterBySigned(array(12, 34)); // WHERE signed IN (12, 34)
     * $query->filterBySigned(array('min' => 12)); // WHERE signed > 12
     * </code>
     *
     * @param     mixed $signed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterBySigned($signed = null, $comparison = null)
    {
        if (is_array($signed)) {
            $useMinMax = false;
            if (isset($signed['min'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_SIGNED, $signed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($signed['max'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_SIGNED, $signed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_SIGNED, $signed, $comparison);
    }

    /**
     * Filter the query on the userid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userid = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userid IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userid > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(PetitionsTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE category = 'fooValue'
     * $query->filterByCategory('%fooValue%'); // WHERE category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $category)) {
                $category = str_replace('*', '%', $category);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PetitionsTableMap::COL_CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query by a related \pet4web\Users object
     *
     * @param \pet4web\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \pet4web\Users) {
            return $this
                ->addUsingAlias(PetitionsTableMap::COL_USERID, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PetitionsTableMap::COL_USERID, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \pet4web\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \pet4web\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\pet4web\UsersQuery');
    }

    /**
     * Filter the query by a related \pet4web\Comments object
     *
     * @param \pet4web\Comments|ObjectCollection $comments the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterByComments($comments, $comparison = null)
    {
        if ($comments instanceof \pet4web\Comments) {
            return $this
                ->addUsingAlias(PetitionsTableMap::COL_ID, $comments->getPetid(), $comparison);
        } elseif ($comments instanceof ObjectCollection) {
            return $this
                ->useCommentsQuery()
                ->filterByPrimaryKeys($comments->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComments() only accepts arguments of type \pet4web\Comments or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comments relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function joinComments($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comments');

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
            $this->addJoinObject($join, 'Comments');
        }

        return $this;
    }

    /**
     * Use the Comments relation Comments object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \pet4web\CommentsQuery A secondary query class using the current class as primary query
     */
    public function useCommentsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComments($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comments', '\pet4web\CommentsQuery');
    }

    /**
     * Filter the query by a related \pet4web\Signatures object
     *
     * @param \pet4web\Signatures|ObjectCollection $signatures the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPetitionsQuery The current query, for fluid interface
     */
    public function filterBySignatures($signatures, $comparison = null)
    {
        if ($signatures instanceof \pet4web\Signatures) {
            return $this
                ->addUsingAlias(PetitionsTableMap::COL_ID, $signatures->getPetid(), $comparison);
        } elseif ($signatures instanceof ObjectCollection) {
            return $this
                ->useSignaturesQuery()
                ->filterByPrimaryKeys($signatures->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySignatures() only accepts arguments of type \pet4web\Signatures or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Signatures relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function joinSignatures($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Signatures');

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
            $this->addJoinObject($join, 'Signatures');
        }

        return $this;
    }

    /**
     * Use the Signatures relation Signatures object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \pet4web\SignaturesQuery A secondary query class using the current class as primary query
     */
    public function useSignaturesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSignatures($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Signatures', '\pet4web\SignaturesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPetitions $petitions Object to remove from the list of results
     *
     * @return $this|ChildPetitionsQuery The current query, for fluid interface
     */
    public function prune($petitions = null)
    {
        if ($petitions) {
            $this->addUsingAlias(PetitionsTableMap::COL_ID, $petitions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the petitions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PetitionsTableMap::clearInstancePool();
            PetitionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PetitionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PetitionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PetitionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PetitionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PetitionsQuery
