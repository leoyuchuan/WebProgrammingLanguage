<?php

namespace Base;

use \PlayerInNews as ChildPlayerInNews;
use \PlayerInNewsQuery as ChildPlayerInNewsQuery;
use \Exception;
use \PDO;
use Map\PlayerInNewsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PLAYER_IN_NEWS' table.
 *
 *
 *
 * @method     ChildPlayerInNewsQuery orderByNewsId($order = Criteria::ASC) Order by the news_id column
 * @method     ChildPlayerInNewsQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 *
 * @method     ChildPlayerInNewsQuery groupByNewsId() Group by the news_id column
 * @method     ChildPlayerInNewsQuery groupByPlayerId() Group by the player_id column
 *
 * @method     ChildPlayerInNewsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerInNewsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerInNewsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerInNews findOne(ConnectionInterface $con = null) Return the first ChildPlayerInNews matching the query
 * @method     ChildPlayerInNews findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayerInNews matching the query, or a new ChildPlayerInNews object populated from the query conditions when no match is found
 *
 * @method     ChildPlayerInNews findOneByNewsId(int $news_id) Return the first ChildPlayerInNews filtered by the news_id column
 * @method     ChildPlayerInNews findOneByPlayerId(int $player_id) Return the first ChildPlayerInNews filtered by the player_id column
 *
 * @method     ChildPlayerInNews[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayerInNews objects based on current ModelCriteria
 * @method     ChildPlayerInNews[]|ObjectCollection findByNewsId(int $news_id) Return ChildPlayerInNews objects filtered by the news_id column
 * @method     ChildPlayerInNews[]|ObjectCollection findByPlayerId(int $player_id) Return ChildPlayerInNews objects filtered by the player_id column
 * @method     ChildPlayerInNews[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayerInNewsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\PlayerInNewsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\PlayerInNews', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayerInNewsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayerInNewsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayerInNewsQuery) {
            return $criteria;
        }
        $query = new ChildPlayerInNewsQuery();
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
     * @param array[$news_id, $player_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPlayerInNews|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PlayerInNewsTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayerInNewsTableMap::DATABASE_NAME);
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
     * @return ChildPlayerInNews A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT news_id, player_id FROM PLAYER_IN_NEWS WHERE news_id = :p0 AND player_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPlayerInNews $obj */
            $obj = new ChildPlayerInNews();
            $obj->hydrate($row);
            PlayerInNewsTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildPlayerInNews|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlayerInNewsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PlayerInNewsTableMap::COL_NEWS_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PlayerInNewsTableMap::COL_PLAYER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayerInNewsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PlayerInNewsTableMap::COL_NEWS_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PlayerInNewsTableMap::COL_PLAYER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the news_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNewsId(1234); // WHERE news_id = 1234
     * $query->filterByNewsId(array(12, 34)); // WHERE news_id IN (12, 34)
     * $query->filterByNewsId(array('min' => 12)); // WHERE news_id > 12
     * </code>
     *
     * @param     mixed $newsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerInNewsQuery The current query, for fluid interface
     */
    public function filterByNewsId($newsId = null, $comparison = null)
    {
        if (is_array($newsId)) {
            $useMinMax = false;
            if (isset($newsId['min'])) {
                $this->addUsingAlias(PlayerInNewsTableMap::COL_NEWS_ID, $newsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newsId['max'])) {
                $this->addUsingAlias(PlayerInNewsTableMap::COL_NEWS_ID, $newsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerInNewsTableMap::COL_NEWS_ID, $newsId, $comparison);
    }

    /**
     * Filter the query on the player_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayerId(1234); // WHERE player_id = 1234
     * $query->filterByPlayerId(array(12, 34)); // WHERE player_id IN (12, 34)
     * $query->filterByPlayerId(array('min' => 12)); // WHERE player_id > 12
     * </code>
     *
     * @param     mixed $playerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerInNewsQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(PlayerInNewsTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(PlayerInNewsTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerInNewsTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlayerInNews $playerInNews Object to remove from the list of results
     *
     * @return $this|ChildPlayerInNewsQuery The current query, for fluid interface
     */
    public function prune($playerInNews = null)
    {
        if ($playerInNews) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PlayerInNewsTableMap::COL_NEWS_ID), $playerInNews->getNewsId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PlayerInNewsTableMap::COL_PLAYER_ID), $playerInNews->getPlayerId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PLAYER_IN_NEWS table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerInNewsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayerInNewsTableMap::clearInstancePool();
            PlayerInNewsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerInNewsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayerInNewsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayerInNewsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayerInNewsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayerInNewsQuery
