@extends('layout.app')

@if(session('id') == null || session('role') != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else
  
  @section('sec-css')
  <style type="text/css">
    .buttoned{
      border: 0px;
      background-color: transparent;
      cursor: pointer;
      margin: 0px;
      padding: 0px;
    }
  </style>
  @endsection


  @section('content')
  	@include('layout.admin_header')
    <div id="app" v-cloak>

      <!-- MODAL EDIT DETAIL -->
      <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Edit Detail Report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveReport()" id="form-edit">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="hidden" class="form-control" id="id" v-model="view_report.id" name="id" required>
                      <input type="text" class="form-control" id="name" v-model="view_report.name" name="name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <input type="text" class="form-control" id="description" v-model="view_report.description" name="description" required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="volume">Volume</label>
                      <input type="text" class="form-control" id="volume" v-model="view_report.volume" name="volume" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="unit">Unit</label>
                      <select class="form-control" required="" name= 'unit' id="unit" v-model='view_report.unit'>
                          <option value=''>Pilih Unit</option>
                          <option v-for='(units, index) in allunit' :value="units.data2">@{{ units.data1 }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="time">Waktu Pengerjaan</label>
                      <input type="text" class="form-control" id="time" v-model="view_report.time" name="time" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_clean">Harga Vendor</label>
                      <input type="text" class="form-control" id="price_clean" v-model="view_report.price_clean" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' :readonly="data.vendor_is != 1 ? false : true" required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_dirt">Harga Customer</label>
                      <input type="text" class="form-control" id="price_dirt" v-model="view_report.price_dirt" name="price_dirt" @keyup = 'filter' @keypress = 'isNumber' :readonly="data.customer_is != 1 ? false : true" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH DETAIL -->

      <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Detail</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveAddReport()" id="form-add">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name1">Name</label>
                      <input type="hidden" class="form-control" id="id1" v-model='id' name="reservation_id" required>
                      <input type="hidden" class="form-control" id="id2" v-model='id_step' name="step_id" required>
                      <input type="text" class="form-control" id="name1" name="name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="description1">Keterangan</label>
                      <input type="text" class="form-control" id="description1" name="description" required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="volume1">Volume</label>
                      <input type="text" class="form-control" id="volume1" name="volume" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="unit1">Unit</label>
                      <select class="form-control" required="" name="unit" id="unit1">
                          <option value=''>Pilih Unit</option>
                          <option v-for='(units, index) in allunit' :value="units.data2">@{{ units.data1 }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="time1">Waktu Pengerjaan</label>
                      <input type="text" class="form-control" id="time1" name="time" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_clean1">Harga Vendor</label>
                      <input type="text" class="form-control" id="price_clean1" name="price_clean" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="price_dirt1">Harga Customer</label>
                      <input type="text" class="form-control" id="price_dirt1" name="price_dirt" @keyup = 'filter' @keypress = 'isNumber' required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH TANGGAL -->

      <div class="modal fade" id="addDate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Tanggal Pekerjaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="addDate()" id="form-add-date">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="date">Tanggal</label>
                      <input type="text" class="form-control" v-model='data.date_work' id="date_start" name="date" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL TAMBAH TAHAPAN -->

      <div class="modal fade" id="addStep" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Tahapan Pekerjaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="saveStep()" id="form-add-step">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name_step">Nama Tahapan</label>
                      <input type="text" id="name_step" class="form-control" v-model='add_step.name' name="name" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL EDIT TAHAPAN -->

      <div class="modal fade" id="editStep" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #ffc3c3;">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Tahapan Pekerjaan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="updateStep(view_report.id)" id="form-update-step">
              <div class="modal-body">
                <div class="row align-items-center">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="name_step">Nama Tahapan</label>
                      <input type="text" id="name_step" class="form-control" v-model='view_report.name' name="name" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
            <div class="card">
      				<div class="card-header">
      					<h3 class="text-center my-4"><strong>KONFIRMASI LAPORAN SURVEYER</strong></h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-12">
                        <label class="font-12 m-0">Kode Booking</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.code }}</strong></label>
                      </div>
                      <div class="col-12">
                        <label class="font-12 m-0">Tanggal Survey</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.date }} @{{ data.time }}</strong></label>
                      </div>
                      <div class="col-12">
                        <label class="font-12 m-0">Nama Pelanggan</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.name }}</strong></label>
                      </div>
                      <div class="col-12">
                        <label class="font-12 m-0">Vendor</label>
                        <br>
                        <label class="font-14"><strong>@{{ data.vendor ? data.vendor.name : '-' }}</strong></label>
                      </div>
                      <div class="col-12">
                        <label class="font-12">Tanggal Mulai</label>
                        <br>
                        <strong>
                          <label class="m-0" v-if= 'data.date_work != null' >
                            @{{ data.date_work }},
                            <button class="mb-2 buttoned" data-toggle="modal" data-target="#addDate" v-if='data.locked == "offer"'><strong>Ubah Tanggal</strong></button><br>
                          </label>
                          <label class="m-0" v-if= 'data.date_work == null' >
                            <button class="mb-2 buttoned" data-toggle="modal" data-target="#addDate"><strong>Belum Ditentukan, Ubah Tanggal</strong></button>
                          </label>
                        </strong>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-6 align-self-center text-center">
                    <div class="row" v-if='data.customer_is == 0'>
                      <div class="col-md-12">
                        <label class="btn-block">Penawaran</label>
                      </div>
                      <div class="col-md-12">
                        <button class="btn btn-success mb-2" style="font-size: 12px;" @click='sendMail(data.id)'>Kirim Customer</button><br>
                        <!-- <a href="{{ url('report/printOrderCustomer') }}/{{ $id }}" class="btn btn-warning" style="font-size: 12px;">Kirim Vendor</a> -->
                      </div>
                    </div> 
                    <div class="row">
                      <div class="col-md-12">
                        <label class="btn-block">Print</label>
                      </div>
                      <div class="col-md-12">
                        <a href="{{ url('report/printVendor') }}/{{ $id }}" class="btn btn-info mb-2" style="font-size: 12px;">Print Penawaran</a><br>
                        <a href="{{ url('report/printEngagement') }}/{{ $id }}" class="btn btn-danger" style="font-size: 12px;">Print Akad</a>
                      </div>
                    </div>
                  </div>
                </div>

      				</div>
    					<div class="card-body">

                <!-- INFORMASI RESERVASI -->

                <div class="row">
                  <div class="col-md-12 mb-4 mt-3 text-center">
                    <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Informasi Reservasi</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nama Customer</label>
                      <input type="text" class="form-control" id="name" v-model='data.name' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone_number">No. Handphone</label>
                      <input type="text" class="form-control" id="phone_number" v-model='data.phone_number' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" v-model='data.email' disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ktp">No Identitas</label>
                      <input type="text" class="form-control" id="ktp" v-model='partner.ktp' disabled>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="province">Alamat Pekerjaan</label>
                        <textarea rows="3" class="form-control" id="allPlace" name="allPlace" v-model='allPlace' disabled=""></textarea>
                    </div>
                  </div>
                </div>

                <!-- TAHAPAN PEKERJAAN -->

    						<div class="row">
                  <div class="col-md-12 mb-4 mt-3 rounded text-center">
                    <div class="pt-3 pb-3 pl-2 pr-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Tahapan Pekerjaan</label>
                      <i class="btn btn-success fa fa-plus mt-1 float-md-right " data-toggle="modal" data-target="#addStep" v-if='data.locked == "offer" && data.customer_is != 1' @click='addDetail(report.id)'></i>
                    </div>
                  </div>
                  <div class="col-12 table-responsive" v-for='(report, index) in data.report'>
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th colspan="8" style="vertical-align: middle;"><strong>Tahapan @{{ index+1 }} @{{ report.name }}</strong></th>
                          <th class="text-center">
                            <i class="btn btn-info fa fa-plus" data-toggle="modal" data-target="#addModal" v-if='data.locked == "offer" && data.customer_is == 0' @click='addDetail(report.id)'></i>
                            <i class="btn btn-info fa fa-pencil" data-toggle="modal" data-target="#editStep" v-if='data.locked == "offer" && data.customer_is == 0' @click="getReport(report.id)"></i>
                            <i class="btn btn-danger fa fa-trash" v-if='data.locked == "offer" && data.customer_is == 0' @click="delStep(report.id, index)"></i>
                          </th>
                        </tr>
                        <tr>
                          <td align="center"><strong>No</strong></td>
                          <td align="center" scope="col"><strong>Nama</strong></td>
                          <td align="center" scope="col"><strong>keterangan</strong></td>
                          <td align="center" scope="col"><strong>Volume</strong></td>
                          <td align="center" scope="col"><strong>Unit</strong></td>
                          <td align="center" scope="col"><strong>Waktu</strong></td>
                          <td align="center" scope="col"><strong>Harga Vendor</strong></td>
                          <td align="center" scope="col"><strong>Harga Customer</strong></td>
                          <td align="center" scope="col"><strong>Aksi</strong></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for='(detail, index3) in data.report[index].detail'>
                          <td align="center" style="vertical-align: middle;">@{{ index3+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.name }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.description }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.volume }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.unit }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ detail.time }}</td>
                          <td align="center" style="vertical-align: middle;">
                            @{{ formatPrice(detail.price_clean) }}
                          </td>
                          <td align="center" style="vertical-align: middle;">
                            @{{ formatPrice(detail.price_dirt) }}
                          </td>
                          <td align="center" style="vertical-align: middle;">
                            <!-- <i class="btn btn-info fa fa-save" v-if='data.locked == "offer"' @click="addPrice(detail.id, index, index3)"></i> -->
                            <i class="btn btn-info fa fa-pencil" data-toggle="modal" data-target="#editModal" v-if='data.locked == "offer"' @click="getReport(detail.id)"></i>
                            <i class="btn btn-danger fa fa-trash" v-if='data.locked == "offer"' @click="delReport(detail.id)"></i>
                            <i class="btn btn-warning fa fa-check" v-if='data.locked == "deal"'></i>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6" align="center"><strong>Total Harga</strong></td>
                          <td align="center"><strong>@{{ formatPrice(report.all_price[0]) }}</strong></td>
                          <td align="center"><strong>@{{ formatPrice(report.all_price[1]) }}</strong></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
      						</div>
                </div>

                <!-- GAMBAR LAPANGAN
                 -->
                <div class="row mt-4">
                  <div class="col-md-12 rounded text-center">
                    <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Gambar Lapangan</label>
                    </div>
                  </div>
                  <div class="col-md-3 text-right mt-3" v-for = "(image, index2) in data.gallery" >
                    <div>
                      <img :src="'/storage/'+data.gallery[index2].image" class="img-fluid p-2" style="background-color: #00000008; border: 1px solid #00000020;">
                    </div>
                  </div>
                </div>

                <!-- TERMIN PEMBAYARAN -->
                <div class="row mt-4">
                  <div class="col-md-12 rounded text-center">
                    <div class="pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Pembagian Termin</label><br>
                      <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" @click='addTermin' v-if='data.locked != "deal" && data.customer_is != 1'><i class="fa fa-plus pr-2"></i>Tambah Termin</button>
                    </div>
                  </div>
                  <div class="col-12 mt-4">
                    <div class="row">
                      <div class="col-md-6 table-responsive">
                        <table class="table table-bordered" width="100%">
                          <thead>
                            <tr>
                              <th colspan="6" class="text-center"><strong>Tahapan</strong></th>
                            </tr>
                            <tr>
                              <td align="center"><strong>No</strong></td>
                              <td align="center" scope="col"><strong>Nama</strong></td>
                              <td align="center" scope="col"><strong>Total Harga Vendor</strong></td>
                              <td align="center" scope="col"><strong>Total Harga Customer</strong></td>
                              <td align="center" scope="col"><strong>Termin</strong></td>
                              <td align="center" scope="col"><strong>Aksi</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for='(report, index) in data.report'>
                              <td align="center" style="vertical-align: middle;">@{{ index+1 }}</td>
                              <td align="center" style="vertical-align: middle;">@{{ report.name }}</td>
                              
                              <td align="center" style="vertical-align: middle;">@{{ formatPrice(report.all_price[0]) }}</td>
                              <td align="center" style="vertical-align: middle;">@{{ formatPrice(report.all_price[1]) }}</td>
                              <td align="center" style="vertical-align: middle;">
                                <label v-if='termin.length == 0'>Tambah termin terlebih dahulu</label>
                                <select class="form-control" v-if='termin.length != 0' v-model='report.termin' @change='addToTermin(report)' :disabled="data.locked == 'deal' ? true : false">
                                  <option value="null">Pilih</option>
                                  <option v-for='(termins, index5) in termin' :value="termins.id">@{{ termins.termin }}</option>
                                </select>
                              </td>
                              <td align="center" style="vertical-align: middle;">
                                <i class="btn btn-warning fa fa-check" v-if='report.termin != "null" && data.locked == "deal"'></i>
                                <span v-else>-</span>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" class="text-center"><strong>Total</strong></td>
                              <td class="text-center"><strong>@{{ formatPrice(allPriceCustomer) }}</strong></td>
                              <td class="text-center"><strong>@{{ formatPrice(allPriceVendor) }}</strong></td>
                              <td colspan="2" class="text-center"><strong>-</strong></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6 table-responsive">
                        <table class="table table-bordered" width="100%">
                          <thead>
                            <tr>
                              <th colspan="4" class="text-center"><strong>Termin Pembayaran</strong></th>
                            </tr>
                            <tr>
                              <td align="center" scope="col"><strong>Termin</strong></td>
                              <td align="center" scope="col"><strong>Total Harga Vendor</strong></td>
                              <td align="center" scope="col"><strong>Total Harga Customer</strong></td>
                              <td align="center" scope="col"><strong>Aksi</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for='(termins, index) in termin'>
                              <td align="center" style="vertical-align: middle;">@{{ index+1 }}</td>
                              <td align="center" style="vertical-align: middle;">@{{ formatPrice(termins.total_vendor == null ? 0 :  termins.total_customer) }}</td>
                              <td align="center" style="vertical-align: middle;">@{{ formatPrice(termins.total_customer == null ? 0 :  termins.total_customer) }}</td>
                              <td align="center" style="vertical-align: middle;">
                                <i class="btn btn-warning fa fa-check" v-if='termins.report_count == 0 && termins.termin != termin.length'></i>
                                <i class="btn btn-warning fa fa-check" v-if='termins.report_count != 0'></i>
                                <i class="btn btn-danger fa fa-times" v-if='termins.report_count == 0 && termins.termin == termin.length' @click='deleteTermin(termins, index)'></i>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- VENDOR & KUNCI PENAWARAN -->

                <div class="row mt-4" v-if='data.locked != "deal"'>
                  <div class="col-md-6 pt-3 pb-3 rounded text-center" v-if='data.vendor_is != 1'>
                    <div class="rounded p-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Vendor</label><br>
                      <div v-if='data.vendor_is == 0'>
                        <label class="font-weight-bold" v-if = "data.vendor == null">Tentukan vendor yang akan bergabung.</label><br v-if = "data.vendor == null">
                        <select class="form-control" v-if = "data.vendor == null" v-model = 'data.vendor' @change="addVendor">
                          <option value="">Pilih Vendor</option>
                          <option v-for="(vendors, indexv) in vendor" :value="vendors.id">@{{ vendors.name }}</option>
                        </select>
                        <label class="font-weight-bold" v-if = "data.vendor != null">Vendor telah anda tentukan, apakah anda ingin mengubahnya ?</label><br v-if = "data.vendor != null">
                        <button class="btn btn-danger" v-if = "data.vendor != null" @click='removeVendor'>Kosongkan Vendor</button>
                      </div>
                      <div v-if='data.vendor_is == 99'>
                        <label class="font-weight-bold">Vendor sebelumnya telah menolak penawaran, silahkan pilih vendor yang lain</label><br>
                        <select class="form-control" v-model = 'data.vendor' @change="addVendor">
                          <option value="">Pilih Vendor</option>
                          <option v-for="(vendors, indexv) in vendor" :value="vendors.id">@{{ vendors.name }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 pt-3 pb-3 text-center mx-auto" v-if='data.customer_is != 0 && data.vendor_is != 1'>
                    <div class="rounded p-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Customer</label><br>
                      <label class="font-weight-bold">Penawaran Telah Disetujui</label>
                    </div>
                  </div>
                  <div class="col-md-6 align-self-center text-center" v-if='data.customer_is != 0 && data.vendor_is == 1'>
                    <div class="rounded pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Penawaran</label><br>
                      <label class="font-weight-bold">Setelah Penawaran terkunci, anda tidak bisa mengubah isian</label>
                      <br>
                      <button class="btn btn-warning" @click='dealed'><strong>Kunci Penawaran</strong></button>
                    </div>
                  </div>
                  <div class="col-md-6 pt-3 pb-3 text-center" v-if='data.customer_is != 0 && data.vendor_is != 0'>
                    <div class="rounded p-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Customer & Vendor</label><br>
                      <label class="font-weight-bold">Penawaran Telah Disetujui</label>
                    </div>
                  </div>
                </div>

                <div class="row mt-4" v-if='data.locked == "deal"'>
                  <div class="col-md-6 rounded text-center mb-3">
                    <div class="rounded pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Vendor</label><br>
                      <label class="font-weight-bold">Penawaran Telah Terkunci</label>
                    </div>
                  </div>
                  <div class="col-md-6 align-self-center text-center">
                    <div class="rounded pt-3 pb-3" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold h3">Penawaran</label><br>
                      <label class="font-weight-bold">Penawaran Telah Terkunci</label>
                    </div>
                  </div>
                </div>

    					</div>
    					<div class="card-footer text-center">
    						<label class="m-0 font-weight-bold">Isi dengan hati - hati</label>
    					</div>
  			    </div>		
          </main>
        </div>
      </div> 
    </div>
    

  @endsection
  @section('sec-js')
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/v-mask.min.js') }}"></script>
    </script>
    <script type="text/javascript">
      Vue.use(VueMask.VueMaskPlugin);
      var report = new Vue({
        el: '#app',
        data: {
            check : 0,
            today : moment().format('YYYY-MM-DD'),
            id : '{{ $id }}',
            id_step : '',
            partner: {},
            view_report : {},
            add_report : {},
            add_form : {},
            add_date : {},
            add_step : {},
            data: {},
            vone: '',
            report: {},
            step: [],
            image: [],
            view: [],
            view_image: [],
            termin: [],
            vendor: [],
            allunit : [],
            province: {},
            allPlace: '',
            allPriceCustomer: 0,
            allPriceVendor: 0,
            thisProvince: '',
            regency: {},
            thisRegency: '',
            district: {},
            thisDistrict: '',
            village: {},
            thisVillage: '',
        },
        mounted: function(){
          this.getData(this.id);
          this.getTermin();
          this.getVendor();
          this.allUnit();
          this.$nextTick(()=>{
            let data = moment(this.data.date).format('YYYY-MM-DD');
            let date = data <= this.today ? this.today: data;
            $('#date_start').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: date,
                disableTouchKeyboard: true,
                startDate: date,
                locale: {
                  format: 'YYYY-MM-DD'
                },
            });
          });
        },
        methods: {
          getData : function(id){
            axios.get("{{ url('api/report/getByIdEngagement') }}/"+id).then(function(response){
              this.data = response.data.data;
              this.partner = response.data.data.partner;
              this.allPlace = ucwords(response.data.data.paddress+', '+response.data.data.pvillage.name+', '+response.data.data.pdistrict.name+', '+response.data.data.pregency.name+', '+response.data.data.pprovince.name);
              for (var i = 0; i < this.data.report.length; i++) {
                this.allPriceCustomer += parseInt(this.data.report[i].all_price[0]);
                this.allPriceVendor += parseInt(this.data.report[i].all_price[1]);
              }
            }.bind(this));
          },
          allUnit: function(){
            axios.get("{{ url('api/resource/all-unit') }}").then(function(response){
              this.allunit = response.data.data;
            }.bind(this));
          },
          getTermin : function(){
            axios.get("{{ url('api/termin/getByEngagementId') }}/"+this.id).then(function(response){
              this.termin = response.data.data;
              console.log(this.termin);
            }.bind(this));
          },
          getVendor : function(){
            axios.get("{{ url('api/user/getVendor') }}").then(function(response){
              this.vendor = response.data.data;
            }.bind(this));
          },
          getReport : function(id){
            axios.get("{{ url('api/report/getByIdReport') }}/"+id).then(function(response){
              this.view_report = response.data.data;
            }.bind(this));
          },
          delReport : function(id){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: 'Data yang dihapus tidak dapat dikembalikan !',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/report/destroy') }}/"+id).then(function(response){
                  this.getData(this.id);
                  Swal.fire('Success', 'Store Successfully .. !', 'success');
                }.bind(this));
              }
            });
          },
          saveStep : function(){
            let form = document.getElementById('form-add-step');
            let forms = new FormData(form);

            forms.append('type', 'step');
            forms.append('reservation_id', this.id);

            axios.post(
              "{{ url('api/report/store') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            )
            .then(function (response) {
              report.$nextTick(() => {
                $("#addStep").modal('hide');
              });
            }).then(() => {
              this.getData(this.id);
              Swal.fire('Success', 'Update Successfully .. !', 'success');
            });
          },
          updateStep : function(id){
            let form = document.getElementById('form-update-step');
            let forms = new FormData(form);

            forms.append('reservation_id', this.id);
            forms.append('id', id);

            axios.post(
              "{{ url('api/report/updateStep') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            )
            .then(function (response) {
              report.$nextTick(() => {
                $("#editStep").modal('hide');
              });
            }).then(() => {
              this.getData(this.id);
              Swal.fire('Success', 'Update Successfully .. !', 'success');
            });
          },
          delStep : function(id, index){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: 'Data yang dihapus tidak dapat dikembalikan !',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/report/delStep') }}", {'id' : id}).then(function(response){
                  this.data.report.splice(index, 1)
                }.bind(this));
              }
            });
          },
          saveReport : function(){
            let form = document.getElementById('form-edit');
            let forms = new FormData(form);

            let price_dirt = forms.get('price_dirt');
            let price_clean = forms.get('price_clean');

            if (price_clean == 0 || price_dirt == 0 || price_clean == '' || price_dirt == '') {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if (parseInt(price_clean) >= parseInt(price_dirt) ) {
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              axios.post(
                "{{ url('api/report/update') }}",
                forms,
                {
                  headers: {
                    'Content-Type': 'multipart/form-data',
                  }
                }
              )
              .then(function (response) {
                report.$nextTick(() => {
                  $("#editModal").modal('hide');
                });
              }).then(() => {
                this.getData(this.id);
                Swal.fire('Success', 'Update Successfully .. !', 'success');
              });
            }
          },
          saveAddReport : function(id){
            let form = document.getElementById('form-add');
            let forms = new FormData(form);

            forms.append('type', 'detail');

            let price_dirt = forms.get('price_dirt');
            let price_clean = forms.get('price_clean');

            if (price_clean == 0 || price_dirt == 0 || price_clean == '' || price_dirt == '') {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if (parseInt(price_clean) >= parseInt(price_dirt) ) {
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              axios.post(
                "{{ url('api/report/store') }}",
                forms,
                {
                  headers: {
                    'Content-Type': 'multipart/form-data',
                  }
                }
              )
              .then(function (response) {
                report.$nextTick(() => {
                  form.reset();
                  $("#addModal").modal('hide');
                });
              }).then(() => {
                this.getData(this.id);
                Swal.fire('Success', 'Store Successfully .. !', 'success');
              });
            }
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
          },
          addTermin : function(){
            axios.post(
              "{{ url('api/termin') }}",
              {reservation_id : this.id}
            )
            .then(function (response) {
              console.log(response.data);
            }).then(() => {
              this.getTermin();
            });
          },
          deleteTermin : function(termin, index){
            axios.post(
              "{{ url('api/termin/destroy') }}/"+termin.id
            )
            .then(function (response) {
              if (response.data.message == 'Oke') {
                this.termin.splice(index, 1);
              }
            }.bind(this));
          },
          addToTermin : function(report){ 
            axios.post(
              "{{ url('api/termin/addToTermin') }}",
              {'id' : report.id, 'termin' : report.termin}
            )
            .then(function (response) {
              console.log(response.data);
            }).then(() => {
              this.getTermin();
            });
          },
          sendTermin : function(report){
            if (report.termin == 'null' || report.termin == null || report.termin == '') {
              Swal.fire(
                'Oppss',
                'Termin wajib diisi',
                'warning'
              );
            }else if(report.all_price[0] == 0 || report.all_price[1] == 0){
              Swal.fire(
                'Oppss',
                'Harap isi harga vendor dan customer di point tahapan',
                'warning'
              );
            }else{
              Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu tidak bisa mengubah termin setelah termin ditetapkan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post('{{ url("api/report/addTermin") }}',
                    {'id': report.id, 'termin': report.termin, 'total_clean' : report.all_price[0], 'total_dirt' : report.all_price[1]}
                  ).then(function(response){
                    if (response.data.message == "Success") {
                      Swal.fire(
                        'Berhasil',
                        'Harga sudah ditetapkan .. !',
                        'success'
                        )
                    }else{
                      Swal.fire(
                        'Ada yang salah',
                        'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                        'warning'
                        )
                    }
                  }).then(()=>{
                      this.getData(this.id);
                  }); 
                }
              });
            }
          },
          addDate: function(){
            let form = document.getElementById('form-add-date');
            let forms = new FormData(form);

            forms.append('id', this.id);

            axios.post("{{ url('api/report/addDate') }}", 
              forms)
            .then(function(response){
              if (response.data.message == "Success") {
                Swal.fire(
                  'Berhasil',
                  'Tanggal sudah ditetapkan .. !',
                  'success'
                  )
              }else{
                Swal.fire(
                  'Ada yang salah',
                  'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                  'warning'
                  )
              }
            }).then(()=>{
                report.$nextTick(() => {
                  $("#addDate").modal('hide');
                });
                this.getData(this.id);
            }); 
          },
          addPrice: function(item, index, index2){
            let price_clean = this.data.report[index].detail[index2].price_clean;
            let price_dirt = this.data.report[index].detail[index2].price_dirt;
            if(price_clean == 0 || price_dirt == 0)
            {
              Swal.fire(
                'Oppss',
                'Harga Customer dan Harga Vendor harus di isi .. !',
                'warning'
                );
            }else if(parseInt(price_clean) >= parseInt(price_dirt)){
              Swal.fire(
                'Oppss',
                'Harga Customer harus lebih tinggi dari Harga Vendor',
                'warning'
                );
            }else{
              Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Kamu tidak bisa mengubah harga setelah harga ditetapkan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post("{{ url('api/report/addPrice') }}", 
                    { 'id' : item, 'price_clean' : price_clean, 'price_dirt' : price_dirt })
                  .then(function(response){
                    if (response.data.message == "Success") {
                      Swal.fire(
                        'Berhasil',
                        'Harga sudah ditetapkan .. !',
                        'success'
                        )
                    }else{
                      Swal.fire(
                        'Ada yang salah',
                        'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                        'warning'
                        )
                    }
                  }).then(()=>{
                      this.getData(this.id);
                  }); 
                }
              });
            }
          },
          removeVendor: function(){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Isi dengan hati - hati .. !",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/addVendor') }}", 
                  { 'id' : this.id, 'vendor': null })
                .then(function(response){
                  if (response.data.message == "Success") {
                    Swal.fire(
                      'Berhasil',
                      'Vendor telah dikosongkan .. !',
                      'success'
                      )
                  }else{
                    Swal.fire(
                      'Ada yang salah',
                      'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                      'warning'
                      )
                  }
                }).then(()=>{
                    this.getData(this.id);
                }); 
              }
            });
          },
          addVendor: function(e){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Kamu tidak bisa mengubah vendor setelah vendor ditetapkan",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/addVendor') }}", 
                  { 'id' : this.id, 'vendor': e.target.value })
                .then(function(response){
                  if (response.data.message == "Success") {
                    Swal.fire(
                      'Berhasil',
                      'Vendor sudah ditetapkan .. !',
                      'success'
                      )
                  }else{
                    Swal.fire(
                      'Ada yang salah',
                      'Harap Perhatikan Isian atau Hubungi Team Develover bila error terus muncul',
                      'warning'
                      )
                  }
                }).then(()=>{
                    this.getData(this.id);
                }); 
              }else{
                this.data.vendor = null;
              }
            });
          },
          editData: function(id){
            axios.post("{{ url('api/resource/update-resource') }}/"+id, this.view).then(function(response){
              app.$nextTick(() => {
                $("#editModal").modal('hide');
                $("#example").DataTable().destroy();
              });
            }).then(() => {
              this.getData();
            });
          },
          dealed: function(){
            Swal.fire({
              title: 'Apakah kamu yakin ?',
              text: "Kamu tidak bisa mengubah Penawaran setelah Penawaran ditetapkan",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/dealed') }}/"+this.id).then(function(response){
                }).then(() => {
                  this.getData(this.id);
                });
              }
            })
          },
          loadProvince(){
            axios.get("{{ url('api/province') }}").then(function(response){
              this.province = response.data.data;
              this.regency = {};
              this.thisRegency = '';
              this.district = {};
              this.thisDistrict = '';
              this.village = {};
              this.thisVillage = '';
            }.bind(this));
          },
          getRegency: function(){
            if (this.thisProvince != '') {
                axios.post("{{ url('api/regency') }}", {id: this.thisProvince}).then(function(response){
                this.regency = response.data.data;
                this.district = {};
                this.thisDistrict = '';
                this.village = {};
                this.thisVillage = '';
              }.bind(this));
            }
          },
          getDistrict: function(){
            if (this.thisRegency != '') {
              axios.post("{{ url('api/district') }}", {id: this.thisRegency}).then(function(response){
                this.district = response.data.data;
                this.village = {};
                this.thisVillage = '';
              }.bind(this));
            }
          },
          getVillage: function(){
            if (this.thisDistrict != '') {
              axios.post("{{ url('api/village') }}", {id: this.thisDistrict}).then(function(response){
                this.village = response.data.data;
              }.bind(this));
            }
          },
          sendMail:function(id){
            if (this.data.date_work == null || this.data.date_work == '') {
              Swal.fire(
                'Opss !',
                'Tanggal mulai pekerjaan belum terisi !',
                'warning'
              )
            }else if (this.data.vendor == null || this.data.vendor == '' || this.data.vendor.length == 0) {
              Swal.fire(
                'Opss',
                'Vendor belum terisi, harap isi terlebih dahulu .. !',
                'warning'
              )
            }else if(this.termin == null || this.termin == '' || this.termin.length == 0){
              Swal.fire(
                'Opss',
                'Termin belum terisi, harap isi terlebih dahulu .. !',
                'warning'
              )
            }else if(this.data.gallery == null || this.data.gallery == '' || this.data.gallery.length == 0){
              Swal.fire(
                'Opss',
                'Gambar belum terisi, harap isi terlebih dahulu .. !',
                'warning'
              )
            }else{
              Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Pastikan harga sudah benar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.open('https://api.whatsapp.com/send?phone=6288023554758&text=Penawaran%20Home%20Service%20Telah%20terkirim.%20Check%20Email%20untuk%20menyetujui', '_blank');
                  window.location.href = "{{ url('report/sendEngagement') }}/"+id;
                }
              });
            }
          },
          formatRupiah: function(e){
            var number_string = e.target.value.replace(/[^,\d]/g, '').toString(),
            split         = number_string.split(','),
            sisa          = split[0].length % 3,
            rupiah        = split[0].substr(0, sisa),
            ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
              separator = sisa ? '.' : '';
              rupiah += separator + ribuan.join('.');
            }
           
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            
            e.target.value = rupiah;
          },
          isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
              evt.preventDefault();;
            } else {
              return true;
            }
          },
          filter:function(e){
            e.target.value = e.target.value.replace(/[^0-9]+/g, '');
          },
        }
      });
      
    </script>
  @endsection

@endif