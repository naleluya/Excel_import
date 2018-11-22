<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Excel_import_model');
        $this->load->library('Excel');
    }

    public function index()
    {
        $this->load->view('excel_import');
    }

    public function fetch()
    {
        $data = $this->Excel_import_model->select();
        echo json_encode($data);
    }
    public function import()
    {
        if(isset($_FILES["file"]["name"]))
        {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                for($row = 2; $row<=$highestRow; $row++) {
                    $customer_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    if ($this->Excel_import_model->verificar_customerid($customer_id)) {
                        $customer_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $address = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $city = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $postal_code = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $country = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $data1[] = array(
                            'CustomerID' => $customer_id,
                            'CustomerName' => $customer_name,
                            'Address' => $address,
                            'City' => $city,
                            'PostalCode' => $postal_code,
                            'Country' => $country
                        );
                        $this->Excel_import_model->actualizar($customer_id, $data1);
                    }
                    else{
                        $customer_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $address = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $city = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $postal_code = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $country = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $data[] = array(
                            'CustomerID' => $customer_id,
                            'CustomerName' => $customer_name,
                            'Address' => $address,
                            'City' => $city,
                            'PostalCode' => $postal_code,
                            'Country' => $country
                        );
                        $this->Excel_import_model->insert($data);
                    }
                    reset($data1);
                    reset($data);
                }
            }

            echo 'Datos importados exitosamente';
        }
    }
}