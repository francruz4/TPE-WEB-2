<?php

class CarModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_car;charset=utf8', 'root', '');
    }

    
    function getAll($sort,$order){
        $query = "select c.id,c.modelo,c.descripcion,c.precio,m.nombre as marca,m.id_marca from vehiculos c join marca m on c.marca=m.id_marca";
        if(!is_null($sort)){
            $query.=" ORDER BY $sort $order ";
        }
        $query = $this->db->prepare($query);
        $query->execute();
        $cars = $query->fetchAll(PDO::FETCH_OBJ);
        return $cars;
    } 

    function get($id){
        $query = $this->db->prepare( "select c.id,c.modelo,c.descripcion,c.precio,m.nombre as marca,m.id_marca from vehiculos c join marca m on c.marca=m.id_marca WHERE c.id = ?");
        $query->execute(array($id));
        $car = $query->fetch(PDO::FETCH_OBJ);
        return $car;
    }

    function insert($modelo, $descripcion, $precio, $marca) {
        $query = $this->db->prepare("INSERT INTO vehiculos (modelo, descripcion, precio, marca) VALUES (?, ?, ?, ?)");
        $query->execute([$modelo, $descripcion, $precio, $marca]);
        return $this->db->lastInsertId();
    }
    function delete($id) {
        $query = $this->db->prepare("DELETE FROM vehiculos WHERE id = ?");
        $query->execute([$id]);
    }

    function edit($id,$modelo, $descripcion, $precio, $marca) {
        $query = $this->db->prepare("UPDATE vehiculos SET modelo = ? , descripcion = ? , precio = ? , marca = ? WHERE id = ?");
        $query->execute([$modelo, $descripcion, $precio, $marca,$id]);
    }

}
