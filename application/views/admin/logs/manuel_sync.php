<?php  ?>
<style media="screen">
  tr, td:not(.text-left), th:not(.text-left) {
    text-align: center;
  }
  .progress {margin-bottom: 0px;}
  .progress, .progress-bar  {height: 32px; line-height: 32px; font-size: 16.5px}
  .progress-bar-animated {animation: progress-bar-stripes 0.4s linear infinite !important;}
  h3 {margin: 0 !important;}
  .m-2 {margin: 6px 10px;}
  .p-1 {padding: 2.5px 5px;}
  .p-2 {padding: 5px 10px;}
  #import_content {
    max-height: 540px;
    overflow-y: scroll;
    padding: 10px 30px 20px 30px;
  }
  #import_content .col-sm-12 {
    line-height: 16.5px !important;
    font-size: 14.5px !important;
    padding: 4px 0;
    border-bottom: solid 1px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
  }
  #import_content .col-sm-12 span:not(.type){
    white-space: normal;
    width: 100%;
    word-break: break-word;
  }
  #import_content .col-sm-12 span.type {
    background-color: #eee;
    color: black;
    padding: 1.5px 2px;
    margin-right: 5px;
    margin-left: 5px;
  }
  #import_content .col-sm-12 span.type.red {
    background-color: red;
    color: white;
  }
  #import_content .col-sm-12 span.type.green {
    background-color: green;
    color: white;
  }
  .new_img {height: 48px; padding: 4px; }
</style>

<div class="box" id="infoo">
    <div class="box-header" style="background-color: #eee; padding-top: 10px; font-size: 16px;">
      Geçen Süre: <span id="uptime">00:00</span>
    </div>
    <div class="box-body p-1">
      <div style="display: flex; align-items:center;">
        <!--
        <div class="form-group" style="margin: 0">
          <input type="checkbox" id="auto_refresh" class="square-purple" checked>
          <label for="auto_refresh" class="option-label" style="margin: 0 5px">Yenileme</label>
        </div>
        -->
        <button id="tum_urunler" class="btn btn-primary m-2" type="button" onclick="getAllProducts()">Tüm Ürünler Çek ve Aktar</button>
        <h4 class="m-2" id="tum_urunler_title"></h4>
      </div>
    </div>
</div>

<div class="box p-2" id="box_error" style="display:none">

</div>

<div class="box" id="import_div" style="display:none">
    <div class="box box-primary">
      <div class="box-header" style="background-color: #eee; padding-top: 10px; padding-bottom: 10px; font-size: 16px;">
        Aktarım Durumu : <span id="div_percent">0 %</span>
      </div>
      <!-- /.progress -->
      <div class="progress import_progress" style="display:none">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="progressbar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
      </div> <!-- /.progress -->
      <div class="box-header" style="background-color: #eee; padding-top: 8px; padding-bottom: 8px; font-size: 16px;">
        <span id="isuccess">0</span> Başarılı, <span id="ierror">0</span> Başarısız
      </div> <!-- box-header -->
      <div class="box-body row" id="import_content">

      </div> <!-- import_content -->
    </div>
</div>

<script type="text/javascript">

var nebim_getproducts_count = 0;
var btn_tum_urunler = $('#tum_urunler');
var text_tum_urunler = $('#tum_urunler_title');
var import_div = $('#import_div');
var import_content = $('#import_content');
var import_progress = $('.import_progress');
var progressbar = $('#progressbar');
var uptime = $('#uptime');
var box_error = $('#box_error');
var div_success = $('#isuccess');
var div_error = $('#ierror');
var c_success = 0;
var c_error = 0;
window.variation_images = null;
window.auto_refresh = false;
async function getAllProducts() {
  Kronometre.baslat();
  box_error.hide().html('');
  btn_tum_urunler.attr('disabled', 'disabled');
  text_tum_urunler.text('Lütfen Bekleyiniz....');
  import_content.html('');
  await $.ajax({
    url: "<?=base_url()?>ajax_controller/nebim_getproducts_count",
    type: 'POST',
    data: {},
    dataType: 'json',
    error: function(response) {
      if (response.responseText) {
        box_error.show().html(response.responseText);
      }
      text_tum_urunler.text('Bilinmeyen hata oluştu!.');
      Kronometre.bitir();
    },
    success: function(response) {
      text_tum_urunler.text(response.count + ' satır aktarım bulundu');
      nebim_getproducts_count = response.count;
      setTimeout(startImport, 1500);
    },
    timeout: 480000 // sets timeout to 480 seconds
  });
}

async function startImport() {
  import_div.show();
  add_import_content('İçe aktarma işlemleri başladı, işlem tamamlanıncaya kadar sayfayı kapatmayınız!.', 'AKTARMA');
  import_progress.show();
  if (nebim_getproducts_count >= 500) {
    window.auto_refresh = true;
  }
  var index = 1;
  var count = 500;
  while (index <= count) {
  // for (var index = 1; index <= parseInt(count); index++) {
     window.variation_images = null;
     var now_index = (index - 1) * 9;
     var max_index = parseInt(count) * 9;
     progress_change(index, now_index, max_index);
     try {
       await import_product(index);
       if (window.variation_images) {
         var image_index = 0;
         var image_count = window.variation_images.length;
         while (image_index < image_count) {
           //for (var image = 0; image < window.variation_images.length; image++) {
             progress_change(index, now_index + image_index, max_index);
             await image_download(window.variation_images[image_index]).then((res) => {});
           //} // for images
           image_index++;
         } // while
       } // if variation_images
     } catch (e) {
       add_import_content(index + '. satır, Hata oluştu, satır aktarılamadı. HATA: ' + JSON.stringify(e), 'AKTARMA', 'red');
     }
     progress_change(index, now_index + 8, max_index);
  // } //  for
    index++;
  } //  while
  // Taslak
  add_import_content('Aktarılmayan ürünler taslak olarak güncelleniyor..', 'TASLAK', '#ee7600');
  change_products_status();
  await sleep(4000);
  write_import_file();

  setTimeout(function() {
    add_import_content('İçe aktarma işlemleri tamamlandı!.', 'AKTARMA');
    Kronometre.bitir();
    progressbar.removeClass('progress-bar-animated').removeClass('progress-bar-striped').text('Aktarımlar Tamamlandı');
    if (window.auto_refresh) {
      add_import_content('Lütfen Bekleyiniz, işlemler yenileniyor..', 'AKTARMA');
    }
    setTimeout(function () {
      if (window.auto_refresh) {
        window.location.href = "<?=admin_url()?>manuel-sync?run=1";
      }
    }, 1500);
  }, 1500);
}

async function import_product(index = 1) {
  return await $.ajax({
    url: "<?=base_url()?>ajax_controller/nebim_getproducts_manual",
    type: 'POST',
    data: {},
    dataType: 'json',
    async: true,
    error: function(response) {
      add_import_content(index + '. satır, ' + response.responseText, 'URUN', 'red');
      return response;
    },
    success: function(response) {
      if (response.status == 'success') {
        window.variation_images = response.images;
      } // if response
      add_import_content('SKU: ' + response.model_kodu + ' ' + response.options + ' >> ' + response.message, 'URUN', (response.status == 'success' ? 'green':'red'));
      return response;
    },
    timeout: 1000 * 30 // 30 sn
  });
}


function write_import_file() {
  $.ajax({
    url: "<?=base_url()?>ajax_controller/nebim_import_log_file",
    type: 'POST',
    data: {
      import_html: $('#import_content').html()
    },
    dataType: 'json',
    timeout: 1000 * 15 // 15 sn
  });
}
function change_products_status() {
  $.ajax({
    url: "<?=base_url()?>ajax_controller/nebim_products_not_in_status",
    type: 'POST',
    data: {},
    dataType: 'json',
    timeout: 1000 * 30 // 30 sn
  });
}
function image_download(image) {
  return new Promise(resolve => setTimeout(function() {
    //add_import_content(image.url + ' resmi için işlemler yapılıyor..', 'IMG');
    try {
      $.ajax({
        url: "<?=base_url()?>ajax_controller/nebim_varitation_image_download",
        type: 'POST',
        data: {
          image_id: image.id,
          image_index: image.index,
          image_url: image.url
        },
        async: true,
        dataType: 'json',
        error: function(response) {
          add_import_content(image.url + ' resmi kayıt edilemedi. <a target="_blank" href="'+image.url+'">-Yeni Sekmede Aç-</a>', 'IMG', 'red');
          resolve();
        },
        success: function(response) {
          var html_image = '';
          if (response.status == 'success') {
            html_image = '<img class="new_img" src="'+response.new_url+'">';
          }
          add_import_content(html_image + image.url + ' ' + response.message + ' <a target="_blank" href="'+image.url+'">-Yeni Sekmede Aç-</a>', 'IMG', (response.status == 'success' ? 'green':'red'));
          resolve();
        },
        timeout: 1000 * 30 // 30 sn
      });
    } catch (e) {
      add_import_content(image.url + ' resmi için işlem yapılamadı!.', 'IMG', 'red');
      resolve();
    }
  }, 250));
}

function add_import_content(text, type = 'AKTARMA', color = 'black') {
  if (color == 'green') {
    c_success++;
    div_success.text(c_success);
  } else if (color == 'red') {
    c_error++;
    div_error.text(c_error);
  }
  import_content.prepend('<div class="col-sm-12">'+current_time()+' <span class="type '+color+'">'+type+': </span><span style="color:'+color+'">'+text+'</span></div>');
}
function progress_change(index, now_index, total) {
  var progress = (((now_index + 1) * 100) / total).toFixed(1);
  progressbar.css('width', progress +'%').attr('aria-valuenow', progress).text(progress + ' %');
  var bilgi_index = (now_index - ((index - 1) * 9));
  $('#div_percent').text(index + '. satır, ' + (bilgi_index > 0 ? bilgi_index + '. resim':''));
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
function current_time() {
  var currentdate = new Date();
  return currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
}
function Kronometre (t,i){this.gercekSaniye=i||0,this.saniye=i||0,this.interval,this.baslat=function(){this.sayacElem=document.getElementById(t),this.interval||(this.sayac(),this.interval=setInterval(this.sayac.bind(this),1e3))},this.sayac=function(){var t=this.saniye,i=parseInt(t/3600)%24,s=parseInt(t/60)%60,a=t%60;this.sayacElem.innerHTML=(i<10?"0"+i:i)+":"+(s<10?"0"+s:s)+":"+(a<10?"0"+a:a),this.saniye+=1},this.duraklat=function(){clearInterval(this.interval),this.interval=null},this.bitir=function(){this.duraklat(),this.saniye=this.gercekSaniye}};
var Kronometre = new Kronometre('uptime');

</script>
<?php if (input_get('run') == '1'): ?>
<script type="text/javascript">setTimeout(getAllProducts, 500);</script>
<?php endif;
