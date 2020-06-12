<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/autoload.php';
class Home extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model(array('M_product'=>'product'));
    }

    public function api($data)
    {
        $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
                'd45a21c4527517c9984b', //ganti dengan key pusher Anda
                '05c3cc9066fe9b44881b', //ganti dengan secret pusher Anda
                '1018240', //ganti dengan app_id pusher Anda
                $options
        );
        $data['message'] = 'success';
        return $pusher->trigger('my-channel', 'my-event', $data);
    }

	function index(){
        $this->load->view('v_home');
    }

    function get_product(){
        $data = $this->product->get_product()->result();
        echo json_encode($data);
    }

    function create(){
        $product_name = $this->input->post('product_name',TRUE);
        $product_price = $this->input->post('product_price',TRUE);
        $this->product->insert_product($product_name,$product_price);
        $data['message'] = 'success';
        return $this->api($data);
    }

    function update(){
        $product_id = $this->input->post('product_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_price = $this->input->post('product_price',TRUE);
        $this->product->update_product($product_id,$product_name,$product_price);
        $data['message'] = 'success';
        return $this->api($data);
    }

    function delete(){
        $product_id = $this->input->post('product_id',TRUE);
        $this->product->delete_product($product_id);
        $data['message'] = 'success';
        return $this->api($data);
    }
}
