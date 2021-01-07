<div class="ui segment">
<?php
require_once "vendor/autoload.php";  
use GuzzleHttp\Client;
$client = new GuzzleHttp\Client();
try {
       $responseArray = $client->request('GET', 'http://ssapi.shipstation.com/orders?customerName='.$_SESSION['email'].'&orderStatus=cancelled&page=1&pageSize=100', ['auth' => ['7ef956961bfd449da92bfc206f315c83', 'c295dc04fed743fd8cd7269b82a3da8b']]);   
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
<input class="ui red compact labeled icon button" onClick="return confirm('Are you sure you want to delete?')" type="submit" name="delete-order" value="Delete Permanently">



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
    <tbody > 
 <?php for($x = 0; $x < count($arr_body["orders"]); $x++ ) { ?> 
       <tr >
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

<p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

<input class="ui right floated teal big compact labeled icon button" type="submit" name="label-down" value="Download Label">
<!-- <button class="ui right floated teal big compact labeled icon button"  name="list-order" style="margin-bottom:20px;" id="list-order">
            <i class="plus icon"></i>
              List Order
            </button>  -->
<!-- <p><button>Submit</button></p> -->
</div>
<p><b>Selected rows data:</b></p>
<pre id="example-console-rows"></pre>

<p><b>Form data as submitted to the server:</b></p>
<pre id="example-console-form"></pre>
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