<?php
require_once './models/car.model.php';
require_once './views/api.view.php';

class CarApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new CarModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }
    public function getColumn($column){
        switch ($column) {
        case "id":
            return "id";
         case "modelo":
             return "modelo";
         case "descripcion":
             return "descripcion";
        case "precio":
             return "precio";
         case "marca":
             return "marca";
         case "id_marca":
             return "id_marca";
         default:
             return null;
            }
    }

    public function getCars($params = null) {
        $sort = isset($_GET["sort"]) ?$this->getColumn(strtolower($_GET["sort"])) : null;
        $order = isset($_GET["order"]) ? $_GET["order"] : "ASC";
        $cars = $this->model->getAll($sort,$order);
        $this->view->response($cars);
    }

    public function getCar($params = null) {     
        $id = $params[':ID'];
        $car = $this->model->get($id);
        if ($car)
            $this->view->response($car);
        else 
            $this->view->response("el auto con el id=$id no existe", 404);
    }

    public function deleteCar($params = null) {
        $id = $params[':ID'];
        $car = $this->model->get($id);
        if ($car) {
            $this->model->delete($id);
            $this->view->response("el auto con el id=$id se elimino correctamente", 200);
        } else 
            $this->view->response("el auto con el id=$id no existe", 404);
    }

    public function insertCar($params = null) {
        $car = $this->getData();

        if (empty($car->modelo) || empty($car->descripcion) || empty($car->precio)|| empty($car->marca)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($car->modelo, $car->descripcion, $car->precio,$car->marca);
            $this->view->response("el auto se inserto correctamente con el id=$id", 201);
        }
    }
    public function editCar($params = null) {
          $data = $this->getData();
          $id = $params[':ID'];
          $car = $this->model->get($id);
          if ($car){
            if (empty($data->modelo) || empty($data->descripcion) || empty($data->precio)|| empty($data->marca)) {
            $this->view->response("Complete los datos", 400);
        }   else {
             $this->model->edit($id,$data->modelo, $data->descripcion, $data->precio,$data->marca);
            $this->view->response("el auto se edito correctamente con el id=$id", 201);
        }
        }else {
            $this->view->response("el auto con el id=$id no existe", 404);
        }
    }

}