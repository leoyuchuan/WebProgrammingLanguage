<?php

namespace Base;

use \Roaster as ChildRoaster;
use \RoasterQuery as ChildRoasterQuery;
use \Exception;
use \PDO;
use Map\RoasterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ROASTER' table.
 *
 *
 *
 * @method     ChildRoasterQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildRoasterQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildRoasterQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildRoasterQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildRoasterQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildRoasterQuery orderByHeight($order = Criteria::ASC) Order by the height column
 * @method     ChildRoasterQuery orderByBornDate($order = Criteria::ASC) Order by the born_date column
 * @method     ChildRoasterQuery orderByBornPlace($order = Criteria::ASC) Order by the born_place column
 * @method     ChildRoasterQuery orderByCollege($order = Criteria::ASC) Order by the college column
 * @method     ChildRoasterQuery orderByTeamId($order = Criteria::ASC) Order by the team_id column
 *
 * @method     ChildRoasterQuery groupByPlayerId() Group by the player_id column
 * @method     ChildRoasterQuery groupByFirstName() Group by the first_name column
 * @method     ChildRoasterQuery groupByLastName() Group by the last_name column
 * @method     ChildRoasterQuery groupByGender() Group by the gender column
 * @method     ChildRoasterQuery groupByWeight() Group by the weight column
 * @method     ChildRoasterQuery groupByHeight() Group by the height column
 * @method     ChildRoasterQuery groupByBornDate() Group by the born_date column
 * @method     ChildRoasterQuery groupByBornPlace() Group by the born_place column
 * @method     ChildRoasterQuery groupByCollege() Group by the college column
 * @method     ChildRoasterQuery groupByTeamId() Group by the team_id column
 *
 * @method     ChildRoasterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRoasterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRoasterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRoaster findOne(ConnectionInterface $con = null) Return the first ChildRoaster matching the query
 * @method     ChildRoaster findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRoaster matching the query, or a new ChildRoaster object populated from the query conditions when no match is found
 *
 * @method     ChildRoaster findOneByPlayerId(int $player_id) Return the first ChildRoaster filtered by the player_id column
 * @method     ChildRoaster findOneByFirstName(string $first_name) Return the first ChildRoaster filtered by the first_name column
 * @method     ChildRoaster findOneByLastName(string $last_name) Return the first ChildRoaster filtered by the last_name column
 * @method     ChildRoaster findOneByGender(string $gender) Return the first ChildRoaster filtered by the gender column
 * @method     ChildRoaster findOneByWeight(string $weight) Return the first ChildRoaster filtered by the weight column
 * @method     ChildRoaster findOneByHeight(string $height) Return the first ChildRoaster filtered by the height column
 * @method     ChildRoaster findOneByBornDate(string $born_date) Return the first ChildRoaster filtered by the born_date column
 * @method     ChildRoaster findOneByBornPlace(string $born_place) Return the first ChildRoaster filtered by the born_place column
 * @method     ChildRoaster findOneByCollege(string $college) Return the first ChildRoaster filtered by the college column
 * @method     ChildRoaster findOneByTeamId(int $team_id) Return the first ChildRoaster filtered by the team_id column
 *
 * @method     ChildRoaster[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRoaster objects based on current ModelCriteria
 * @method     ChildRoaster[]|ObjectCollection findByPlayerId(int $player_id) Return ChildRoaster objects filtered by the player_id column
 * @method     ChildRoaster[]|ObjectCollection findByFirstName(string $first_name) Return ChildRoaster objects filtered by the first_name column
 * @method     ChildRoaster[]|ObjectCollection findByLastName(string $last_name) Return ChildRoaster objects filtered by the last_name column
 * @method     ChildRoaster[]|ObjectCollection findByGender(string $gender) Return ChildRoaster objects filtered by the gender column
 * @method     ChildRoaster[]|ObjectCollection findByWeight(string $weight) Return ChildRoaster objects filtered by the weight column
 * @method     ChildRoaster[]|ObjectCollection findByHeight(string $height) Return ChildRoaster objects filtered by the height column
 * @method     ChildRoaster[]|ObjectCollection findByBornDate(string $born_date) Return ChildRoaster objects filtered by the born_date column
 * @method     ChildRoaster[]|ObjectCollection findByBornPlace(string $born_place) Return ChildRoaster objects filtered by the born_place column
 * @method     ChildRoaster[]|ObjectCollection findByCollege(string $college) Return ChildRoaster objects filtered by the college column
 * @method     ChildRoaster[]|ObjectCollection findByTeamId(int $team_id) Return ChildRoaster objects filtered by the team_id column
 * @method     ChildRoaster[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RoasterQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\RoasterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\Roaster', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRoasterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRoasterQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRoasterQuery) {
            return $criteria;
        }
        $query = new ChildRoasterQuery();
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
     * @return ChildRoaster|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RoasterTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RoasterTableMap::DATABASE_NAME);
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
     * @return ChildRoaster A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT player_id, first_name, last_name, gender, weight, height, born_date, born_place, college, team_id FROM ROASTER WHERE player_id = :p0';
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
            /** @var ChildRoaster $obj */
            $obj = new ChildRoaster();
            $obj->hydrate($row);
            RoasterTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRoaster|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastName)) {
                $lastName = str_replace('*', '%', $lastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender('fooValue');   // WHERE gender = 'fooValue'
     * $query->filterByGender('%fooValue%'); // WHERE gender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gender The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gender)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gender)) {
                $gender = str_replace('*', '%', $gender);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the weight column
     *
     * Example usage:
     * <code>
     * $query->filterByWeight(1234); // WHERE weight = 1234
     * $query->filterByWeight(array(12, 34)); // WHERE weight IN (12, 34)
     * $query->filterByWeight(array('min' => 12)); // WHERE weight > 12
     * </code>
     *
     * @param     mixed $weight The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (is_array($weight)) {
            $useMinMax = false;
            if (isset($weight['min'])) {
                $this->addUsingAlias(RoasterTableMap::COL_WEIGHT, $weight['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weight['max'])) {
                $this->addUsingAlias(RoasterTableMap::COL_WEIGHT, $weight['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_WEIGHT, $weight, $comparison);
    }

    /**
     * Filter the query on the height column
     *
     * Example usage:
     * <code>
     * $query->filterByHeight(1234); // WHERE height = 1234
     * $query->filterByHeight(array(12, 34)); // WHERE height IN (12, 34)
     * $query->filterByHeight(array('min' => 12)); // WHERE height > 12
     * </code>
     *
     * @param     mixed $height The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByHeight($height = null, $comparison = null)
    {
        if (is_array($height)) {
            $useMinMax = false;
            if (isset($height['min'])) {
                $this->addUsingAlias(RoasterTableMap::COL_HEIGHT, $height['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($height['max'])) {
                $this->addUsingAlias(RoasterTableMap::COL_HEIGHT, $height['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_HEIGHT, $height, $comparison);
    }

    /**
     * Filter the query on the born_date column
     *
     * Example usage:
     * <code>
     * $query->filterByBornDate('2011-03-14'); // WHERE born_date = '2011-03-14'
     * $query->filterByBornDate('now'); // WHERE born_date = '2011-03-14'
     * $query->filterByBornDate(array('max' => 'yesterday')); // WHERE born_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $bornDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByBornDate($bornDate = null, $comparison = null)
    {
        if (is_array($bornDate)) {
            $useMinMax = false;
            if (isset($bornDate['min'])) {
                $this->addUsingAlias(RoasterTableMap::COL_BORN_DATE, $bornDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bornDate['max'])) {
                $this->addUsingAlias(RoasterTableMap::COL_BORN_DATE, $bornDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_BORN_DATE, $bornDate, $comparison);
    }

    /**
     * Filter the query on the born_place column
     *
     * Example usage:
     * <code>
     * $query->filterByBornPlace('fooValue');   // WHERE born_place = 'fooValue'
     * $query->filterByBornPlace('%fooValue%'); // WHERE born_place LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bornPlace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByBornPlace($bornPlace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bornPlace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bornPlace)) {
                $bornPlace = str_replace('*', '%', $bornPlace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_BORN_PLACE, $bornPlace, $comparison);
    }

    /**
     * Filter the query on the college column
     *
     * Example usage:
     * <code>
     * $query->filterByCollege('fooValue');   // WHERE college = 'fooValue'
     * $query->filterByCollege('%fooValue%'); // WHERE college LIKE '%fooValue%'
     * </code>
     *
     * @param     string $college The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByCollege($college = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($college)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $college)) {
                $college = str_replace('*', '%', $college);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_COLLEGE, $college, $comparison);
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
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(RoasterTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(RoasterTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoasterTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRoaster $roaster Object to remove from the list of results
     *
     * @return $this|ChildRoasterQuery The current query, for fluid interface
     */
    public function prune($roaster = null)
    {
        if ($roaster) {
            $this->addUsingAlias(RoasterTableMap::COL_PLAYER_ID, $roaster->getPlayerId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ROASTER table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoasterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RoasterTableMap::clearInstancePool();
            RoasterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RoasterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RoasterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RoasterTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RoasterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RoasterQuery
