<?php

namespace Map;

use \Roaster;
use \RoasterQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'ROASTER' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RoasterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.RoasterTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'us_topspace';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ROASTER';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Roaster';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Roaster';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the player_id field
     */
    const COL_PLAYER_ID = 'ROASTER.player_id';

    /**
     * the column name for the first_name field
     */
    const COL_FIRST_NAME = 'ROASTER.first_name';

    /**
     * the column name for the last_name field
     */
    const COL_LAST_NAME = 'ROASTER.last_name';

    /**
     * the column name for the gender field
     */
    const COL_GENDER = 'ROASTER.gender';

    /**
     * the column name for the weight field
     */
    const COL_WEIGHT = 'ROASTER.weight';

    /**
     * the column name for the height field
     */
    const COL_HEIGHT = 'ROASTER.height';

    /**
     * the column name for the born_date field
     */
    const COL_BORN_DATE = 'ROASTER.born_date';

    /**
     * the column name for the born_place field
     */
    const COL_BORN_PLACE = 'ROASTER.born_place';

    /**
     * the column name for the college field
     */
    const COL_COLLEGE = 'ROASTER.college';

    /**
     * the column name for the team_id field
     */
    const COL_TEAM_ID = 'ROASTER.team_id';

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
        self::TYPE_PHPNAME       => array('PlayerId', 'FirstName', 'LastName', 'Gender', 'Weight', 'Height', 'BornDate', 'BornPlace', 'College', 'TeamId', ),
        self::TYPE_CAMELNAME     => array('playerId', 'firstName', 'lastName', 'gender', 'weight', 'height', 'bornDate', 'bornPlace', 'college', 'teamId', ),
        self::TYPE_COLNAME       => array(RoasterTableMap::COL_PLAYER_ID, RoasterTableMap::COL_FIRST_NAME, RoasterTableMap::COL_LAST_NAME, RoasterTableMap::COL_GENDER, RoasterTableMap::COL_WEIGHT, RoasterTableMap::COL_HEIGHT, RoasterTableMap::COL_BORN_DATE, RoasterTableMap::COL_BORN_PLACE, RoasterTableMap::COL_COLLEGE, RoasterTableMap::COL_TEAM_ID, ),
        self::TYPE_FIELDNAME     => array('player_id', 'first_name', 'last_name', 'gender', 'weight', 'height', 'born_date', 'born_place', 'college', 'team_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PlayerId' => 0, 'FirstName' => 1, 'LastName' => 2, 'Gender' => 3, 'Weight' => 4, 'Height' => 5, 'BornDate' => 6, 'BornPlace' => 7, 'College' => 8, 'TeamId' => 9, ),
        self::TYPE_CAMELNAME     => array('playerId' => 0, 'firstName' => 1, 'lastName' => 2, 'gender' => 3, 'weight' => 4, 'height' => 5, 'bornDate' => 6, 'bornPlace' => 7, 'college' => 8, 'teamId' => 9, ),
        self::TYPE_COLNAME       => array(RoasterTableMap::COL_PLAYER_ID => 0, RoasterTableMap::COL_FIRST_NAME => 1, RoasterTableMap::COL_LAST_NAME => 2, RoasterTableMap::COL_GENDER => 3, RoasterTableMap::COL_WEIGHT => 4, RoasterTableMap::COL_HEIGHT => 5, RoasterTableMap::COL_BORN_DATE => 6, RoasterTableMap::COL_BORN_PLACE => 7, RoasterTableMap::COL_COLLEGE => 8, RoasterTableMap::COL_TEAM_ID => 9, ),
        self::TYPE_FIELDNAME     => array('player_id' => 0, 'first_name' => 1, 'last_name' => 2, 'gender' => 3, 'weight' => 4, 'height' => 5, 'born_date' => 6, 'born_place' => 7, 'college' => 8, 'team_id' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('ROASTER');
        $this->setPhpName('Roaster');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Roaster');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('player_id', 'PlayerId', 'INTEGER', true, 32, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 32, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 32, null);
        $this->addColumn('gender', 'Gender', 'VARCHAR', false, 6, null);
        $this->addColumn('weight', 'Weight', 'DECIMAL', false, 6, null);
        $this->addColumn('height', 'Height', 'DECIMAL', false, 6, null);
        $this->addColumn('born_date', 'BornDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('born_place', 'BornPlace', 'VARCHAR', false, 255, null);
        $this->addColumn('college', 'College', 'VARCHAR', false, 128, null);
        $this->addColumn('team_id', 'TeamId', 'INTEGER', false, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? RoasterTableMap::CLASS_DEFAULT : RoasterTableMap::OM_CLASS;
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
     * @return array           (Roaster object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RoasterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RoasterTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RoasterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RoasterTableMap::OM_CLASS;
            /** @var Roaster $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RoasterTableMap::addInstanceToPool($obj, $key);
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
            $key = RoasterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RoasterTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Roaster $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RoasterTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RoasterTableMap::COL_PLAYER_ID);
            $criteria->addSelectColumn(RoasterTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(RoasterTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(RoasterTableMap::COL_GENDER);
            $criteria->addSelectColumn(RoasterTableMap::COL_WEIGHT);
            $criteria->addSelectColumn(RoasterTableMap::COL_HEIGHT);
            $criteria->addSelectColumn(RoasterTableMap::COL_BORN_DATE);
            $criteria->addSelectColumn(RoasterTableMap::COL_BORN_PLACE);
            $criteria->addSelectColumn(RoasterTableMap::COL_COLLEGE);
            $criteria->addSelectColumn(RoasterTableMap::COL_TEAM_ID);
        } else {
            $criteria->addSelectColumn($alias . '.player_id');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.gender');
            $criteria->addSelectColumn($alias . '.weight');
            $criteria->addSelectColumn($alias . '.height');
            $criteria->addSelectColumn($alias . '.born_date');
            $criteria->addSelectColumn($alias . '.born_place');
            $criteria->addSelectColumn($alias . '.college');
            $criteria->addSelectColumn($alias . '.team_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(RoasterTableMap::DATABASE_NAME)->getTable(RoasterTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RoasterTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RoasterTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RoasterTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Roaster or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Roaster object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RoasterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Roaster) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RoasterTableMap::DATABASE_NAME);
            $criteria->add(RoasterTableMap::COL_PLAYER_ID, (array) $values, Criteria::IN);
        }

        $query = RoasterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RoasterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RoasterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ROASTER table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RoasterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Roaster or Criteria object.
     *
     * @param mixed               $criteria Criteria or Roaster object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoasterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Roaster object
        }


        // Set the correct dbName
        $query = RoasterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RoasterTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RoasterTableMap::buildTableMap();
