<!-- Begin Page Content -->
<div class="container text-center text-gray-800">
  <h1 class="mb-3 ">Ini Lho ITS! Official Merchandise</h1>
  <h3 class="mb-3 text-left">Pengaturan Pengiriman</h3>

  <?= $this->session->flashdata('message'); ?>
  <?= $this->session->unset_userdata('message'); ?>
  <?= form_open('merch/settings'); ?>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="sender">Nama Pengirim</label>
        <input type="text" class="form-control" id="sender" name="sender" value="<?= $data_store['sender'] ?>">
        <?= form_error('sender'); ?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="phone">No Telpon</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?= $data_store['phone'] ?>">
        <?= form_error('phone'); ?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="province">Provinsi</label>
        <select name="province" id="province" class="form-control"></select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="city">Kota</label>
        <select name="city" id="city" class="form-control">
          <option value="<?= $data_store['city'] ?>"><?= $data_store['city'] ?></option>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="addres">Alamat Pengirim</label>
    <textarea class="form-control" id="addres" rows="3" name="address"><?= $data_store['address'] ?></textarea>
    <?= form_error('address'); ?>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Atur Pengiriman!</button>
  </form>
</div>

<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
  $(document).ready(function() {
    // Province Data
    $.ajax({
      url: '<?= base_url('shipping/province') ?>',
      type: "POST",
      success: function(result_province) {
        // console.log(result_province);
        $('#province').html(result_province);
      }
    });

    // City Data
    $('#province').on('change', function() {
      var get_province = $("option:selected", this).attr("id_province");

      $.ajax({
        url: '<?= base_url('shipping/city') ?>',
        type: "POST",
        data: 'id_province=' + get_province,
        success: function(result_city) {
          // console.log(result_city);
          $('#city').html(result_city);
        }
      });
    });
  });
</script>