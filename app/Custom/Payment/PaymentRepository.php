<?php


namespace App\Custom\Payment;

use App\Models\Transaction;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PaymentRepository
{
    public static function initiatePayment(){
        include_once('OAuth.php');
        $date = new \DateTime();
        $time = $date->getTimestamp();
        $reference = "AJ-".date("Ymd")."-".$time."-".Auth::user()->id;

        $token = $params = NULL;
        $consumer_key = 'z3BdDR2pvzMM4yFeeNKl0sMy0Sk1tRqb';//Register a merchant account on
                        //demo.pesapal.com and use the merchant key for testing.
                        //When you are ready to go live make sure you change the key to the live account
                        //registered on www.pesapal.com!
        $consumer_secret = 'Gh2I6wzsgVFSCu/hafPRJYoYP7U=';// Use the secret from your test
                        //account on demo.pesapal.com. When you are ready to go live make sure you
                        //change the secret to the live account registered on www.pesapal.com!
        $signature_method = new \OAuthSignatureMethod_HMAC_SHA1();
        $iframelink = 'https://www.pesapal.com/API/PostPesapalDirectOrderV4';//change to     
                        //https://www.pesapal.com/API/PostPesapalDirectOrderV4 when you are ready to go live!

        $amount0 = session()->get('amount');//$_SESSION['amount'];//1000;				   
        $amount = number_format($amount0, 2);//format amount to 2 decimal places
        if(session()->get('message')!==""){
            $desc = session()->get('message');//$_POST['description'];
        }else{
            $desc = "No Description";
        }
        $type = "MERCHANT";//$_POST['type']; //default value = MERCHANT
        $reference = $reference;//$_POST['reference'];//unique order id of the transaction, generated by merchant
        $name = explode(" ", Auth::user()->name);
        if(count($name)==3){
            $first_name = $name[0];
            $last_name = $name[2];
        }else if(count($name)==2){
            $first_name = $name[0];
            $last_name = $name[1];
        }else if(count($name) == 1){
            $first_name = $name[0];
            $last_name = "";
        }else{
            $first_name = $name[0]??"";//$_POST['first_name']; //[optional]
            $last_name = $name[1]??"";//$_POST['last_name']; //[optional]
        }
        $email = session()->get('email');//$_POST['email'];
        $phonenumber = Auth::user()->phone; //ONE of email or phonenumber is required

       
        $trans_data = [
            "payer_name" => Auth::user()->name, 
            "reference_number" => $reference, 
            "user_id" => Auth::user()->id,
            "description" => "", 
            "amount" => $amount0, 
            "tracking_id" => null,
        ];
        $transaction = Transaction::create($trans_data);
        

        if(!isset($_SESSION['callback'])){
            $callback_url = 'http://www.ajiriwa.net'; //redirect url, the page that will handle the response from pesapal.
        }else{
            $callback_url = $_SESSION['callback'];
        }
        $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchemainstance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Amount=\"".$amount."\" Description=\"".$desc."\" Type=\"".$type."\" Reference=\"".$reference."\" FirstName=\"".$first_name."\" LastName=\"".$last_name."\" Email=\"".$email."\" PhoneNumber=\"".$phonenumber."\" xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);

        $consumer = new \OAuthConsumer($consumer_key, $consumer_secret);
        //post transaction to pesapal
        $iframe_src = \OAuthRequest::from_consumer_and_token($consumer, $token, "GET",
        $iframelink, $params);
        $iframe_src->set_parameter("oauth_callback", $callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($signature_method, $consumer, $token);
        //return $iframe_src;

        return [
            'transaction' => $transaction,
            'iframe' => '<iframe onload="document.getElementById(\'gateway-loading\').style.display=\'none\'" src="'.$iframe_src.'" width="100%" height="400px" scrolling="auto" frameBorder="0" id="paymentFrame"> <p>Unable to load the payment page</p> </iframe>'
        ];
        
    }   
}
