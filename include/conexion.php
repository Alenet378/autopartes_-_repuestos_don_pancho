<?php
    declare(strict_types= 1);
    class ConexionBD {
        private string $host ="localhost";
        private string $db ="autopartes";
        private string $user="alejandro";
        private string $pass= "12345";
        private string $charset ="utf8mb4";

        public function conectar(): ?PDO {
            $dsn= "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            try {
                $pdo= new PDO($dsn,$this->user,$this->pass,$opciones);
                return $pdo;
            } catch (PDOException $e){
                error_log("Fallo critico en conexion BD: ". $e->getMessage());

                echo "<div style='color:red; background:#fee2e2; padding:15px; border-radius:8px;'>
                            <strong>Error de Conexion:</strong> No se pudo conectar a la base de datos de alejandro
                        </div>";
                return null;
                }
            }
    }
?>