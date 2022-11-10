<?php
require_once './models/brand.model.php';
require_once './views/api.view.php';

class BrandApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new BrandModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getBrands($params = null) {
        $brands = $this->model->getAll();
        $this->view->response($brands);
    }

    public function getBrand($params = null) {     
        $id = $params[':ID'];
        $brand = $this->model->get($id);
        if ($brand)
            $this->view->response($brand);
        else 
            $this->view->response("la marca con el id=$id no existe", 404);
    }

    public function deleteBrand($params = null) {
        $id = $params[':ID'];
        $brand = $this->model->get($id);
        if ($brand) {
            $this->model->delete($id);
            $this->view->response("la marca con el id=$id se elimino correctamente", 200);
        } else 
            $this->view->response("la marca con el id=$id no existe", 404);
    }

    public function insertBrand($params = null) {
        $brand = $this->getData();

        if (empty($brand->nombre)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($brand->nombre);
            $this->view->response("la marca se inserto correctamente con el id=$id", 201);
        }
    }
    public function editBrand($params = null) {
          $data = $this->getData();
          $id = $params[':ID'];
          $brand = $this->model->get($id);
          if ($brand){
            if (empty($data->nombre)) {
            $this->view->response("Complete los datos", 400);
        }   else {
             $this->model->edit($data->nombre,$id);
            $this->view->response("la marca se edito correctamente con el id=$id", 201);
        }
        }else {
            $this->view->response(" la marca con el id=$id no existe", 404);
        }
    }

}