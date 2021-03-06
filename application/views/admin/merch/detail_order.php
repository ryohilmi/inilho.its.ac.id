<!-- Begin Page Content -->
<div class="container text-center text-gray-800">
  <h4 class="mb-3 text-left">Pesanan : <?= $data_order['no_order'] ?></h4>

  <?= $this->session->flashdata('message'); ?>
  <?= $this->session->unset_userdata('message'); ?>

  <?= form_open('merch/editStatus/' . $data_order['no_order']); ?>
  <div class="invoice-details text-left mt-2">
    <div class="row">
      <div class="col">
        <p><strong>Nama :</strong> <?= $data_order['receiver']; ?></p>
        <p><strong>Alamat : </strong><?= $data_order['address'] ?></p>
        <p><strong>Kota : </strong><?= $data_order['city'] . ', ' . $data_order['province'] . ' - ' . $data_order['postal'] ?></p>
        <p><strong>No Telp : </strong><?= $data_order['phone'] ?></p>
      </div>
      <div class="col">
        <label for="status"><strong>Status :</strong></label>
        <select class="form-control" id="status" name="status">
          <option value="<?= $data_order['status'] ?>">Saat ini : <?= $data_order['status'] ?></option>
          <option value="Belum Bayar">Belum Bayar</option>
          <option value="Sudah Bayar">Sudah Bayar</option>
          <option value="Sedang Diproses">Sedang Diproses</option>
          <option value="Ditolak">Ditolak</option>
          <option value="Selesai">Selesai</option>
        </select>
      </div>
    </div>
  </div>
  <div class="table-responsive invoice-cart">
    <table class="table mt-2 table-hover bg-white text-dark" style="color: black;">
      <thead>
        <tr class="text-center">
          <th scope="col">Nama</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Berat</th>
          <th scope="col">Harga Satuan</th>
          <th scope="col">Harga</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php
        $subtotal = 0;
        ?>
        <?php foreach ($order_detail as $items) : ?>
          <?php
          $product = $this->db->get_where('tabel_product', ['id' => $items['product_id']])->row_array();
          $subtotal += ($product['price'] * $items['qty']);
          ?>
          <tr>
            <td class="text-left">
              <?= $items['product'] ?><br>
              <?php if ($items['options'] != 'null') {
                echo 'Size : ' . $items['options'];
              } ?>
            </td>
            <td><?= $items['qty'] ?></td>
            <td><?= number_format($product['weight'], 0) ?> gr.</td>
            <td>
              <div class="d-flex justify-content-between">
                <span>Rp. </span>
                <span><?= number_format($product['price'], 2) ?></span>
              </div>
            </td>
            <td>
              <div class="d-flex justify-content-between">
                <span>Rp. </span>
                <span><?= number_format(($product['price'] * $items['qty']), 2) ?></span>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-right font-weight-bold">Sub Total : </td>
          <td class="d-flex justify-content-between">
            <span>Rp. </span>
            <span><?= number_format($subtotal, 2) ?></span>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-uppercase text-left"><strong>Kurir : </strong> <?= $data_order['courier'] . ' - ' . $data_order['package'] ?></td>
          <td><?= number_format($data_order['weight'], 0) ?> gr.</td>
          <td></td>
          <td class="d-flex justify-content-between">
            <span>Rp. </span>
            <span><?= number_format($data_order['shipping'], 2) ?></span>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="text-right font-weight-bolder">Total Payment : </td>
          <td class="d-flex justify-content-between">
            <span>Rp. </span>
            <span><?= number_format($data_order['total'], 0) ?></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <input type="hidden" name="no_order" value="<?= $data_order['no_order']; ?>">
  <input type="hidden" name="receiver" value="<?= $data_order['receiver']; ?>">
  <input type="hidden" name="phone" value="<?= $data_order['phone']; ?>">
  <input type="hidden" name="address" value="<?= $data_order['address']; ?>">
  <input type="hidden" name="province" value="<?= $data_order['province']; ?>">
  <input type="hidden" name="city" value="<?= $data_order['city']; ?>">
  <input type="hidden" name="postal" value="<?= $data_order['postal']; ?>">
  <input type="hidden" name="courier" value="<?= $data_order['courier']; ?>">
  <input type="hidden" name="package" value="<?= $data_order['package']; ?>">
  <input type="hidden" name="weight" value="<?= $data_order['weight']; ?>">
  <input type="hidden" name="shipping" value="<?= $data_order['shipping']; ?>">
  <input type="hidden" name="subtotal" value="<?= $data_order['subtotal']; ?>">
  <input type="hidden" name="total" value="<?= $data_order['total']; ?>">
  <a href="<?= base_url('merch/order') ?>" class="btn btn-warning mb-5">
    <i class="fas fa-edit pr-3"></i>Kembali
  </a>
  <button type="submit" class="btn btn-primary mb-5">
    <i class="fas fa-edit pr-3"></i>Ubah Status Pemesanan!
  </button>
  <?= form_close(); ?>
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