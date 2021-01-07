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
  ?>

<form id="updateOrder" class="ui form" method= "POST">

  <h4 class="ui dividing header" style="margin-top:72px;text-align:center">Shipping Information</h4>
  <div class="field">
    <label>E-Mail</label>
    <div class="two fields">
      <div class="field">
        <input type="text" name="email" placeholder="Email" value="<?php echo $v; ?>">
      </div>
    </div>
  </div>
  <div class="field">
    <label>Address</label>
    <div class="fields">
      <div class="sixteen wide field">
        <input type="text" name="address1" placeholder="Address Bar #1">
      </div>
    </div>
    <div class="fields">
      <div class="sixteen wide field">
        <input type="text" name="address2" placeholder="Address Bar #2">
      </div>
    </div>
    
  </div>
  <div class="two fields" style="z-index:99;">
    <div class="field">
      <label>State</label>
      <select class="ui fluid dropdown">
        <option value="">State</option>
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DE">Delaware</option>
    <option value="DC">District Of Columbia</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
    <option value="IA">Iowa</option>
    <option value="KS">Kansas</option>
    <option value="KY">Kentucky</option>
    <option value="LA">Louisiana</option>
    <option value="ME">Maine</option>
    <option value="MD">Maryland</option>
    <option value="MA">Massachusetts</option>
    <option value="MI">Michigan</option>
    <option value="MN">Minnesota</option>
    <option value="MS">Mississippi</option>
    <option value="MO">Missouri</option>
    <option value="MT">Montana</option>
    <option value="NE">Nebraska</option>
    <option value="NV">Nevada</option>
    <option value="NH">New Hampshire</option>
    <option value="NJ">New Jersey</option>
    <option value="NM">New Mexico</option>
    <option value="NY">New York</option>
    <option value="NC">North Carolina</option>
    <option value="ND">North Dakota</option>
    <option value="OH">Ohio</option>
    <option value="OK">Oklahoma</option>
    <option value="OR">Oregon</option>
    <option value="PA">Pennsylvania</option>
    <option value="RI">Rhode Island</option>
    <option value="SC">South Carolina</option>
    <option value="SD">South Dakota</option>
    <option value="TN">Tennessee</option>
    <option value="TX">Texas</option>
    <option value="UT">Utah</option>
    <option value="VT">Vermont</option>
    <option value="VA">Virginia</option>
    <option value="WA">Washington</option>
    <option value="WV">West Virginia</option>
    <option value="WI">Wisconsin</option>
    <option value="WY">Wyoming</option>
      </select>
    </div>
    <div class="field">
    <label>Country</label>
    <div class="two fields">
      <div class="field">
        <input type="text" name="country" placeholder="Country">
      </div>
    </div>
  </div>
  <input class="ui green button" type="submit" name="update-order" id="update-order" value="Update Order" /><br/>

  </form>
<!-- to avoid multiple data enties make rest inside of form -->
<?php   
$_POST['email'] = $GLOBALS["foo"];


  if(array_key_exists('update-order', $_POST)) { 
            
      $Name   = $_POST['email'];
      $Address1   = $_POST['address1'];
      $Address2   = $_POST['address2'];
      $db_country=$_POST['country'];
      $db_adress=$Address1.' '.$Address2;
      //Database'den Order Key alınacak
     

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ssapi.shipstation.com/orders/createorder",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n  \"orderNumber\": '$Name',\n  \"orderDate\": \"2020-11-11T08:46:27.0000000\",\n  \"paymentDate\": \"2015-06-29T08:46:27.0000000\",\n  \"shipByDate\": \"2015-07-05T00:00:00.0000000\",\n  \"orderStatus\": \"awaiting_shipment\",\n  \"customerId\": 37701499,\n  \"customerUsername\": \"headhoncho@whitehouse.gov\",\n  \"customerEmail\": \"headhoncho@whitehouse.gov\",\n  \"billTo\": {\n    \"name\": \"The President\",\n    \"company\": null,\n    \"street1\": null,\n    \"street2\": null,\n    \"street3\": null,\n    \"city\": null,\n    \"state\": null,\n    \"postalCode\": null,\n    \"country\": null,\n    \"phone\": null,\n    \"residential\": null\n  },\n  \"shipTo\": {\n    \"name\": \"The President\",\n    \"company\": \"US Govt\",\n    \"street1\": '$Address1',\n    \"street2\": '$Address2',\n    \"street3\": null,\n    \"city\": \"Washington\",\n    \"state\": \"DC\",\n    \"postalCode\": \"20500\",\n    \"country\": \"US\",\n    \"phone\": \"555-555-5555\",\n    \"residential\": true\n  },\n  \"items\": [\n    {\n      \"lineItemKey\": \"vd08-MSLbtx\",\n      \"sku\": \"ABC123\",\n      \"name\": \"Test item #1\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 24,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 2,\n      \"unitPrice\": 99.99,\n      \"taxAmount\": 2.5,\n      \"shippingAmount\": 5,\n      \"warehouseLocation\": \"Aisle 1, Bin 7\",\n      \"options\": [\n        {\n          \"name\": \"Size\",\n          \"value\": \"Large\"\n        }\n      ],\n      \"productId\": 123456,\n      \"fulfillmentSku\": null,\n      \"adjustment\": false,\n      \"upc\": \"32-65-98\"\n    },\n    {\n      \"lineItemKey\": null,\n      \"sku\": \"DISCOUNT CODE\",\n      \"name\": \"10% OFF\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 0,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 1,\n      \"unitPrice\": -20.55,\n      \"taxAmount\": null,\n      \"shippingAmount\": null,\n      \"warehouseLocation\": null,\n      \"options\": [],\n      \"productId\": 123456,\n      \"fulfillmentSku\": \"SKU-Discount\",\n      \"adjustment\": true,\n      \"upc\": null\n    }\n  ],\n  \"amountPaid\": 218.73,\n  \"taxAmount\": 5,\n  \"shippingAmount\": 10,\n  \"customerNotes\": \"Please ship as soon as possible!\",\n  \"internalNotes\": \"Customer called and would like to upgrade shipping\",\n  \"gift\": true,\n  \"giftMessage\": \"Thank you!\",\n  \"paymentMethod\": \"Credit Card\",\n  \"requestedShippingService\": \"Priority Mail\",\n  \"carrierCode\": \"fedex\",\n  \"serviceCode\": \"fedex_2day\",\n  \"packageCode\": \"package\",\n  \"confirmation\": \"delivery\",\n  \"shipDate\": \"2015-07-02\",\n  \"weight\": {\n    \"value\": 25,\n    \"units\": \"ounces\"\n  },\n  \"dimensions\": {\n    \"units\": \"inches\",\n    \"length\": 7,\n    \"width\": 5,\n    \"height\": 6\n  },\n  \"insuranceOptions\": {\n    \"provider\": \"carrier\",\n    \"insureShipment\": true,\n    \"insuredValue\": 200\n  },\n  \"internationalOptions\": {\n    \"contents\": null,\n    \"customsItems\": null\n  },\n  \"advancedOptions\": {\n      \"nonMachinable\": false,\n    \"saturdayDelivery\": false,\n    \"containsAlcohol\": false,\n    \"mergedOrSplit\": false,\n    \"mergedIds\": [],\n    \"parentId\": null,\n    \"customField1\": \"Custom data that you can add to an order. See Custom Field #2 & #3 for more info!\",\n    \"customField2\": \"Per UI settings, this information can appear on some carrier's shipping labels. See link below\",\n    \"customField3\": \"https://help.shipstation.com/hc/en-us/articles/206639957\",\n    \"source\": \"Webstore\",\n    \"billToParty\": null,\n    \"billToAccount\": null,\n    \"billToPostalCode\": null,\n    \"billToCountryCode\": null\n  },\n}",
        CURLOPT_HTTPHEADER => array(
          "Host: ssapi.shipstation.com",
          "Authorization: Basic N2VmOTU2OTYxYmZkNDQ5ZGE5MmJmYzIwNmYzMTVjODM6YzI5NWRjMDRmZWQ3NDNmZDhjZDcyNjliODJhM2RhOGI=",
          "Content-Type: application/json"
        ),
      ));          
      $response = curl_exec($curl);
      $data = json_decode($response,true);
      curl_close($curl);
      echo $data["orderId"];
      echo $data["orderKey"];
      echo $data["orderStatus"];
      
        
      $db_orderId= $data["orderId"];
      $db_orderKey= $data["orderKey"];
      echo $db_orderKey;
      $db_orderDate= $data["orderDate"];

      $db_orderStatus= $data["orderStatus"];
      $conn = mysqli_connect("localhost", "root", '', "shipping_automation");
      
      $insertSql ="INSERT INTO `order_info`  VALUES ('$db_orderId','$db_orderKey','2015-07-05','$db_orderStatus','$db_adress','$db_state','$db_country','1','adreress','adreress','adreress')"; 
     
      if (mysqli_query($conn, $insertSql)) {
        echo "Record added successfully";
      } else {
        echo "Error record: " . mysqli_error($conn);
      }

      mysqli_close($conn);
?>
      <script type="text/javascript">
      window.location.href=window.location.href;
      </script>
    
<?php
  }            
?>
