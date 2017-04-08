<?php

namespace Base;

use \Subscribe as ChildSubscribe;
use \SubscribeQuery as ChildSubscribeQuery;
use \Exception;
use \PDO;
use Map\SubscribeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'SUBSCRIBE' table.
 *
 *
 *
 * @method     ChildSubscribeQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildSubscribeQuery orderByTeamId($order = Criteria::ASC) Order by the team_id column
 *
 * @method     ChildSubscribeQuery groupByUsername() Group by the username column
 * @method     ChildSubscribeQuery groupByTeamId() Group by the team_id column
 *
 * @method     ChildSubscribeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubscribeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubscribeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubscribe findOne(ConnectionInterface $con = null) Return the first ChildSubscribe matching the query
 * @method     ChildSubscribe findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubscribe matching the query, or a new ChildSubscribe object populated from the query conditions when no match is found
 *
 * @method     ChildSubscribe findOneByUsername(string $username) Return the first ChildSubscribe filtered by the username column
 * @method     ChildSubscribe findOneByTeamId(int $team_id) Return the first ChildSubscribe filtered by the team_id column
 *
 * @method     ChildSubscribe[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSubscribe objects based on current ModelCriteria
 * @method     ChildSubscribe[]|ObjectCollection findByUsername(string $username) Return ChildSubscribe objects filtered by the username column
 * @method     ChildSubscribe[]|ObjectCollection findByTeamId(int $team_id) Return ChildSubscribe objects filtered by the team_id column
 * @method     ChildSubscribe[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SubscribeQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\SubscribeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\Subscribe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubscribeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubscribeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSubscribeQuery) {
            return $criteria;
        }
        $query = new ChildSubscribeQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$username, $team_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSubscribe|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SubscribeTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubscribeTableMap::DATABASE_NAME);
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
     * @return ChildSubscribe A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT username, team_id FROM SUBSCRIBE WHERE username = :p0 AND team_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSubscribe $obj */
            $obj = new ChildSubscribe();
            $obj->hydrate($row);
            SubscribeTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSubscribe|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildSubscribeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SubscribeTableMap::COL_USERNAME, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SubscribeTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSubscribeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SubscribeTableMap::COL_USERNAME, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SubscribeTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscribeQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SubscribeTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the team_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamId(1234); // WHERE team_id = 1234
     * $query->filterByTeamId(array(12, 34)); // WHERE team_id IN (12, 34)
     * $query->filterByTeamId(array('min' => 12)); // WHERE team_id > 12
     * </code>
     *
     * @param     mixed $teamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubscribeQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(SubscribeTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(SubscribeTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubscribeTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSubscribe $subscribe Object to remove from the list of results
     *
     * @return $this|ChildSubscribeQuery The current query, for fluid interface
     */
    public function prune($subscribe = null)
    {
        if ($subscribe) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SubscribeTableMap::COL_USERNAME), $subscribe->getUsername(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SubscribeTableMap::COL_TEAM_ID), $subscribe->getTeamId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the SUBSCRIBE table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscribeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SubscribeTableMap::clearInstancePool();
            SubscribeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SubscribeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubscribeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SubscribeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SubscribeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SubscribeQuery
