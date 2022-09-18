<?php

class Account
{
    public $db = '';

    public function __construct()
    {
        $database = new DB;
        $this->db = $database->getConnection();
    }

    public function create($user_id)
    {
        $account_no = rand();
        $sql = "INSERT INTO `user_accounts`(`user_id`,`account_no`,`account_type`,`status`,`created_at`,`upated_at`)
                VALUES(
                    '".$user_id."',
                    '".$account_no."',
                    '1',
                    '1',
                    now(),
                    now()
                )";
        if($this->db->query($sql) === TRUE){
            return true;
        }else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    /**
     * Update Account balance for both deposit and withdrawal
     */
    public function updateBalance($data, $type = 'W')
    {
        $data = (object)$data;

        $sql = "UPDATE `user_accounts` SET";
        if($type == "W"){
            $sql .= "`balance` = `balance` - '".$data->amount."'";
        }else{
            $sql .= "`balance` = `balance` + '".$data->amount."'";
        }
        $sql .= "WHERE `user_id` = ".$_SESSION['user_id']." AND `id` = ".$data->account_no." AND `account_type` = ".$data->account_type;

        if($this->db->query($sql) === TRUE){
            $this->transactionHistory($data, $type);
            return true;
        }else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    public function transactionHistory($data, $type)
    {
        $data = (object)$data;
        $ref_no = rand();
        $t_type = 0;
        if($type == "W"){
            $t_type = 1;
        }else{
            $t_type = 2;
        }
        $sql = "INSERT INTO `transaction`(`ref_no`,`user_id`,`account_id`,`amount`,`transaction_type`,`created_at`,`updated_at`)
            VALUES(
                '".$ref_no."',
                '".$_SESSION['user_id']."',
                '".$data->account_no."',
                '".$data->amount."',
                '".$t_type."',
                now(),
                now()
            )";
        if($this->db->query($sql) === TRUE){
            return true;
        }else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    public function getTransaction()
    {
        if (isset($_SESSION['user_id'])){

            $sql = "Select * from `transaction` where `user_id`='".$_SESSION['user_id']."'";

            $result = $this->db->query($sql);
            $account_data = array();
            while($row = $result->fetch_object()) {
                $account_data[] = (object)[
                    'id' =>$row->id,
                    'ref_no' =>$row->ref_no,
                    'amount' =>$row->amount,
                    'transaction_type' =>$row->transaction_type,
                    'created_at' =>$row->created_at,
                ];
            }
            return (object)$account_data;
        }else{
            return false;
        }
    }


    public function getBalance($data)
    {
        $data = (object)$data;
        $sql = "Select `balance` from `user_accounts` where `user_id` = ".$_SESSION['user_id']." AND `id` = ".$data->account_no." AND `account_type` = ".$data->account_type;

        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $account_data = $result->fetch_object();
            return $account_data->balance;
        }else{
            return 0.00;
        }
    }



}