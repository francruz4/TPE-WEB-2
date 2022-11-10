<?php

class BrandModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_car;charset=utf8', 'root', '');
    }

    
    function getAll (){
        $query = $this->db->prepare( "select * from marca");
        $query -> execute();
        $brands = $query->fetchAll(PDO::FETCH_OBJ);
        return $brands;
    }
    function get($id){
        $query = $this->db->prepare( "select * from marca WHERE id_marca=? ");
        $query -> execute(array($id));
        $brand = $query->fetch(PDO::FETCH_OBJ);
        return $brand; 
    }

    function insert($nombre){
        $query = $this->db->prepare("INSERT INTO marca(nombre) VALUES(?)");
        $query->execute(array($nombre));
        return $this->db->lastInsertId();
    }
    function delete($id){
        $query = $this->db->prepare("DELETE FROM marca WHERE id_marca=?");
        $query->execute(array($id,));
    }


    function edit($nombre,$id){
        $query = $this->db->prepare("UPDATE marca SET nombre=? WHERE id_marca=?");
        $query->execute(array($nombre,$id));
    }

}
