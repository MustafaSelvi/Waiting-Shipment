<?php
session_start();
if($_SESSION["loggedin"] != true){
  echo 'not logged in';
  header("Location: login.php");
  exit;
}
?>
<form action="" method="POST">
<div class="ui segment">

            <button class="ui red compact labeled icon button" style="margin-bottom:20px;" id="new-order-button">
            <i class="minus circle icon"></i>
              Cancel Orders
            </button>
          
            <button class="ui right floated teal big compact labeled icon button" id="scan-form" style="margin-bottom:20px;" id="new-order-button">
            <i class="file pdf outline icon"></i>
              Create Scan Form
            </button>
            <!-- table goes here --> 

          

 </div>
 <?php
require_once "vendor/autoload.php";  
use GuzzleHttp\Client;
$client = new GuzzleHttp\Client();
try {
       $responseArray = $client->request('GET', 'http://ssapi.shipstation.com/orders?customerName=headhoncho@whitehouse.gov&page=1&pageSize=30&orderStatus=shipped', ['auth' => ['7ef956961bfd449da92bfc206f315c83', 'c295dc04fed743fd8cd7269b82a3da8b']]);   
       if($responseArray->getStatusCode()!= 200){
         throw new Exception("Error");
       }
       $body = $responseArray->getBody();
       $arr_body = json_decode($body, true);
   }
   catch(Exception $e) {
      echo 'Message: Connection Error ' .$e->getMessage();
    }
?>
   <?php  echo $_POST['id[]'] ?>
<table id="example" class="display" cellspacing="0" width="100%">
   <thead>
      <tr>
      <th><input type="checkbox" name="checkall" id="checkall" style="float:left" onClick="check_uncheck_checkbox(this.checked);" /></div></th>
         <th>Order Number</th>        
         <th>Order ID</th>
         <th>Service</th>
         <th>Receipient</th>
         <th>Ship Date</th>
         <th>Order Status</th>
      </tr>
   </thead>
    <tbody> 
 <?php for($x = 0; $x < count($arr_body["orders"]); $x++ ) { ?> 
       <tr>
       <td><input type="checkbox" name="id[]" style="margin:8px;" class="other" value="<?php echo $arr_body["orders"][$x]["orderId"]; ?>"></td> 
       <td style="display:none;"><?php echo $arr_body["orders"][$x]["orderId"]  ?></td>
         <td> <?php echo $arr_body["orders"][$x]["orderNumber"]  ?></td>                   
         <td> <?php echo $arr_body["orders"][$x]["orderId"]  ?></td>                    
         <td><?php echo $arr_body["orders"][$x]["carrierCode"]  ?></td>
         <td><?php echo $arr_body["orders"][$x]["billTo"]["name"]  ?></td>
         <td><?php
         $now = new DateTime($arr_body["orders"][$x]["shipByDate"] );
         echo $now->format('Y-m-d') 
          ?></td>
<td><?php echo $arr_body["orders"][$x]["orderStatus"]  ?></td> 
      </tr>   

   <?php }?>            
    </tbody> 
   <tfoot>
      <tr>
      <th><input type="checkbox" name="checkall" id="checkall" style="float:left" onClick="check_uncheck_checkbox(this.checked);" /></div></th>
         <th>Order Number</th>        
         <th>Order ID</th>
         <th>Service</th>
         <th>Receipient</th>
         <th>Ship Date</th>
         <th>Order Status</th>
      </tr>
   </tfoot> 
</table> 
 <?php
 //Scan form created with given barcode num
 if(isset($_POST["scan-form"])){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://secure.shippingapis.com/ShippingApi.dll?API=SCAN&XML=%3CSCANRequest%20USERID=%22645HERAK5237%22%3E%20%3COption%3E%3CForm%3E5630%3C/Form%3E%3C/Option%3E%3CFromName%3EJosh%20Webster%3C/FromName%3E%3CFromFirm%3EPostal%20Service%3C/FromFirm%3E%3CFromAddress1%3ESuite%20999%3C/FromAddress1%3E%3CFromAddress2%3E901%20D%20Street%20SW%3C/FromAddress2%3E%3CFromCity%3EWashington%3C/FromCity%3E%3CFromState%3EDC%3C/FromState%3E%3CFromZip5%3E20024%3C/FromZip5%3E%3CFromZip4%3E6129%3C/FromZip4%3E%3CShipment%3E%3CPackageDetail%3E%20%20%20%20%20%20%20%20%20%20%20%20%3CPkgBarcode%3E420782389205844444444400223232%3C/PkgBarcode%3E%20%3C/PackageDetail%3E%3C/Shipment%3E%20%20%20%3CMailDate%3E20200302%3C/MailDate%3E%3CMailTime%3E120501%3C/MailTime%3E%3CEntryFacility/%3E%20%20%3CImageType%3EPDF%3C/ImageType%3E%20%20%20%20%3CCustomerRefNo%3EEF789URV%3C/CustomerRefNo%3E%3C/SCANRequest%3E',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic NjQ1SEVSQUs1MjM3OjI3NkFYMjRPQTU5MA=='
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $scanXML=simplexml_load_string($response);
    $message = (string) $scanXML->Description;
    print_r($message);
 }
 ?>
<script>
$(document).ready(function() {
  var table = $('#example').DataTable({     
      'columnDefs': [
          {
              'targets': 0,
              'checkboxes': {
              'selectRow': true
              }
          }
      ],
      'select': {
          'style': 'multi'
      },
      'order': [[1, 'asc']]
  });
  
  // Handle form submission event 
  $('#frm-example').on('submit', function(e){
      var form = this;
      
      var rows_selected = table.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
          // Create a hidden element 
          $(form).append(
              $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'id[]')
                  .val(rowId)
          );
      });

      // FOR DEMONSTRATION ONLY
      // The code below is not needed in production
      
      // Output form data to a console     
      $('#example-console-rows').text(rows_selected.join(","));
      
      // Output form data to a console     
      $('#example-console-form').text($(form).serialize());
      
      // Remove added elements
      $('input[name="id\[\]"]', form).remove();
      
      // Prevent actual form submission
      e.preventDefault();
  });   
});

</script>
</form>