<form id="price_quotes_form"  name="price_quotes_form">

    <div class="form-group">
        <label>Customer Name</label>
        <input class="form-control" name="customer_name" id="quotes_cus_name"type="text" placeholder="Customer Name">
    </div>

    <div class="form-group">
        <label>Customer Email</label>
        <input class="form-control"  name="customer_email"id="quotes_cus_email" type="text" placeholder="Customer Email Id">
    </div>

    <div class="form-group">
        <label>Kms Driven</label>
        <input class="form-control" maxlength="7" name="km_driven" id="quotes_km_driven" type="text" onkeyup="addCommas(this.value,this.id);"onkeypress="return forceNumber(event);" placeholder="Kms" value="<?=indian_currency_form($km_driven)?>">
    </div>
    <div class="form-group">
        <label>Car Price</label>
        <input class="form-control" maxlength="12" name="car_price" id="quotes_car_price" type="text" onkeyup="addCommas(this.value, this.id);" onkeypress="return forceNumber(event);" placeholder="Price" value="<?=indian_currency_form($car_price)?>">
    </div>
    <input  name="car_id" type="hidden"  value="<?=$id?>">
</form>
<button class="btn btn-primary" onclick="shareCarPriceQuotes()">SEND</button>
<span id="quotes_form_error" style="color:red"></span>