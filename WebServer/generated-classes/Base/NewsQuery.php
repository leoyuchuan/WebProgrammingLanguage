<?php

namespace Base;

use \News as ChildNews;
use \NewsQuery as ChildNewsQuery;
use \Exception;
use \PDO;
use Map\NewsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'NEWS' table.
 *
 *
 *
 * @method     ChildNewsQuery orderByNewsId($order = Criteria::ASC) Order by the news_id column
 * @method     ChildNewsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildNewsQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildNewsQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method     ChildNewsQuery groupByNewsId() Group by the news_id column
 * @method     ChildNewsQuery groupByTitle() Group by the title column
 * @method     ChildNewsQuery groupByContent() Group by the content column
 * @method     ChildNewsQuery groupByDate() Group by the date column
 *
 * @method     ChildNewsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNewsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNewsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNews findOne(ConnectionInterface $con = null) Return the first ChildNews matching the query
 * @method     ChildNews findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNews matching the query, or a new ChildNews object populated from the query conditions when no match is found
 *
 * @method     ChildNews findOneByNewsId(int $news_id) Return the first ChildNews filtered by the news_id column
 * @method     ChildNews findOneByTitle(string $title) Return the first ChildNews filtered by the title column
 * @method     ChildNews findOneByContent(string $content) Return the first ChildNews filtered by the content column
 * @method     ChildNews findOneByDate(string $date) Return the first ChildNews filtered by the date column
 *
 * @method     ChildNews[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNews objects based on current ModelCriteria
 * @method     ChildNews[]|ObjectCollection findByNewsId(int $news_id) Return ChildNews objects filtered by the news_id column
 * @method     ChildNews[]|ObjectCollection findByTitle(string $title) Return ChildNews objects filtered by the title column
 * @method     ChildNews[]|ObjectCollection findByContent(string $content) Return ChildNews objects filtered by the content column
 * @method     ChildNews[]|ObjectCollection findByDate(string $date) Return ChildNews objects filtered by the date column
 * @method     ChildNews[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NewsQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\NewsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\News', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNewsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNewsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNewsQuery) {
            return $criteria;
        }
        $query = new ChildNewsQuery();
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
     * @return ChildNews|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NewsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NewsTableMap::DATABASE_NAME);
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
     * @return ChildNews A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT news_id, title, content, date FROM NEWS WHERE news_id = :p0';
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
            /** @var ChildNews $obj */
            $obj = new ChildNews();
            $obj->hydrate($row);
            NewsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildNews|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $keys, Criteria::IN);
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
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function filterByNewsId($newsId = null, $comparison = null)
    {
        if (is_array($newsId)) {
            $useMinMax = false;
            if (isset($newsId['min'])) {
                $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $newsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newsId['max'])) {
                $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $newsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $newsId, $comparison);
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
     * @return $this|ChildNewsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(NewsTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $content)) {
                $content = str_replace('*', '%', $content);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NewsTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(NewsTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(NewsTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNews $news Object to remove from the list of results
     *
     * @return $this|ChildNewsQuery The current query, for fluid interface
     */
    public function prune($news = null)
    {
        if ($news) {
            $this->addUsingAlias(NewsTableMap::COL_NEWS_ID, $news->getNewsId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the NEWS table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NewsTableMap::clearInstancePool();
            NewsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NewsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NewsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NewsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NewsQuery
