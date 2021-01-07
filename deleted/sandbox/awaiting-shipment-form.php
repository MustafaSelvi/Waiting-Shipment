<div class="ui segment">
<?php

require_once "vendor/autoload.php";  
use GuzzleHttp\Client;
$client = new GuzzleHttp\Client();
try {
       $responseArray = $client->request('GET', 'http://ssapi.shipstation.com/orders?customerName='.$_SESSION['email'].'&orderStatus=awaiting_shipment&page=1&pageSize=100', ['auth' => ['7ef956961bfd449da92bfc206f315c83', 'c295dc04fed743fd8cd7269b82a3da8b']]);   
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

<form id="frm-example" action="index.php" method="POST">
<input class="ui red compact labeled icon button" onClick="return confirm('Are you sure you want to delete?')" type="submit" name="delete-order" value="Delete Order">
<input class="ui blue compact labeled icon button" type="submit" name="update-order" value="Update Orders">
<input class="ui green compact labeled icon button" type="submit" name="create-label" value="Create Label">
<input class="ui purple compact labeled icon button" type="submit" name="void-label" value="Void Label">


<table id="example" class="display" cellspacing="0" width="100%">
   <thead>
      <tr>
      <th><input type="checkbox" name="checkall" id="checkall" style="float:left" onClick="check_uncheck_checkbox(this.checked);" /></div></th>
         <th>Order Number</th>        
         <th>Order ID</th>
         <th>Service</th>
         <th>Receipient</th>
         <th>Order Date</th>
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
         $now = new DateTime($arr_body["orders"][$x]["orderDate"] );
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
         <th>Order Date</th>
         <th>Order Status</th>
      </tr>
   </tfoot> 
</table> 
<hr>
<input class="ui right floated teal big compact labeled icon button" type="submit" name="label-down" value="Download Label">
</div>
</form>
<?php
//delete orders
if(isset($_POST["delete-order"]))
{
   $box=$_POST['id'];
      while(list ($key,$val) = @each ($box))
      {
         echo "$key";
         echo "$val";
         $response = $client->request('DELETE', 'http://ssapi.shipstation.com/orders/'.$val, ['auth' => ['7ef956961bfd449da92bfc206f315c83', 'c295dc04fed743fd8cd7269b82a3da8b']]);    
         
      }
   ?>
   <script type="text/javascript">
   window.location.href=window.location.href;
   </script>
   <?php 
}
//Update Order
if(isset($_POST["update-order"]))
{
   
$box = $_POST['id'];
while(list($key,$val) = @each ($box))
{
//Bulk update with OrderId
//echo "$box[0]";
}
   $curl = curl_init();

   curl_setopt_array($curl, array(
     CURLOPT_URL => "ssapi.shipstation.com/orders/createorder",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS =>"{\r\n   \"orderId\": '$box[0]',\r\n   \"orderKey\": \"89985a3a9b7d409cb83bcd0e439sdadsdfsdfs\",\r\n \"orderNumber\": \"OrderToBeDel1\",\r\n  \"orderDate\": \"2015-06-29T08:46:27.0000000\",\r\n  \"paymentDate\": \"2015-06-29T08:46:27.0000000\",\r\n  \"shipByDate\": \"2015-07-05T00:00:00.0000000\",\r\n  \"orderStatus\": \"awaiting_shipment\",\r\n  \"customerId\": 37701499,\r\n  \"customerUsername\": \"headhoncho@whitehouse.gov\",\r\n  \"customerEmail\": \"headhoncho@whitehouse.gov\",\r\n  \"billTo\": {\r\n    \"name\": \"The President\"\r\n  },\r\n  \"shipTo\": {\r\n    \"name\": \"test\",\r\n    \"company\": \"US Govt\",\r\n    \"street1\": \"1600 Pennsylvania Ave\",\r\n    \"street2\": \"Oval Office\",\r\n    \"street3\": null,\r\n    \"city\": \"Washington\",\r\n    \"state\": \"DC\",\r\n    \"postalCode\": \"20500\",\r\n    \"country\": \"US\",\r\n    \"phone\": \"555-555-5555\",\r\n    \"residential\": true\r\n  }\r\n}",
     CURLOPT_HTTPHEADER => array(
       "Authorization: Basic N2VmOTU2OTYxYmZkNDQ5ZGE5MmJmYzIwNmYzMTVjODM6YzI5NWRjMDRmZWQ3NDNmZDhjZDcyNjliODJhM2RhOGI=",
       "Content-Type: application/json"
     ),
   ));  
   $response = curl_exec($curl);
   curl_close($curl);
   echo $response;
}
//Create label 
if(isset($_POST["create-label"])){
   $box = $_POST['id'];
while(list($key,$val) = @each ($box)){
   //Bulk create label
  }
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://ssapi.shipstation.com/orders/createlabelfororder",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n  \"orderId\": '$box[0]',\n  \"carrierCode\": \"fedex\",\n  \"serviceCode\": \"fedex_2day\",\n  \"packageCode\": \"package\",\n  \"confirmation\": null,\n  \"shipDate\": \"2021-04-03\",\n  \"weight\": {\n    \"value\": 2,\n    \"units\": \"pounds\"\n  },\n  \"dimensions\": null,\n  \"insuranceOptions\": null,\n  \"internationalOptions\": null,\n  \"advancedOptions\": null,\n  \"testLabel\": false\n}",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Basic N2VmOTU2OTYxYmZkNDQ5ZGE5MmJmYzIwNmYzMTVjODM6YzI5NWRjMDRmZWQ3NDNmZDhjZDcyNjliODJhM2RhOGI=",
      "Content-Type: application/json"
    ),
  ));
  
  $response = curl_exec($curl);
  $shipresponse = json_decode($response,true);
  curl_close($curl);
  echo $shipresponse["ExceptionMessage"];

} 

if(isset($_POST["void-label"])){
   $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://ssapi.shipstation.com/shipments/voidlabel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"shipmentId\": 1234\n}",
  CURLOPT_HTTPHEADER => array(
   "Authorization: Basic N2VmOTU2OTYxYmZkNDQ5ZGE5MmJmYzIwNmYzMTVjODM6YzI5NWRjMDRmZWQ3NDNmZDhjZDcyNjliODJhM2RhOGI=",
   "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

$shipresponse = json_decode($response,true);
curl_close($curl);
echo $shipresponse["ExceptionMessage"];
}

?>
<script>

function check_uncheck_checkbox(isChecked) {
	if(isChecked) {
		$('input[name="id[]"]').each(function() { 
			this.checked = true; 
		});
	} else {
		$('input[name="id[]"]').each(function() {
			this.checked = false;
		});
	}
}

</script>
<script>

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

</script>