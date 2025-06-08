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
    public function crearProducto($datos)
{
    $this->checkConnection();
    $query = "INSERT INTO productos (codigo, nombre, stock, stock_min, precio_compra, precio_venta, id_marca, fecha_vencimiento, observacion, activo) 
              VALUES (:codigo, :nombre, :stock, :stock_min, :precio_compra, :precio_venta, :id_marca, :fecha_vencimiento, :observacion, :activo)";
    $stmt = $this->db_link->prepare($query);

    return $stmt->execute([
        ":codigo" => $datos["codigo"],
        ":nombre" => $datos["nom"],
        ":stock" => $datos["stock"],
        ":stock_min" => $datos["stock_min"] ?? 0,
        ":precio_compra" => $datos["prc_compra"],
        ":precio_venta" => $datos["prc_venta"],
        ":id_marca" => $datos["id_mrc"],
        ":fecha_vencimiento" => $datos["fch_vnc"] ?? NULL,
        ":observacion" => $datos["obs"] ?? "",
        ":activo" => $datos["activo"] ?? 1
    ]);
}

    public function getMarcas()
    {
        $this->checkConnection();
        $stmt = $this->db_link->query("SELECT id, nombre FROM marcas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
