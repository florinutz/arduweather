<?php
namespace Flo;

use Cmfcmf\OpenWeatherMap;
use \Doctrine\DBAL\Connection as DBALConnection;

class RecommenderService
{
    /** @var DBALConnection */
    protected $db;

    /** @var array */
    protected $latestAverages;

    /**
     * @var OpenWeatherMap
     */
    protected $owm;

    /**
     * @param DBALConnection $db
     */
    public function __construct(DBALConnection $db, OpenWeatherMap $owm)
    {
        $this->db = $db;
        $this->owm = $owm;
    }

    /**
     * @return boolean
     */
    public function shouldWaterThePlants()
    {
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->db->fetchAssoc("SELECT count(*) as c FROM sensor")['c'];
    }

    /**
     * @return float
     */
    public function getTodayAverageGroundHumidity()
    {
        return $this->fetchLatestAverages()[0]['average_humidity_ground'];
    }

    /**
     * @return float
     */
    public function getTodayAverageTemperature()
    {
        return $this->fetchLatestAverages()[0]['average_temperature'];
    }

    /**
     * @return float
     */
    public function getYesterdayAverageGroundHumidity()
    {
        if (!isset($this->fetchLatestAverages()[1])) {
            return false;
        }
        return $this->fetchLatestAverages()[1]['average_humidity_ground'];
    }

    /**
     * @return float
     */
    public function getYesterdayAverageTemperature()
    {
        if (!isset($this->fetchLatestAverages()[1])) {
            return false;
        }
        return $this->fetchLatestAverages()[1]['average_temperature'];
    }

    /**
     * @return int
     */
    public function getCurrentLight()
    {
        return (int) $this->db->fetchAssoc("SELECT light as val FROM sensor order by created_at desc limit 1")['c'];
    }

    /**
     * @return int
     */
    public function getCurrentGroundHumidity()
    {
        return (int) $this->db->fetchAssoc("SELECT humidity_ground as val FROM sensor order by created_at desc limit 1")['c'];
    }

    /**
     * @return int
     */
    public function getCurrentAirHumidity()
    {
        return (int) $this->db->fetchAssoc("SELECT humidity_air as val FROM sensor order by created_at desc limit 1")['c'];
    }

    /**
     * @return int
     */
    public function getCurrentTemperature()
    {
        return (int) $this->db->fetchAssoc("SELECT temperature as val FROM sensor order by created_at desc limit 1")['c'];
    }

    /**
     * @return int[]
     */
    public function toArray()
    {
        return [
            'count' => (int) $this->getCount(),
            'today_average_ground_humidity' => round($this->getTodayAverageGroundHumidity()),
            'today_average_temperature' => round($this->getTodayAverageTemperature()),
            'yesterday_average_ground_humidity' => round($this->getYesterdayAverageGroundHumidity()),
            'yesterday_average_temperature' => round($this->getYesterdayAverageTemperature())
        ];
    }

    /**
     * @return float[]
     */
    protected function fetchLatestAverages()
    {
        if ($this->latestAverages) {
            return $this->latestAverages;
        }

        return $this->latestAverages = $this->db->fetchAll("
            SELECT AVG( s.humidity_ground )  AS average_humidity_ground
             , AVG( s.temperature )      AS average_temperature
             , CASE DATE( s.created_at )
                 WHEN CURRENT_DATE THEN
                   'today'
                 WHEN DATE( CURRENT_DATE, '-1 days' ) THEN
                   'yesterday'
                 ELSE
                   'day out of timerange'
               END                       AS day
            FROM sensor AS s
            WHERE DATE( s.created_at ) BETWEEN DATE( CURRENT_DATE, '-1 days' ) AND CURRENT_DATE
            GROUP BY DATE( s.created_at );
        ");
    }

}
