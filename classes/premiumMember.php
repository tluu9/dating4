<?php

/**
 * Class PremiumMember
 * @author Trang
 * @version 1.0
 */
class PremiumMember extends Member
{
    /**
     * @var inDoorInterests, outDoorInterests
     */
    private $_inDoorInterests = array();

    private $_outDoorInterests = array();


    /**
     * PremiumMember constructor inheritance from parent class Member
     * @param $fname
     * @param $lname
     * @param $age
     * @param $gender
     * @param $phone
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
    }

    //Setter and getter
    /**
     * get indoor activities
     * @return inDoorInterests
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }
    /**
     * @param $inDoorInterests
     * @return void
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * get outdoor activities
     * @return outDoorInterests
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param $outDoorInterests
     * @return void
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}
