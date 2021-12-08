//mpesa
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payments_model',"payments");
    }


    public function generateAccessToken()
    {
    }
    /**
     *register url
     */
    public function register_url()
    {
        $access_token = $this->generateAccessToken();
        //echo 'Authorization:Bearer '.$access_token;
        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $short_code = '603021';
        $confirmation_url = 'https://payments.kenyaorthodontics.co.ke/index.php/confirmation';
        $validation_url = 'https://payments.kenyaorthodontics.co.ke/index.php/validation';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ShortCode' => $short_code,
            'ResponseType' => 'Confirmed',
            'ConfirmationURL' => $confirmation_url,
            'ValidationURL' => $validation_url
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        //print_r($curl_response);
        echo $curl_response;
    }

    

    /**
     *mpesa validation url
     */

    public function validation()
    {
        header("Content-Type: application/json");
        $response = '{ "ResultCode": 0, "ResultDesc": "Confirmation Received Successfully" }';

        echo $response;
    }

    /**
     * confirmation url
     */
    public function confirmation()
    {
        //get data from mpesa
        $mpesa_response = file_get_contents('php://input');
       
        $data = array(
            'response' => $mpesa_response,
            "datetime" => date("Y-m-d H:i:s")
        );
        
        //insert data into database
        $this->payments->insert_mpesa_details($data);

        //respond with success to safaricom
        header("Content-Type: application/json");
        $system_response = '{ "ResultCode": 0, "ResultDesc": "Confirmation Received Successfully" }';

        echo $system_response;
    }

    function callback()
    {

    }

//end mpesa
}
