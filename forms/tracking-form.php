
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="./deleted/sandbox/dataTables.checkboxes.css">
  <script src="./deleted/sandbox/dataTables.checkboxes.min.js"></script>
<!-- Footer styles starts-->
  <link rel="stylesheet" type="text/css" href="./footer_files/reset.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/site.css">

  <link rel="stylesheet" type="text/css" href="./footer_files/container.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/grid.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/header.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/image.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/menu.css">

  <link rel="stylesheet" type="text/css" href="./footer_files/divider.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/list.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/segment.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/dropdown.css">
  <link rel="stylesheet" type="text/css" href="./footer_files/icon.css">
  <?php   
  $textspace = "";
  $trackStatus = "";
  $estDelivery = "";
  $carrierCode = "";
  $trackDesc = "";
  if(array_key_exists('check-status', $_POST)) { 
            
    $trackingNumber   = $_POST['tracking_number'];   
    $carrierCode = $_POST['carrier_code'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'api.shipengine.com/v1/tracking?carrier_code='.$carrierCode.'&tracking_number='.$trackingNumber,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'API-Key: TEST_m4tuss0r6KhLAiUa4bLE3gtznD0g2A5IYWnkxwu23x0'
    ),
 ));
    $response = curl_exec($curl);
    $trackInfo = json_decode($response,true);
    $trackDesc = $trackInfo["status_description"];
    $trackStatus = $trackInfo["carrier_status_description"];
    $estDelivery = $trackInfo["estimated_delivery_date"];   
    curl_close($curl);
    //echo $response;
 }            
?>
<form id="updateOrder" class="ui form" method= "POST">

  <h4 class="ui dividing header" >Tracking Information</h4>
  <div class="field">
    
    <div class="two fields">
     <div class="two fields" style="margin-left:8px;">     
      <select class="ui dropdown" name="carrier_code">
        <option value="">Carrier</option>
        <option value="usps">U.S. Postal Service</option>
        <option value="fedex">FedEx</option>
        <option value="stamps_com">Stamps.com</option>
      </select>
      <div class="field">
      <img src="assets/usps.png" style="width:50px;height:50px" alt="fedex-logo">
      <img src="assets/fedex.png" style="width:50px;height:50px" alt="fedex-logo">
      <img src="assets/stamps.gif" style="width:50px;height:50px" alt="fedex-logo">
      
      </div>
      </div>
    </div>
    <label>Tracking Number</label>
    <div class="field">
    <input type="text" name="tracking_number" placeholder="Tracking Number" value="">
    </div>
    <input class="ui blue button" type="submit" name="check-status" id="check-status" value="Check Status" /><br/>
    <div class="ui form" style="margin-top:76px;z-index:-1">
  <div class="field">
    <label></label>
    <textarea id='track_message' name="track_message"><?php
    echo $trackDesc;
    echo "\n";
    echo $trackStatus;
    echo "\n";
    echo "Estimated Delivery Date:" .$estDelivery ;
    ?>
</textarea>
  </div>    
</div>
  </div>
 
  </div>

  </form>
<!-- to avoid multiple data enties make rest inside of form -->
