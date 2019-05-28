<?php
/**
 * Database class
 * Date: 20 May 2019
 */

/**
 * CREATE TABLE
 *
 * MEMBER
 * CREATE TABLE member (
    member_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fname varchar(40)NOT NULL,
    lname varchar(40)NOT NULL,
    age int(11) DEFAULT NULL,
    gender varchar(30)DEFAULT NULL,
    phone varchar(30) DEFAULT NULL,
    email varchar(50) DEFAULT NULL,
    state varchar(30) DEFAULT NULL,
    seeking varchar(30) DEFAULT NULL,
    bio varchar(255) DEFAULT NULL,
    preminum tinyint(10) DEFAULT NULL,
    image varchar(500)DEFAULT NULL
    );
 *
 * INTEREST
    CREATE TABLE interest (
    interest_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    interest varchar(40)DEFAULT NULL,
    type varchar(40)DEFAULT NULL
    );

 *
 * MEMBER_INTEREST
    CREATE TABLE member_interest (
    interest_id int NOT NULL ,
    member_id int NOT NULL ,
    FOREIGN KEY (interest_id) REFERENCES interest(interest_id),
    FOREIGN KEY (member_id) REFERENCES member(member_id)
    );

 *
 */
$user = $_SERVER['USER'];
require '/home2/tluugree/config-dating.php';

class Database
{
    private $_dbh;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {
        try
        {
            //instantiate a db object
            $this->_dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
            //echo "Connected!!";
            //return $this->_dbh;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function insertMember()
    {
        global $f3;
        $member = $f3->get('member');

        //1.Define the query
        $sql = "INSERT INTO member(fname, lname, age, gender, phone, email, state, seeking, bio, premium) 
        VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        //2.Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3.Bind the parameters
        $statement->bindParam(':fname', $member->getFname(), PDO::PARAM_STR);
        $statement->bindParam(':lname', $member->getLname(), PDO::PARAM_STR);
        $statement->bindParam(':age', $member->getAge(), PDO::PARAM_STR);
        $statement->bindParam(':gender', $member->getGender(), PDO::PARAM_STR);
        $statement->bindParam(':phone', $member->getPhone(), PDO::PARAM_STR);
        $statement->bindParam(':email', $member->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':state', $member->getState(), PDO::PARAM_STR);
        $statement->bindParam(':seeking', $member->getSeeking(), PDO::PARAM_STR);
        $statement->bindParam(':bio', $member->getBio(), PDO::PARAM_STR);

        if($member instanceof PremiumMember)
        {
            $statement->bindParam(':premium', $b=true, PDO::PARAM_BOOL);
        }
        else
        {
            $statement->bindParam(':premium', $b=false, PDO::PARAM_BOOL);
        }

        //4.Execute the statement
        $statement->execute();

        //5.Return the result
        if($member instanceof PremiumMember)
        {
            $lastMemberID = $this->_dbh->lastInsertId();
            if(!empty($member->getOutDoorInterests())) {
                foreach ($member->getOutDoorInterests() as $interest) {
                    $this->insertInterest($interest, $lastMemberID);
                }
            }
            if(!empty($member->getInDoorInterests())) {
                foreach ($member->getInDoorInterests() as $interest)
                {
                    $this->insertInterest($interest, $lastMemberID);
                }
            }
        }

    }

    private function insertInterest($interest, $lastMemberID)
    {
        /**ID**/
        //1.Define the query
        $sqlIntID = "SELECT interest_id FROM interest WHERE interest = :interest";

        //2.Prepare the statement
        $statementIntID = $this->_dbh->prepare($sqlIntID);

        //3.Bind the parameters
        $statementIntID->bindParam(':interest', $interest, PDO::PARAM_STR);

        //4.Execute the statement
        $statementIntID->execute();

        //5.Return the result
        $intID = $statementIntID->fetch(PDO::FETCH_NUM);

        /**Interest**/
        //1.Define the query
        $sqlInterests = "INSERT INTO member_interest(member_id, interest_id) VALUES (:member_id, :interest_id)";

        //2.Prepare the statement
        $statementInterest = $this->_dbh->prepare($sqlInterests);

        //3.Bind the parameters
        $statementInterest->bindParam(':member_id', $lastMemberID, PDO::PARAM_INT);
        $statementInterest->bindParam(':interest_id', $intID[0], PDO::PARAM_INT);

        //4.Execute the statement
        $statementInterest->execute();

        //5.Return the result
    }

    function getMembers()
    {
        //1.Define the query
        $sql = "SELECT * FROM member ORDER BY lname";

        //2.Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3.Bind the parameters

        //4.Execute the statement
        $statement->execute();

        //5.Return the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function getMember($member_id)
    {
        //1.Define the query
        $sql = "SELECT * FROM member WHERE member_id = :member_id";

        //2.Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3.Bind the parameters
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        //4.Execute the statement
        $statement->execute();

        //5.Return the result
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function getInterests($member_id)
    {
        //1.Define the query
        $sql = "SELECT interest.interest FROM member_interest INNER JOIN interest ON 
        member_interest.interest_id=interest.interest_id WHERE member_interest.member_id = :member_id";

        //2.Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3.Bind the parameters
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);

        //4.Execute the statement
        $statement->execute();

        //5.Return the result
        $row = $statement->fetchAll(PDO::FETCH_NUM);
        $interests = [];
        foreach ($row as $item)
        {
            array_push($interests, $item[0]);
        }
        if(empty($interests))
        {
            array_push($interests, "In-door and Out-door was not selected");
        }
        //print_r($interests);
        return $interests;
    }


}
