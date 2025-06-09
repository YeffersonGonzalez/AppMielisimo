<?php
class DBConfig
{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn = false;
    public $db_link;
    public $error_message;

    public function config()
    {
        $this->loadEnv();
    }

    private function loadEnv()
    {
        $envPath = __DIR__ . '/../.env';
        if (!file_exists($envPath)) {
            throw new Exception(".env file not found.");
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (trim($line)[0] === '#' || strpos($line, '=') === false) continue;
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }

    public function conexion($host = 'localhost', $user = 'root', $pass = '123456789', $db = 'confiteria_mielissimo')
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->error_message = "";

        try {
            $this->db_link = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            $this->conn = true;
        } catch (PDOException $exception) {
            $this->error_message = $exception->getMessage();
            throw new Exception("Error de conexión a la base de datos: " . $this->error_message);
        }
    }

    private function checkConnection()
    {
        if (!$this->conn) {
            $this->conexion();
        }
    }

    public function getProductos()
    {
        $this->checkConnection();
        $stmt = $this->db_link->query("SELECT * FROM productos");
        return $stmt->fetchAll();
    }

    public function getProveedores()
    {
        $this->checkConnection();
        $stmt = $this->db_link->query("SELECT * FROM proveedores");
        return $stmt->fetchAll();
    }
    public function buscarProveedorPorNombre($buscar)
            {
                $this->checkConnection();
                $query = "SELECT * FROM proveedores WHERE razon_social LIKE :buscar";
                $stmt = $this->db_link->prepare($query);
                $stmt->execute([":buscar" => "%$buscar%"]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        public function buscarProductosPorNombre($buscar)
            {
                $this->checkConnection();
                $query = "SELECT * FROM productos WHERE nombre LIKE :buscar";
                $stmt = $this->db_link->prepare($query);
                $stmt->execute([":buscar" => "%$buscar%"]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }



    public function getMarcas()
    {
        $this->checkConnection();
        $stmt = $this->db_link->query("SELECT * FROM marcas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarMarcasPorNombre($buscar)
    {
        $this->checkConnection();
        $query = "SELECT * FROM marcas WHERE nombre LIKE :buscar";
        $stmt = $this->db_link->prepare($query);
        $stmt->execute([":buscar" => "%$buscar%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarMarcasPorID($id)
    {
        $this->checkConnection();
        $query = "SELECT * FROM marcas WHERE id = :id";
        $stmt = $this->db_link->prepare($query);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
?>
