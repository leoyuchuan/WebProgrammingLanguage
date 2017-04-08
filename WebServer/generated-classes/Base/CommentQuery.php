<?php

namespace Base;

use \Comment as ChildComment;
use \CommentQuery as ChildCommentQuery;
use \Exception;
use \PDO;
use Map\CommentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'COMMENT' table.
 *
 *
 *
 * @method     ChildCommentQuery orderByNewsId($order = Criteria::ASC) Order by the news_id column
 * @method     ChildCommentQuery orderByCommentId($order = Criteria::ASC) Order by the comment_id column
 * @method     ChildCommentQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildCommentQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method     ChildCommentQuery orderByUsername($order = Criteria::ASC) Order by the username column
 *
 * @method     ChildCommentQuery groupByNewsId() Group by the news_id column
 * @method     ChildCommentQuery groupByCommentId() Group by the comment_id column
 * @method     ChildCommentQuery groupByContent() Group by the content column
 * @method     ChildCommentQuery groupByDate() Group by the date column
 * @method     ChildCommentQuery groupByUsername() Group by the username column
 *
 * @method     ChildCommentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComment findOne(ConnectionInterface $con = null) Return the first ChildComment matching the query
 * @method     ChildComment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComment matching the query, or a new ChildComment object populated from the query conditions when no match is found
 *
 * @method     ChildComment findOneByNewsId(int $news_id) Return the first ChildComment filtered by the news_id column
 * @method     ChildComment findOneByCommentId(int $comment_id) Return the first ChildComment filtered by the comment_id column
 * @method     ChildComment findOneByContent(string $content) Return the first ChildComment filtered by the content column
 * @method     ChildComment findOneByDate(string $date) Return the first ChildComment filtered by the date column
 * @method     ChildComment findOneByUsername(string $username) Return the first ChildComment filtered by the username column
 *
 * @method     ChildComment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComment objects based on current ModelCriteria
 * @method     ChildComment[]|ObjectCollection findByNewsId(int $news_id) Return ChildComment objects filtered by the news_id column
 * @method     ChildComment[]|ObjectCollection findByCommentId(int $comment_id) Return ChildComment objects filtered by the comment_id column
 * @method     ChildComment[]|ObjectCollection findByContent(string $content) Return ChildComment objects filtered by the content column
 * @method     ChildComment[]|ObjectCollection findByDate(string $date) Return ChildComment objects filtered by the date column
 * @method     ChildComment[]|ObjectCollection findByUsername(string $username) Return ChildComment objects filtered by the username column
 * @method     ChildComment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommentQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\CommentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'us_topspace', $modelName = '\\Comment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommentQuery) {
            return $criteria;
        }
        $query = new ChildCommentQuery();
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
     * @param array[$news_id, $comment_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildComment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CommentTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommentTableMap::DATABASE_NAME);
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
     * @return ChildComment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT news_id, comment_id, content, date, username FROM COMMENT WHERE news_id = :p0 AND comment_id = :p1';
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
            /** @var ChildComment $obj */
            $obj = new ChildComment();
            $obj->hydrate($row);
            CommentTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildComment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CommentTableMap::COL_NEWS_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CommentTableMap::COL_COMMENT_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CommentTableMap::COL_NEWS_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CommentTableMap::COL_COMMENT_ID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByNewsId($newsId = null, $comparison = null)
    {
        if (is_array($newsId)) {
            $useMinMax = false;
            if (isset($newsId['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_NEWS_ID, $newsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newsId['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_NEWS_ID, $newsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_NEWS_ID, $newsId, $comparison);
    }

    /**
     * Filter the query on the comment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentId(1234); // WHERE comment_id = 1234
     * $query->filterByCommentId(array(12, 34)); // WHERE comment_id IN (12, 34)
     * $query->filterByCommentId(array('min' => 12)); // WHERE comment_id > 12
     * </code>
     *
     * @param     mixed $commentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByCommentId($commentId = null, $comparison = null)
    {
        if (is_array($commentId)) {
            $useMinMax = false;
            if (isset($commentId['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_COMMENT_ID, $commentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($commentId['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_COMMENT_ID, $commentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_COMMENT_ID, $commentId, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CommentTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_DATE, $date, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CommentTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildComment $comment Object to remove from the list of results
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function prune($comment = null)
    {
        if ($comment) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CommentTableMap::COL_NEWS_ID), $comment->getNewsId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CommentTableMap::COL_COMMENT_ID), $comment->getCommentId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the COMMENT table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommentTableMap::clearInstancePool();
            CommentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CommentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CommentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommentQuery
