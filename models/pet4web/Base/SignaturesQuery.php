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
use pet4web\Signatures as ChildSignatures;
use pet4web\SignaturesQuery as ChildSignaturesQuery;
use pet4web\Map\SignaturesTableMap;

/**
 * Base class that represents a query for the 'signatures' table.
 *
 *
 *
 * @method     ChildSignaturesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSignaturesQuery orderBySigned($order = Criteria::ASC) Order by the signed column
 * @method     ChildSignaturesQuery orderByUserid($order = Criteria::ASC) Order by the userid column
 * @method     ChildSignaturesQuery orderByPetid($order = Criteria::ASC) Order by the petid column
 *
 * @method     ChildSignaturesQuery groupById() Group by the id column
 * @method     ChildSignaturesQuery groupBySigned() Group by the signed column
 * @method     ChildSignaturesQuery groupByUserid() Group by the userid column
 * @method     ChildSignaturesQuery groupByPetid() Group by the petid column
 *
 * @method     ChildSignaturesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSignaturesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSignaturesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSignaturesQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildSignaturesQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildSignaturesQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildSignaturesQuery leftJoinPetitions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Petitions relation
 * @method     ChildSignaturesQuery rightJoinPetitions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Petitions relation
 * @method     ChildSignaturesQuery innerJoinPetitions($relationAlias = null) Adds a INNER JOIN clause to the query using the Petitions relation
 *
 * @method     \pet4web\UsersQuery|\pet4web\PetitionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSignatures findOne(ConnectionInterface $con = null) Return the first ChildSignatures matching the query
 * @method     ChildSignatures findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSignatures matching the query, or a new ChildSignatures object populated from the query conditions when no match is found
 *
 * @method     ChildSignatures findOneById(int $id) Return the first ChildSignatures filtered by the id column
 * @method     ChildSignatures findOneBySigned(boolean $signed) Return the first ChildSignatures filtered by the signed column
 * @method     ChildSignatures findOneByUserid(int $userid) Return the first ChildSignatures filtered by the userid column
 * @method     ChildSignatures findOneByPetid(int $petid) Return the first ChildSignatures filtered by the petid column *

 * @method     ChildSignatures requirePk($key, ConnectionInterface $con = null) Return the ChildSignatures by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSignatures requireOne(ConnectionInterface $con = null) Return the first ChildSignatures matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSignatures requireOneById(int $id) Return the first ChildSignatures filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSignatures requireOneBySigned(boolean $signed) Return the first ChildSignatures filtered by the signed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSignatures requireOneByUserid(int $userid) Return the first ChildSignatures filtered by the userid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSignatures requireOneByPetid(int $petid) Return the first ChildSignatures filtered by the petid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSignatures[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSignatures objects based on current ModelCriteria
 * @method     ChildSignatures[]|ObjectCollection findById(int $id) Return ChildSignatures objects filtered by the id column
 * @method     ChildSignatures[]|ObjectCollection findBySigned(boolean $signed) Return ChildSignatures objects filtered by the signed column
 * @method     ChildSignatures[]|ObjectCollection findByUserid(int $userid) Return ChildSignatures objects filtered by the userid column
 * @method     ChildSignatures[]|ObjectCollection findByPetid(int $petid) Return ChildSignatures objects filtered by the petid column
 * @method     ChildSignatures[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SignaturesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \pet4web\Base\SignaturesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\pet4web\\Signatures', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSignaturesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSignaturesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSignaturesQuery) {
            return $criteria;
        }
        $query = new ChildSignaturesQuery();
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
     * @return ChildSignatures|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SignaturesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SignaturesTableMap::DATABASE_NAME);
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
     * @return ChildSignatures A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, signed, userid, petid FROM signatures WHERE id = :p0';
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
            /** @var ChildSignatures $obj */
            $obj = new ChildSignatures();
            $obj->hydrate($row);
            SignaturesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSignatures|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SignaturesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SignaturesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SignaturesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the signed column
     *
     * Example usage:
     * <code>
     * $query->filterBySigned(true); // WHERE signed = true
     * $query->filterBySigned('yes'); // WHERE signed = true
     * </code>
     *
     * @param     boolean|string $signed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterBySigned($signed = null, $comparison = null)
    {
        if (is_string($signed)) {
            $signed = in_array(strtolower($signed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SignaturesTableMap::COL_SIGNED, $signed, $comparison);
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
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SignaturesTableMap::COL_USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the petid column
     *
     * Example usage:
     * <code>
     * $query->filterByPetid(1234); // WHERE petid = 1234
     * $query->filterByPetid(array(12, 34)); // WHERE petid IN (12, 34)
     * $query->filterByPetid(array('min' => 12)); // WHERE petid > 12
     * </code>
     *
     * @see       filterByPetitions()
     *
     * @param     mixed $petid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByPetid($petid = null, $comparison = null)
    {
        if (is_array($petid)) {
            $useMinMax = false;
            if (isset($petid['min'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_PETID, $petid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($petid['max'])) {
                $this->addUsingAlias(SignaturesTableMap::COL_PETID, $petid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SignaturesTableMap::COL_PETID, $petid, $comparison);
    }

    /**
     * Filter the query by a related \pet4web\Users object
     *
     * @param \pet4web\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \pet4web\Users) {
            return $this
                ->addUsingAlias(SignaturesTableMap::COL_USERID, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SignaturesTableMap::COL_USERID, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
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
     * Filter the query by a related \pet4web\Petitions object
     *
     * @param \pet4web\Petitions|ObjectCollection $petitions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSignaturesQuery The current query, for fluid interface
     */
    public function filterByPetitions($petitions, $comparison = null)
    {
        if ($petitions instanceof \pet4web\Petitions) {
            return $this
                ->addUsingAlias(SignaturesTableMap::COL_PETID, $petitions->getId(), $comparison);
        } elseif ($petitions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SignaturesTableMap::COL_PETID, $petitions->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPetitions() only accepts arguments of type \pet4web\Petitions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Petitions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function joinPetitions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Petitions');

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
            $this->addJoinObject($join, 'Petitions');
        }

        return $this;
    }

    /**
     * Use the Petitions relation Petitions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \pet4web\PetitionsQuery A secondary query class using the current class as primary query
     */
    public function usePetitionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPetitions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Petitions', '\pet4web\PetitionsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSignatures $signatures Object to remove from the list of results
     *
     * @return $this|ChildSignaturesQuery The current query, for fluid interface
     */
    public function prune($signatures = null)
    {
        if ($signatures) {
            $this->addUsingAlias(SignaturesTableMap::COL_ID, $signatures->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the signatures table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SignaturesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SignaturesTableMap::clearInstancePool();
            SignaturesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SignaturesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SignaturesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SignaturesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SignaturesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SignaturesQuery
