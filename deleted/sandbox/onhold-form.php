<div class="ui segment">
<?php
require_once "vendor/autoload.php";  
use GuzzleHttp\Client;
$client = new GuzzleHttp\Client();
try {
       $responseArray = $client->request('GET', 'http://ssapi.shipstation.com/orders?customerName='.$_SESSION['email'].'&orderStatus=on_hold&page=1&pageSize=100', ['auth' => ['7ef956961bfd449da92bfc206f315c83', 'c295dc04fed743fd8cd7269b82a3da8b']]);   
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

<form id="frm-example" action="" method="POST">
<input class="ui blue compact labeled icon button" type="submit" name="restore-order" value="Restore Order">
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
</div>
</form>
<?php
if(isset($_POST["restore-order"])){

   $box = $_POST['id'];
   while(list($key,$val) = @each ($box)){
      $curl = curl_init();
      curl_setopt_array($curl, array(
         CURLOPT_URL => 'ssapi.shipstation.com/orders/restorefromhold',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS =>'{
         "orderId": "'.$val.'"
       }',
         CURLOPT_HTTPHEADER => array(
           'Authorization: Basic N2VmOTU2OTYxYmZkNDQ5ZGE5MmJmYzIwNmYzMTVjODM6YzI5NWRjMDRmZWQ3NDNmZDhjZDcyNjliODJhM2RhOGI=',
           'Content-Type: application/json'
         ),
       ));   
    $response = curl_exec($curl);
     }    
    curl_close($curl);
    $restoreMessage = json_decode($response);
    echo $restoreMessage->message;

    echo "<script>alert('$restoreMessage->message');</script>"; 

    ?>
    <script type="text/javascript">
    window.location.href=window.location.href;
    </script>
    <?php 
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