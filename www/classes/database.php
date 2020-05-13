<?php

class Database
{
    private $db_host = 'localhost';
    private $db_user;
    private $db_pass;
    private $db_name = 'kpbti';
    public $db_link;
    private $kod_rn;

    function __construct($db_user, $db_pass)
    {
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_link = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (!$this->db_link) {
           // if (!@mysql_select_db($this->db_name, $this->db_link)) {
                echo 'Немає з`єднання з базою даних';
                exit();
         //   }
        }
    }

    public function aut_user()
    {
        $atu = $this->db_link->query("SELECT * FROM security WHERE LOG='$this->db_user'");
        while ($aut = $atu->fetch_array(MYSQLI_ASSOC)/*mysql_fetch_array($atu)*/) {
            $pr = $aut["PR"];
            $im = $aut["IM"];
            $pb = $aut["PB"];
            $pd = $aut["PRD"];
            $brigada = $aut["BR"];
            $ddl = $aut['DTL'];
        }
        $atu->free_result();
        if ($pr != "") {
            session_start();
            $_SESSION['LG'] = $this->db_user;
            $_SESSION['PAS'] = $this->db_pass;
            $_SESSION['PR'] = $pr;
            $_SESSION['IM'] = $im;
            $_SESSION['PB'] = $pb;
            $_SESSION['PD'] = $pd;
            $_SESSION['BRIGADA'] = $brigada;
            if ($ddl == '1') $_SESSION['DDL'] = '1'; else $_SESSION['DDL'] = '0';
        }
    }

    public function select_rn($kod_rn)
    {
        $this->kod_rn = $kod_rn;
        $sql = "SELECT MAX(rayonu.ID_RAYONA) AS PID FROM rayonu";
        $atu = $this->db_link->query($sql); //mysql_query($sql);

        while ($aut = $atu->fetch_array(MYSQLI_ASSOC)/*mysql_fetch_array($atu)*/) {
            $p_id = $aut["PID"];
        }
        $atu->free_result();

        for ($zk = 1; $zk <= $p_id; $zk++) {
            $sl[$zk] = "";
        }
        $sl[$this->kod_rn] = "selected";
        $p = '';
        $atu = $this->db_link->query("SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA");
        while ($aut = $atu->fetch_array(MYSQLI_ASSOC)) {
            $dl_s = strlen($aut["RAYON"]) - 10;
            $n_rjn = substr($aut["RAYON"], 0, $dl_s);
            $p .= '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
        }
        $atu->free_result();
        return $p;
    }

    /* public function disconnect(){
        if($this->con)
        {
            if(@mysql_close())
            {
                $this->con = false;
                return true;
            }
            else
            {
                return false;
            }
        }
    } */
    public function __destruct()
    {
        $this->db_link->close();
    }
}
