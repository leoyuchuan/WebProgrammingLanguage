<?php

namespace Base;

use \Game as ChildGame;
use \GameQuery as ChildGameQuery;
use \Exception;
use \PDO;
use Map\GameTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'GAME' table.
 *
 *
 *
 * @method     ChildGameQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildGameQuery orderByTeam1Id($order = Criteria::ASC) Order by the team1_id column
 * @method     ChildGameQuery orderByTeam2Id($order = Criteria::ASC) Order by the team2_id column
 * @method     ChildGameQuery orderByTeam1Score($order = Criteria::ASC) Order by the team1_score column
 * @method     ChildGameQuery orderByTeam2Score($order = Criteria::ASC) Order by the team2_score column
 * @method     ChildGameQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildGameQuery orderByTime($order = Criteria::ASC) Order by the time column
 * @method     ChildGameQuery orderByLocation($order = Criteria::ASC) Order by the location column
 *
 * @method     ChildGameQuery groupByGameId() Group by the game_id column
 * @method     ChildGameQuery groupByTeam1Id() Group by the team1_id column
 * @method     ChildGameQuery groupByTeam2Id() Group by the team2_id column
 * @method     ChildGameQuery groupByTeam1Score() Group by the team1_score column
 * @method     ChildGameQuery groupByTeam2Score() Group by the team2_score column
 * @method     ChildGameQuery groupByDate() Group by the date column
 * @method     ChildGameQuery groupByTime() Group by the time column
 * @method     ChildGameQuery groupByLocation() Group by the location column
 *
 * @method     ChildGameQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGame findOne(ConnectionInterface $con = null) Return the first ChildGame matching the query
 * @method     ChildGame findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGame matching the query, or a new ChildGame object populated from the query conditions when no match is found
 *
 * @method     ChildGame findOneByGameId(int $game_id) Return the first ChildGame filtered by the game_id column
 * @method     ChildGame findOneByTeam1Id(int $team1_id) Return the first ChildGame filtered by the team1_id column
 * @method     ChildGame findOneByTeam2Id(int $team2_id) Return the first ChildGame filtered by the team2_id column
 * @method     ChildGame findOneByTeam1Score(int $team1_score) Return the first ChildGame filtered by the team1_score column
 * @method     ChildGame findOneByTeam2Score(int $team2_score) Return the first ChildGame filtered by the team2_score column
 * @method     ChildGame findOneByDate(string $date) Return the first ChildGame filtered by the date column
 * @method     ChildGame findOneByTime(string $time) Return the first ChildGame filtered by the time column
 * @method     ChildGame findOneByLocation(string $location) Return the first ChildGame filtered by the location column
 *
 * @method     ChildGame[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGame objects based on current ModelCriteria
 * @method     ChildGame[]|ObjectCollection findByGameId(int $game_id) Return ChildGame objects filtered by the game_id column
 * @method     ChildGame[]|ObjectCollection findByTeam1Id(int $team1_id) Return ChildGame objects filtered by the team1_id column
 * @method     ChildGame[]|ObjectCollection findByTeam2Id(int $team2_id) Return ChildGame objects filtered by the team2_id column
 * @method     ChildGame[]|ObjectCollection findByTeam1Score(int $team1_score) Return ChildGame objects filtered by the team1_score column
 * @method     ChildGame[]|ObjectCollection findByTeam2Score(int $team2_score) Return ChildGame objects filtered by the team2_score column
 * @method     ChildGame[]|ObjectCollection findByDate(string $date) Return ChildGame objects filtered by the date column
 * @method     ChildGame[]|ObjectCollection findByTime(string $time) Return ChildGame objects filtered by the time column
 * @method     ChildGame[]|ObjectCollection findByLocation(string $location) Return ChildGame objects filtered by the location column
 * @method     ChildGame[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\GameQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\Game', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameQuery) {
            return $criteria;
        }
        $query = new ChildGameQuery();
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GameTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
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
     * @return ChildGame A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT game_id, team1_id, team2_id, team1_score, team2_score, date, time, location FROM GAME WHERE game_id = :p0';
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
            /** @var ChildGame $obj */
            $obj = new ChildGame();
            $obj->hydrate($row);
            GameTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameTableMap::COL_GAME_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameTableMap::COL_GAME_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the game_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGameId(1234); // WHERE game_id = 1234
     * $query->filterByGameId(array(12, 34)); // WHERE game_id IN (12, 34)
     * $query->filterByGameId(array('min' => 12)); // WHERE game_id > 12
     * </code>
     *
     * @param     mixed $gameId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(GameTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(GameTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query on the team1_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam1Id(1234); // WHERE team1_id = 1234
     * $query->filterByTeam1Id(array(12, 34)); // WHERE team1_id IN (12, 34)
     * $query->filterByTeam1Id(array('min' => 12)); // WHERE team1_id > 12
     * </code>
     *
     * @param     mixed $team1Id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTeam1Id($team1Id = null, $comparison = null)
    {
        if (is_array($team1Id)) {
            $useMinMax = false;
            if (isset($team1Id['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM1_ID, $team1Id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team1Id['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM1_ID, $team1Id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TEAM1_ID, $team1Id, $comparison);
    }

    /**
     * Filter the query on the team2_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam2Id(1234); // WHERE team2_id = 1234
     * $query->filterByTeam2Id(array(12, 34)); // WHERE team2_id IN (12, 34)
     * $query->filterByTeam2Id(array('min' => 12)); // WHERE team2_id > 12
     * </code>
     *
     * @param     mixed $team2Id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTeam2Id($team2Id = null, $comparison = null)
    {
        if (is_array($team2Id)) {
            $useMinMax = false;
            if (isset($team2Id['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM2_ID, $team2Id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team2Id['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM2_ID, $team2Id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TEAM2_ID, $team2Id, $comparison);
    }

    /**
     * Filter the query on the team1_score column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam1Score(1234); // WHERE team1_score = 1234
     * $query->filterByTeam1Score(array(12, 34)); // WHERE team1_score IN (12, 34)
     * $query->filterByTeam1Score(array('min' => 12)); // WHERE team1_score > 12
     * </code>
     *
     * @param     mixed $team1Score The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTeam1Score($team1Score = null, $comparison = null)
    {
        if (is_array($team1Score)) {
            $useMinMax = false;
            if (isset($team1Score['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM1_SCORE, $team1Score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team1Score['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM1_SCORE, $team1Score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TEAM1_SCORE, $team1Score, $comparison);
    }

    /**
     * Filter the query on the team2_score column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam2Score(1234); // WHERE team2_score = 1234
     * $query->filterByTeam2Score(array(12, 34)); // WHERE team2_score IN (12, 34)
     * $query->filterByTeam2Score(array('min' => 12)); // WHERE team2_score > 12
     * </code>
     *
     * @param     mixed $team2Score The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTeam2Score($team2Score = null, $comparison = null)
    {
        if (is_array($team2Score)) {
            $useMinMax = false;
            if (isset($team2Score['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM2_SCORE, $team2Score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team2Score['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TEAM2_SCORE, $team2Score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TEAM2_SCORE, $team2Score, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date > '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(GameTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(GameTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query on the time column
     *
     * Example usage:
     * <code>
     * $query->filterByTime('2011-03-14'); // WHERE time = '2011-03-14'
     * $query->filterByTime('now'); // WHERE time = '2011-03-14'
     * $query->filterByTime(array('max' => 'yesterday')); // WHERE time > '2011-03-13'
     * </code>
     *
     * @param     mixed $time The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TIME, $time, $comparison);
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%'); // WHERE location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $location)) {
                $location = str_replace('*', '%', $location);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGame $game Object to remove from the list of results
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function prune($game = null)
    {
        if ($game) {
            $this->addUsingAlias(GameTableMap::COL_GAME_ID, $game->getGameId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the GAME table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameTableMap::clearInstancePool();
            GameTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameQuery
