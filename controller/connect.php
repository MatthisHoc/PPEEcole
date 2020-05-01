<?php
 
 class Bdd
    {
        static private $pdo = null;
        private $stm;
        
        public function __construct(string $host ="", string $dbname="", string $username="", string $password="")
        {
            if (self::$pdo == null)
            {
                try
                {
                    self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                }
                catch (PDOException $pe)
                {
                    die("Echec de connexion $dbname :" . $pe->getMessage());
                }
            }
        }

        public function requete(string $requete)
        {
            $this->stm = self::$pdo->prepare($requete);
        }
        
        public function bindParam(string $remplacement, $valeur, int $typeParam)
        {
            $this->stm->bindParam($remplacement, $valeur, $typeParam);
        }
        
        public function execute(string $pageRetour = '#') : bool
        {
            if(!$this->stm->execute())
            {
                echo $this->error($this->stm, $pageRetour);
                return false;     
            }
            else
            {
                return true;
            }
        }
        
        // Renvoi un string d'erreur formaté qui redirige vers la page d'accueil
        private function error(PDOStatement $stmt, string $pageRetour) : string
        {
            $erreur = implode("','",$stmt->errorInfo());
            return '<script> alert("ERREUR SQL: '.$erreur.'"); document.location.href= "'.$pageRetour.'"; </script>';
        }

        public function getStmt() : PDOStatement
        {
            return $this->stm;
        }

        static public function getPDO() : PDO
        {
            return self::$pdo;
        }
    }

    function are_set($array, $keys) : bool
    {
        foreach($keys as $key)
        {
            if(!isset($array[$key]))
            {
                return false;
            }
        }

        return true;
    }

    
    function redirectFromIndex(string $path)
    {
        if (!session_id())
        {
            session_start();
        }

        $_SESSION['redirect'] = $path;
        redirect("empty");
    }

    function redirect(string $path)
    {
        ?>
        <script>
            <?php if ($path == 'empty') 
            {
                ?> document.location.href = '/ppeecole/';
            <?php } else { ?>
            var val = "<?php echo $path; ?>";
            $(document).ready(function(){ $("#contenu").load('/ppeecole/' + val); });
            <?php } ?>
        </script>
        <?php
    }

    $host = 'localhost';
    $dbname = 'ecole';
    $username = 'root';
    $password = '';
    
    // Initialiser la bdd une premiere fois
    $bdd = new Bdd($host, $dbname, $username, $password);
    ?>