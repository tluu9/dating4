<?php

/**
 * Class Member
 */
class Member
{
    /**
     * @var fname, lname, age, gender, phone, email, state, seeking, bio
     */
    //declare attribute
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor.
     * @param $fname
     * @param $lname
     * @param $age
     * @param $gender
     * @param $phone
     */
    //parameterized constructor
    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    //Setter and getter

    /**
     * @return first name String
     */
    public function getFname()
    {
        return $this->_fname;
    }
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return last name String
     */
    public function getLname()
    {
        return $this->_lname;
    }
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return age integer
     */
    public function getAge()
    {
        return $this->_age;
    }
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return gender
     */
    public function getGender()
    {
        return $this->_gender;
    }
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return phone number integer
     */
    public function getPhone()
    {
        return $this->_phone;
    }
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return email
     */
    public function getEmail()
    {
        return $this->_email;
    }
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return state
     */
    public function getState()
    {
        return $this->_state;
    }
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * @return seeking
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * @return biography string
     */
    public function getBio()
    {
        return $this->_bio;
    }
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
}



