<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp extends Model 
{

    protected $connection = 'mysql';
    protected $table = 'sp';
    public $timestamps = true;

    public function SpLogsLatest()
    {
        return $this->hasOne('App\Sp_logs', 'sp_id', 'sp_id');
    }

    public function Sp_logs()
    {
        return $this->hasMany('App\Sp_logs', 'sp_id', 'sp_id');
    }

    public function Sp_batch()
    {
        return $this->hasOne('App\Sp_batch', 'id', 'sp_batch');
    }

    public function Sp_cycle()
    {
        return $this->hasOne('App\Sp_cycle', 'id', 'sp_cycle');
    }

    public function Assigned_grouping()
    {
        return $this->hasMany('App\Assigned_grouping', 'sp_grouping_id', 'sp_groupings');
    }

    public function Assigned_sp()
    {
        return $this->hasMany('App\Assigned_sp', 'sp_id', 'sp_id');
    }

    public function Sp_groupings()
    {
        return $this->hasOne('App\Sp_groupings', 'id', 'sp_groupings');
    }

    public function Sp_category()
    {
        return $this->hasOne('App\Sp_category', 'id', 'sp_category');
    }

    public function Sp_type()
    {
        return $this->hasOne('App\Sp_type', 'id', 'sp_type');
    }

    public function Cadt()
    {
        return $this->hasOne('App\Cadt', 'sp_id', 'sp_id');
    }

    public function Sp_pmr()
    {
        return $this->hasMany('App\Sp_pmr', 'sp_id', 'sp_id');
    }

    // // 2015 START
    public function CMFS_kalahi_2015_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2015_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2015_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2015_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2015 END

    // // 2016 START
    public function CMFS_kalahi_2016_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2016_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2016_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2016 END



    // // 2017 START
    public function CMFS_kalahi_2017_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2017_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2017_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2017_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2017 END


    // // 2018 START
    public function CMFS_kalahi_2018_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2018_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2016_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2018_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2018_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2018 END


    // // 2019 START
    public function CMFS_kalahi_2019_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_NCDDP_SP', 'sp_id', 'sp_id');
    }
    public function CMFS_kalahi_2019_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2019_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2019_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    public function CMFS_kalahi_2019_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2019_BUB_RFR', 'sp_bub_id', 'sp_id');
    }
    // // 2019 START

    // // 2020 START
    public function CMFS_kalahi_2020_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2020_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2020_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2020_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2020 END


    // // 2021 START
    public function CMFS_kalahi_2021_BUB_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_BUB_SP', 'id', 'sp_id');
    }

    public function CMFS_kalahi_2021_NCDDP_SP()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_NCDDP_SP', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_BUB_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_BUB_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_BUB_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_BUB_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_BUB_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_BUB_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_NCDDP_SPCR()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_NCDDP_SPCR', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_NCDDP_SPCR_FINDINGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_NCDDP_SPCR_LOGS()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_NCDDP_SPCR_LOGS', 'sp_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_BUB_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_BUB_RFR', 'sp_bub_id', 'sp_id');
    }

    public function CMFS_kalahi_2021_NCDDP_RFR()
    {
        return $this->hasOne('App\CMFS_kalahi_2021_NCDDP_RFR', 'sp_id', 'sp_id');
    }
    // // 2021 END










}
