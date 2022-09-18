<?php
include "classes/AccountClass.php";
class Person{
    public $db = '';
    public function __construct() {
        $database = new DB;
        $this->db = $database->getConnection();
    }

    public function register($account_details){
        $account_details = (object)$account_details; //Type casting Array to Object
        $pass = md5($account_details->password);
        $sql = "Select id from users where email='".$account_details->email."'";
        $result = $this->db->query($sql);
        if ($result->num_rows < 1) {
            $sql = "INSERT INTO `users`(`firstname`,`lastname`,`username`,`email`,`phone`,`alt_phone`,`aadhar`,`pan`,`password`,`status`,`created_at`,`upated_at`)
                VALUES(
                    '".$account_details->fname."',
                    '".$account_details->lname."',
                    '".$account_details->username."',
                    '".$account_details->email."',
                    '".$account_details->phone."',
                    '".$account_details->alt_phone."',
                    '".$account_details->aadhar."',
                    '".$account_details->pan."',
                    '".$pass."',
                    '1',
                    now(),
                    now()
                )";

            if ($this->db->query($sql) === TRUE) {
                $user_id = $this->db->insert_id;
                $account = new Account();
                if($account->create($user_id)){
                    return true;
                }else{
                    return false;
                }

            } else {
                echo "Error: " . $sql . "<br>" . $this->db->error;
                return false;
            }
        } else {
            return false;
        }

    }

    public function login($cred)
    {
        $cred = (object)$cred;
        $pass = md5($cred->password);

        $sql = "Select id from users where username='".$cred->username."' AND password='".$pass."'";

        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $user_data = $result->fetch_object();
            $_SESSION['user_id']=$user_data->id;
            header("Location: dashboard.php");
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (isset($_SESSION['user_id'])){
            $sql = "Select firstname from users where id='".$_SESSION['user_id']."'";
            $result = $this->db->query($sql);
            $user_data = $result->fetch_object();
            return $user_data->firstname;
        }else{
            return "User";
        }

    }

    public function getPerson()
    {
        if (isset($_SESSION['user_id'])){
            $sql = "SELECT
                        `users`.*,
                        `user_accounts`.`user_id`,
                        `user_accounts`.`account_no`,
                        `user_accounts`.`account_type`
                    FROM
                        `users`
                    INNER JOIN `user_accounts` ON `user_accounts`.`user_id` = `users`.`id`
                    WHERE
                        `users`.`id` = '".$_SESSION['user_id']."'";

            $result = $this->db->query($sql);
            $user_data = $result->fetch_object();
            return $user_data;
        }else{
            return "User";
        }

    }

    public function getAccountNo()
    {
        if (isset($_SESSION['user_id'])){
            $sql = "Select id, user_id, account_no from user_accounts where user_id='".$_SESSION['user_id']."'";

            $result = $this->db->query($sql);
            $account_data = array();
            while($row = $result->fetch_object()) {
                $account_data[] = (object)[
                    'id' =>$row->id,
                    'account_no' =>$row->account_no
                ];
            }
            return (object)$account_data;
        }else{
            return false;
        }

    }


}