<?php
include_once "classes/AccountClass.php";
class Card
{
    public $db = '';

    public function __construct()
    {
        $database = new DB;
        $this->db = $database->getConnection();
    }

    public function checkApplication($type, $status = 1)
    {
        if($type == 'C')
            $card_type = 2;
        else
            $card_type = 1;

        $sql = "Select `id` from `cards` where `user_id`='".$_SESSION['user_id']."' AND `card_type`='".$card_type."' AND `status` = '".$status."'";

        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            return false;
        }else{
            return true;
        }
    }

    public function applyDebitCard($data)
    {
        $data = (object)$data;

        $data = (object)$data;

        $card = '1234 '.rand(pow(10, 4), pow(10, 4)-10).' '.rand(pow(10, 4-1), pow(10, 4)-1).' '.rand(pow(10, 4-1), pow(10, 4)-1);
        $exp_month = 11;
        $exp_year = 2035;
        $cvv = rand(pow(10, 3), pow(10, 3)-5);


        $sql = "INSERT INTO `cards`(`user_id`,`account_id`,`card_no`,`cvv`,`exp_month`,`exp_year`,`card_type`,`credit_limit`,`status`,`created_at`,`updated_at`)
                VALUES(
                    '".$_SESSION['user_id']."',
                    '".$data->account_no."',
                    '".$card."',
                    '".$cvv."',
                    '".$exp_month."',
                    '".$exp_year."',
                    1,
                    '',
                    1,
                    now(),
                    now()
                )";

        if ($this->db->query($sql) === TRUE) {
            $user_id = $this->db->insert_id;
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    public function getCardDetails($card_type = 1)
    {
        $sql = "Select * from `cards` where `user_id`=".$_SESSION['user_id']." AND `card_type` = ".$card_type." AND `status`=1";

        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            while($row = $result->fetch_object()) {
                $card_data[] = (object)[
                    'id' =>$row->id,
                    'card_no' =>$row->card_no,
                    'cvv' =>$row->cvv,
                    'exp_month' =>$row->exp_month,
                    'exp_year' =>$row->exp_year,
                    'credit_limit' =>$row->credit_limit,
                    'used_limit' =>$row->used_limit,
                ];
            }
            return (object)$card_data;

        }else{
            return ['error' => false];
        }
    }

    public function applyCreditCard($data)
    {
        $data = (object)$data;

        $card = '1234 '.rand(pow(10, 4), pow(10, 4)-10).' '.rand(pow(10, 4-1), pow(10, 4)-1).' '.rand(pow(10, 4-1), pow(10, 4)-1);
        $exp_month = 11;
        $exp_year = 2035;
        $cvv = rand(pow(10, 3), pow(10, 3)-5);

        $limit = ($data->income / 12) * 1.5;
        $limit = number_format($limit, 2, '.', '');


        $sql = "INSERT INTO `cards`(`user_id`,`card_no`,`cvv`,`exp_month`,`exp_year`,`card_type`,`credit_limit`,`status`,`created_at`,`updated_at`)
                VALUES(
                    '".$_SESSION['user_id']."',
                    '".$card."',
                    '".$cvv."',
                    '".$exp_month."',
                    '".$exp_year."',
                    2,
                    '".$limit."',
                    1,
                    now(),
                    now()
                )";

        if ($this->db->query($sql) === TRUE) {
            $user_id = $this->db->insert_id;
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    public function makeDebitCardPayment($data)
    {
        $data = (object)$data;

    }

    public function makeCreditCardPayment($data)
    {
        $data = (object)$data;
        $sql = "SELECT * FROM `cards` WHERE `card_no` = '".$data->card_no."' AND `cvv` = ".$data->cvv." AND `exp_month` = ".$data->card_month." AND `exp_year` = ".$data->card_year;
        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $card_data = $result->fetch_object();
            $sql2 = "UPDATE `cards` SET";
            $sql2 .= "`used_limit` = `used_limit` + '".$data->amount."'";
            $sql2 .= "WHERE `id` = ".$card_data->id;

            if($this->db->query($sql2) === TRUE){
                $data->card_id = $card_data->id;
                $this->cardTransactionLog($data, "W");
                return true;
            }else{
                echo "Error: " . $sql2 . "<br>" . $this->db->error;
                return false;
            }
        }
        else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
            return false;
        }
    }

    public function makeCreditCardRePayment($data){
        $data = (object)$data;
        $sql = "SELECT * FROM `cards` WHERE `user_id` = ".$_SESSION['user_id']." AND `card_type`=2";
        $result = $this->db->query($sql);
        if ($result->num_rows == 1) {
            $card_data = $result->fetch_object();
            $sql = "UPDATE `cards` SET";
            $sql .= "`used_limit` = `used_limit` - '".$data->amount."'";
            $sql .= "WHERE `id` = ".$card_data->id;

            if($this->db->query($sql) === TRUE){
                $data->card_id = $card_data->id;
                $this->cardTransactionLog($data, "C");
                return true;
            }else{
                echo "Error: " . $sql . "<br>" . $this->db->error;
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function cardTransactionLog($data,$type)
    {
        $data = (object)$data;

        $ref_no = rand();
        $t_type = 0;
        if($type == "W"){
            $t_type = 1;
        }else{
            $t_type = 2;
        }
        $sql = "INSERT INTO `card_transaction`(`ref_no`,`user_id`,`card_id`,`amount`,`transaction_type`,`created_at`,`updated_at`)
            VALUES(
                '".$ref_no."',
                '".$_SESSION['user_id']."',
                '".$data->card_id."',
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
}