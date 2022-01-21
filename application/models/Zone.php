<?php

namespace Model;

/**
 * Description of Zones
 *
 * @author Raj
 */
use Database\Db;

class Zone extends Db {

    public function __construct() {
        parent::__construct();
    }

    public function getTable() {
        return CENTRAL_ZONE;
    }

    public function getZone() {
        $ZoneSql = $this->executeSql("select z.id,z.name from " . $this->getTable() . " as z  where z.status='1' ",[]);
        return $ZoneSql;
    }

    public function getzoneByRaId($stateid) {
        if(!empty($stateid)) {
        $ztds = $this->executeSql("select z.id,z.name from " . $this->getTable() . " as z left join sfa_zone_state_city_mapping as bud on bud.zone_id=z.id where bud.state_id in(" . $stateid . ") group by z.id",array());
        } else {
            $ztds=[];
        }
        return $ztds;
    }

}
