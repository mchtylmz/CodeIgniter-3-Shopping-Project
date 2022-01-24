<?php  ?>
<style media="screen">
  tr,th,td {
    text-align: center !important;
  }
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("nebim_products"); ?></h3>
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <div class="row table-filter-container">
                          <div class="col-sm-12">
                              <?php echo form_open('', ['method' => 'GET']); ?>
                              <div class="item-table-filter" style="width: 120px; min-width: 120px;">
                                  <label><?php echo trans("status"); ?></label>
                                  <select name="status" class="form-control">
                                      <option value="">Tümü</option>
                                      <option value="0" <?php echo ($this->input->get('status', true) == '0') ? 'selected' : ''; ?>>Beklemde</option>
                                      <option value="1" <?php echo ($this->input->get('status', true) == '1') ? 'selected' : ''; ?>>Başarılı</option>
                                      <option value="2" <?php echo ($this->input->get('status', true) == '2') ? 'selected' : ''; ?>>Başarısız</option>
                                  </select>
                              </div>

                              <div class="item-table-filter">
                                  <label><?php echo trans("sku"); ?></label>
                                  <input name="sku" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('sku', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter">
                                  <label>Cinsiyet</label>
                                  <input name="cinsiyet" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('cinsiyet', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter">
                                  <label>Kategori</label>
                                  <input name="kategori" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('kategori', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter">
                                  <label>Sinif</label>
                                  <input name="sinif" class="form-control" placeholder="...." type="text" value="<?php echo html_escape($this->input->get('sinif', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <div class="item-table-filter">
                                  <label><?php echo trans("search"); ?></label>
                                  <input name="q" class="form-control" placeholder="...." type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                              </div>

                              <input type="hidden" name="user" value="<?=$this->input->get('user', true)?>">
                              <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                  <label style="display: block">&nbsp;</label>
                                  <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                              </div>
                              <?php echo form_close(); ?>
                          </div>
                      </div>
                        <thead>
                        <tr role="row">
                            <th width="20">ModelKodu</th>
                            <th>RenkAdi</th>
                            <th>Beden</th>
                            <th>Cinsiyet</th>
                            <th>Kategori</th>
                            <th>Sinif</th>
                            <th>IlkFiyat</th>
                            <th>Indirim</th>
                            <th>Stok</th>
                            <th>Barkod</th>
                            <th><?=trans('status')?></th>
              							<th class="max-width-120">Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nebim_products as $product): ?>
                            <tr>
                                <td>
                                  <a style="color:#222; text-decoration:underline" target="_blank" href="<?=base_url()?>products?search=<?=$product->ModelKodu?>">
                                    <?=$product->ModelKodu?>
                                  </a>
                                </td>
                                <td><?=$product->RenkAdi?></td>
                                <td><?=$product->Beden?></td>
                                <td><?=$product->Cinsiyet?></td>
                                <td><?=$product->Kategori?></td>
                                <td><?=$product->Sinif?></td>
                                <td><?=$product->IlkFiyat?></td>
                                <td><?=$product->IndirimFiyat?></td>
                                <td><?=$product->Stok?></td>
                                <td><?=$product->Barkod?></td>
                                <td style="padding-top: 10px;">
                                  <?php if ($product->status == 1): ?>
                                    <label class="label label-success"><i class="fa fa-check"></i></label>
                                  <?php elseif ($product->status == 2): ?>
                                    <label class="label label-danger"><i class="fa fa-times"></i></label>
                                  <?php else: ?>
                                    <label class="label label-warning"><i class="fa fa-square"></i></label>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <button class="btn btn-sm bg-purple" type="button" data-toggle="modal" data-target="#Image_<?php echo $product->id; ?>">
                                      Images
              										</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="Image_<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                          <div class="modal-content modal-custom">
                                              <div class="modal-body" style="text-align:left !important">
                                                <div class="list-group">
                                                  <a target="_blank" href="<?=$product->Image1?>" class="list-group-item"><?=$product->Image1?></a>
                                                  <a target="_blank" href="<?=$product->Image2?>" class="list-group-item"><?=$product->Image2?></a>
                                                  <a target="_blank" href="<?=$product->Image3?>" class="list-group-item"><?=$product->Image3?></a>
                                                  <a target="_blank" href="<?=$product->image4?>" class="list-group-item"><?=$product->image4?></a>
                                                  <a target="_blank" href="<?=$product->image5?>" class="list-group-item"><?=$product->image5?></a>
                                                  <a target="_blank" href="<?=$product->image6?>" class="list-group-item"><?=$product->image6?></a>
                                                  <a target="_blank" href="<?=$product->image7?>" class="list-group-item"><?=$product->image7?></a>
                                                  <a target="_blank" href="<?=$product->image8?>" class="list-group-item"><?=$product->image8?></a>
            																		</div>
                                              </div>
                                              <div class="modal-footer">
              						                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Kapat</button>
              						                    </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Modal -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (empty($nebim_products)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-6 text-left">
                <h4><?=trans('total')?>: <?php echo $total ?? 0; ?> </h4>
            </div>
            <div class="col-sm-6 text-right">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
