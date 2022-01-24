<?php
if (!empty($payment_gateway) && $payment_gateway->name_key == "paynet"):
  require_once APPPATH . "third_party/paynet/PaynetClass.php";
  $paynet_total_amount = number_format($total_amount, 2, ',', '.');
  $customer = get_cart_customer_data();
  $conversation_id = generate_short_unique_id();
  $callback_url = base_url() . "paynet-post?pos=paynet&payment_type=sale&lang=" . $this->selected_lang->short_form . "&conversation_id=" . $conversation_id;
  $script_url = 'https://pj.paynet.com.tr/public/js/paynet-custom.js';
  if ($payment_gateway->environment == 'sandbox') {
    $script_url = 'https://pts-pj.paynet.com.tr/public/js/paynet-custom.js';
  }
  $show_paynet = true;
  try {
    $this->session->set_userdata('paynet_amount', $paynet_total_amount);
    if ($paynet_installments = json_decode($payment_gateway->installments, true)) {
      $paynet_installments_implode = implode(',', $paynet_installments);
    }
  } catch (Exception $err) {
      $show_paynet = false; ?>
      <div class="alert alert-danger" role="alert">
          <?= $err->getMessage(); ?>
      </div>
  <?php } ?>

  <?php if ($show_paynet): ?>

  <style media="screen">
  select {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
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
  .instalments th {text-align: left !important;}
  .instalments td {padding-left: 5px;text-align: left !important; }
  .table, .bank_logo {max-width: 480px;}
  .bank_logo {background-color: #f2f6f6; padding: 2px}
  .pl-3 {padding-left: 9px;}
  .pl-1 {padding-left: 3px;}
  .col-12:empty {
    display: none
  }
  </style>

  <div class="row">
      <div class="col-12 p-0">
          <?php $this->load->view('product/_messages'); ?>
      </div>
  </div>

  <script type="text/javascript"
       class="paynet-button"
       src="<?=$script_url?>"
       data-form="#checkout-form"
       data-key="<?=$payment_gateway->public_key?>"
       data-amount="<?=$paynet_total_amount?>"
       data-name="<?=$this->general_settings->application_name?>"
       data-add_commission_amount="<?=$payment_gateway->commission ? 'true':'false'?>"
       data-reference_no="<?=$conversation_id?>"
       data-show_tds_error="true"
       data-installments="<?=$paynet_installments_implode ?? '0'?>"
       data-description="<?=$this->general_settings->application_name?> Alışveriş">
  </script>
  <!--
  data-add_commission_amount="true" sor
  data-installments="0,2,3,6,9,12" sor
  -->
  <form action="<?=$callback_url?>" method="post" name="checkout-form" id="checkout-form">
    <div class="creditCardForm bg-white card border-0">
      <div class="payment p-3">
          <div class="form-group">
              <label for="owner" class="form-control-label"><?=trans('card_placeholder_name')?></label>
              <input type="text" name="holderName" class="form-control auth-form-input" placeholder="<?=trans('card_placeholder_name')?>" data-paynet="holderName" value="<?=old('holderName')?>" autocomplete="off" required>
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
                  <select class="form-control auth-form-input" style="height: 42.5px !important" data-paynet="exp-month" name="month" autocomplete="off" id="exp-month" required>
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
                  <select class="form-control auth-form-input" style="height: 42.5px !important" data-paynet="exp-year" name="year" autocomplete="off" id="exp-year" required>
                    <option value="" hidden><?=trans('card_year')?></option>
                    <?php for ($i = 0; $i < 12; $i++) {
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

          <div id="instalments-div" style="display:none;">
            <center>
              <div class="bank_logo">
                <img src="" id="bank_logo" style="height: 42px">
              </div>
              <table class="table table-striped instalments">
                <thead>
                  <tr>
                    <th scope="col">Taksit</th>
                    <th scope="col">Tutar</th>
                    <th scope="col">Toplam</th>
                  </tr>
                </thead>
                <tbody class="installment-table">
                </tbody>
              </table>
            </center>
          </div>

          <input type="hidden" name="email" data-paynet="email" value="<?=$customer->email?>" readonly>
          <input type="hidden" name="tel" data-paynet="phone" value="<?=$customer->phone_number?>" readonly>
          <input type="hidden" name="sess_amount" value="<?=encrypt_decrypt('lock', $paynet_total_amount)?>">
          <input type="hidden" name="sess_price" value="<?=encrypt_decrypt('lock', $total_amount)?>">
          <input type="hidden" name="sess_id" value="<?=encrypt_decrypt('lock', $this->auth_user->id ?? 0)?>">
          <input type="hidden" name="installmentKey" id="installmentKey" value="0">
          <div class="form-group text-center mt-3" id="pay-now">
            <button type="submit" id="confirm-button" class="btn btn-lg btn-custom btn-payment mt-2" data-paynet="submit">
              <?= trans("pay_now"); ?>&nbsp;&nbsp;&nbsp;<?= price_currency_format($total_amount, $currency); ?>
            </button>
          </div>
      </div>
    </div>
  </form>

  <?php endif; ?>
  <?php reset_flash_data(); ?>

  <script src="<?= base_url(); ?>assets/js/payform.min.js"></script>
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
      // loadInstalments();
    }
  });

  ///müşteri kartın ilk 6 hanesini girdiğinde oran
///bilgisini göstermek için kullanılır.
Paynet.events.onCheckBin(function (d) {

     $('.installment-table').html('');
     try {
       d.bank.installments.sort(function (current, next) {
             if (current.instalment > next.instalment) return 1;
             if (current.instalment < next.instalment) return -1;
             return 0;
       });

       $('#bank_logo').attr('src', d.bank.logoUrl);
       $('.bank_logo').show();
       ///seçtiği kart bilgilerine göre oran gösterilir
       for (var i = 0; i < d.bank.installments.length; i++) {
         var input = '<tr>'
                   + '<td><div class="custom-control custom-radio">'
                   + '<input type="radio" class="custom-control-input" name="installment" id="i'+i+'" value="'
                   + d.bank.installments[i].instalment_key + '" ' + (i==0 ? 'checked':'') + ' required>'
                   + '<label class="custom-control-label pl-1" for="i'+i+'">' + d.bank.installments[i].desc + '</label>'
                   + '</div></td><td>'
                   + (i != 0 ? (d.bank.installments[i].instalment +'  x  '+ d.bank.installments[i].instalment_amount) + ' TL':'')
                   + '</td><td>'
                   + d.bank.installments[i].total_amount + ' TL'
                   + '</td>'
                   + '</tr>';
           $(".installment-table").append(input);
           $('#installmentKey').val(d.bank.installments[0].instalment_key);
        }
        $('#instalments-div').show();
     } catch (e) {
        $('#instalments-div').hide();
     }
});
///müşterinin seçtiği oranı belirleme
$(document).on("click", "input[name=installment]:radio",function () {
    $('#installmentKey').val($(this).val());
});

  //3D Ödeme seçeneği butonuna tıklandığında, formun post edileceği adresi değiştirir
  //  $("#checkout-form").attr("action", "DemoTransactionV2TdsInitial.php");
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
    $.get("<?=base_url()?>paynet-list-instalments", {cardBin:cardBin}).done(function(data) {
      console.log(data);
        $instalmentsDiv.html(data);
    }).fail(function() {
        $instalmentsDiv.html("");
    });
  }

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


<?php endif;  // $show_paynet ?>
