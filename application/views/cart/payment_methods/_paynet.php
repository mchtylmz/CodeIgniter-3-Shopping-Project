<?php defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($payment_gateway) && $payment_gateway->name_key == "paynet"):
  $customer = get_cart_customer_data();
  $conversation_id = generate_short_unique_id();
  $callback_url = base_url() . "paynet-post?payment_type=sale&lang=" . $this->selected_lang->short_form . "&conversation_id=" . $conversation_id;
?>
<style media="screen">
select {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-appearance: none;
  -moz-appearance: none;
}
select.minimal {
  background-image:
    linear-gradient(45deg, transparent 50%, gray 50%),
    linear-gradient(135deg, gray 50%, transparent 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 20px) calc(1em + 2px),
    calc(100% - 15px) calc(1em + 2px),
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
}
select.minimal:focus {
  background-image:
    linear-gradient(45deg, #027dbf 50%, transparent 50%),
    linear-gradient(135deg, transparent 50%, #027dbf 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 15px) 1em,
    calc(100% - 20px) 1em,
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
  border-color: #027dbf;
  outline: 0;
}
select:-moz-focusring {
  color: transparent;
  text-shadow: 0 0 0 #000;
}
.card-number {
  background-image: url('<?=base_url()?>assets/img/payment/card.png');
  background-size: auto 50%;
  background-position: 99%;
  background-repeat: no-repeat;
}
.has-error {
  border: dotted 1px red !important;
  box-sizing: border-box !important;
}
.has-success {
  border: dotted 1px green !important;
  box-sizing: border-box !important;
}
.visa {
  background-image: url('<?=base_url()?>assets/img/payment/visa.png') !important;
}
.mastercard {
  background-image: url('<?=base_url()?>assets/img/payment/mastercard.png') !important;
}
.amex {
  background-image: url('<?=base_url()?>assets/img/payment/amex.svg') !important;
}
</style>

    <div class="row">
        <div class="col-12">
            <!-- include message block -->
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>

    <script type="text/javascript"
         class="paynet-button"
         src="https://pts-pj.paynet.com.tr/public/js/paynet-custom.js"
         data-form="#checkout-form"
         data-key="<?=$payment_gateway->public_key?>"
         data-amount="<?=$total_amount?>"
         data-name="<?=$this->general_settings->application_name?>"
         data-no_instalment="false"
         data-description="<?=$this->general_settings->application_name?> Alışveriş">
    </script>
    <form action="<?=$callback_url?>" method="post" name="checkout-form" id="checkout-form">
      <div class="creditCardForm bg-white card border-0">
        <div class="payment p-3">
            <div class="form-group">
                <label for="owner" class="form-control-label"><?=trans('card_placeholder_name')?></label>
                <input type="text" name="holderName" class="form-control auth-form-input" placeholder="<?=trans('card_placeholder_name')?>" data-paynet="holderName" autocomplete="off" required>
            </div>
            <div class="form-group" id="card-number-field">
                <label for="kart_numara" class="form-control-label"><?=trans('card_number')?></label>
                <input type="text" name="cardNumber" class="form-control auth-form-input card-number" maxlength="19" placeholder="0000 0000 0000 0000" id="card_number" data-paynet="number" autocomplete="off" required>
            </div>
            <div class="form-row">
              <div class="col-8 form-group" id="expiration-date">
                <label class="form-control-label"><?=trans('expiry_date')?></label>
                <div class="row">
                  <div class="col-lg-5 col-md-5 col-sm-5 col-5 mobile-1">
                    <select class="form-control auth-form-input minimal" style="height: 40px !important" data-paynet="exp-month" name="month" autocomplete="off" id="exp-month" required>
                      <option value="" hidden><?=trans('card_month')?></option>
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div> <!-- col-6 -->
                  <div class="col-lg-5 col-md-5 col-sm-5 col-5 mobile-2">
                    <select class="form-control auth-form-input minimal" style="height: 40px !important" data-paynet="exp-year" name="year" autocomplete="off" id="exp-year" required>
                      <option value="" hidden><?=trans('card_year')?></option>
                      <?php for ($i = 0; $i < 10; $i++) {
                        echo '<option value="'.date('y', strtotime('+'.$i.' years')).'">'.date('Y', strtotime('+'.$i.' years')).'</option>';
                      } ?>
                    </select>
                  </div> <!-- col-6 -->
                </div> <!-- row -->
              </div> <!-- col -->
              <div class="col-4 form-group">
                <label for="cvv" class="form-control-label">CVV</label>
                <input type="text" name="cvv" class="form-control auth-form-input" maxlength="4" placeholder="000" data-paynet="cvv" id="cvv" autocomplete="off" required>
              </div> <!-- col -->
            </div> <!-- row -->

            <input type="hidden" name="email" data-paynet="email" value="<?=$customer->email?>" readonly>
            <input type="hidden" name="tel" data-paynet="phone" value="<?=$customer->phone_number?>" readonly>

            <div class="form-group text-center mt-3" id="pay-now">
              <button type="submit" id="confirm-button" class="btn btn-lg btn-custom btn-payment mt-2" data-paynet="submit">
                <?= trans("pay_now"); ?>&nbsp;&nbsp;&nbsp;<?= price_currency_format($total_amount, $currency); ?>
              </button>
            </div>
        </div>
      </div>
    </form>

<?php endif; ?>
<?php // reset_flash_data(); ?>
<script src="https://cdn.jsdelivr.net/npm/payform@1.4.0/dist/payform.min.js" charset="utf-8"></script>
<script>
Paynet.events.validationError(function (valid) {
    if (!valid.ok) {
      swal({
          text: valid.message,
          icon: "warning",
          buttons: [null, mc20bt99_config.sweetalert_ok]
      });
    }
});
Paynet.events.onCreateToken(function (valid) {
    if (!valid.ok) {
      swal({
          text: valid.message,
          icon: "warning",
          buttons: [null, mc20bt99_config.sweetalert_ok]
      });
      $('#confirm-button').attr('disabled', 'disabled').css('opacity', '0.75');
    }
});
$("#card_number").on("change paste keyup keypress keydown",function() {
  var input = document.getElementById('card_number');
  payform.cardNumberInput(input);
  if (payform.validateCardNumber(input.value)) {
      $(this).addClass('has-success').removeClass('has-error');
  } else {
      $(this).removeClass('has-success').addClass('has-error');
  }
  $(this).removeClass('mastercard amex visa');
  if (['visa', 'mastercard', 'amex'].includes(payform.parseCardType(input.value))) {
      $(this).addClass(payform.parseCardType(input.value));
  }
  var cardNumber = cleanCardNumber($(this).val());
  var currentCardBin = $(this).data("current-card-bin");
  var newCardBin = cardNumber.substr(0, 6); //Kart bini kart numarasının ilk 6 karakteridir
  if(newCardBin != currentCardBin)
  {
    $(this).data("current-card-bin", newCardBin);
    //  loadInstalments();
  }
});


//3D Ödeme seçeneği butonuna tıklandığında, formun post edileceği adresi değiştirir
//  $("#checkout-form").attr("action", "DemoTransactionV2TdsInitial.php");
/*
$("#instalments-div").on("click", "input", function(){
  var selectedInstalment = $(this).val();
  $("#instalment").val(selectedInstalment);
  $("#checkout-form").validate().element("#instalment");
})

function loadInstalments() {
  var $instalmentsDiv = $("#instalments-div");
  var cardNumber = cleanCardNumber($("#card_number").val());
  var cardBin = cardNumber.substr(0, 6);
  if(!isBinValid(cardBin)) {
    $instalmentsDiv.html("Taksitleri görmek için kart numaranızı giriniz.");
    $("#instalment").val("");
    return;
  }
  $instalmentsDiv.html("Taksit seçenekleri yükleniyor...");
  $.get("DemoTransactionV2Instalments.php", {cardBin:cardBin})
    .done(function(data) {
      $instalmentsDiv.html(data);
    })
    .fail(function() {
      $instalmentsDiv.html("");
    })
}
*/
function cleanCardNumber(val) {
  if (val) {
      return val.replace(/\ /g, '').replace(/-/g, '');
  }
  return val;
}

function isBinValid(cardBin)
{
  var isOnlyDigit = /^\d+$/.test(cardBin);
  return cardBin.length == 6 && isOnlyDigit;
}

</script>
