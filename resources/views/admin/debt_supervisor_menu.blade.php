@extends('layout.app')

@if(session('id') == null || session('role') != 1)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>

      <!-- Content -->
      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-lg-10 px-4 mt-4">
            <div class="card">
              <div class="card-header">
              </div>
              <div class="card-body">

                <!-- PEKERJAAN VENDOR -->

                <div class="row">
                  <div class="col-md-12 mb-4 mt-3 rounded text-center">
                    <div class="pt-3 pb-3 pl-2 pr-2" style="background-color: #00000008; border: 1px solid #00000020;">
                      <label class="font-weight-bold m-0 h3">Progres Pekerjaan</label>
                    </div>
                  </div>
                  <div class="col-12 table-responsive">
                    <table class="table table-bordered" width="100%">
                      <thead>
                        <tr>
                          <th align="center" class="text-center"><strong>No</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Nama</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Harga Vendor</strong></th>
                          <th align="center" class="text-center" scope="col"><strong>Harga Customer</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for='(report, index) in data.report'>
                          <td align="center" style="vertical-align: middle;">@{{ index+1 }}</td>
                          <td align="center" style="vertical-align: middle;">@{{ report.name }}</td>
                          <td align="center" style="vertical-align: middle;"><strong>@{{ formatPrice(report.all_price[0]) }}</strong></td>
                          <td align="center" style="vertical-align: middle;"><strong>@{{ formatPrice(report.all_price[1]) }}</strong></td>
                        </tr>
                      </tbody>
                    </table>
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
            thisProvince: '',
            regency: {},
            thisRegency: '',
            district: {},
            thisDistrict: '',
            village: {},
            thisVillage: '',
            priceCleanVendor: ''
        },
        mounted: function(){
          this.getData(this.id);
          this.allUnit();
          this.loadProvince();
          this.$nextTick(()=>{
            let data = moment().format('YYYY-MM-DD');
            let data7 = moment().add(-7, 'days').format('YYYY-MM-DD');
            $('#date_start').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: data7,
                disableTouchKeyboard: true,
                startDate: data,
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
              this.partner = response.data.data.customer;

              console.log(this.data);

              let termin = 0;
              for (var i = 0; i < this.data.report.length; i++) {
                if (this.data.report[i].termin > termin){
                  termin = this.data.report[i].termin
                }
              }

              if (termin != 0) {
                this.termin = [];
                for (var j = 0; j < termin; j++) {
                  this.termin.push({
                    step      : [],
                    vendor    : 0,
                    customer  : 0,
                  });
                  for (var k = 0; k < this.data.report.length; k++) {
                    if (this.data.report[k].termin-1 == j){
                      this.termin[j].step.push({
                        id    : this.data.report[k].id,
                        name  : this.data.report[k].name,
                        clean : this.data.report[k].all_price[0],
                        dirt  : this.data.report[k].all_price[1],
                      });
                    }
                  }
                }
              }

              for (var l = 0; l < this.termin.length; l++) {
                let total_clean = 0;
                let total_dirt  = 0;
                for (var m = 0; m < this.termin[l].step.length; m++) {
                  total_clean += this.termin[l].step[m].clean;
                  total_dirt += this.termin[l].step[m].dirt;

                  this.termin[l].vendor   = this.formatPrice(total_clean);
                  this.termin[l].customer = this.formatPrice(total_dirt);
                }
              }
            }.bind(this));
          },
          allUnit: function(){
            axios.get("{{ url('api/resource/all-unit') }}").then(function(response){
              this.allunit = response.data.data;
            }.bind(this));
          },
          getReport : function(id){
            axios.get("{{ url('api/report/getByIdReport') }}/"+id).then(function(response){
              this.view_report = response.data.data;
            }.bind(this));
          },
          addPayment : function(id, price){
            this.getReport(id);
            this.priceCleanVendor = price;
          },
          sendPayment : function(id){
            let form = document.getElementById('form-add-pay');
            let forms = new FormData(form);

            // console.log(forms.get('date'));

            axios.post("{{ url('api/supervisor/addPay') }}/"+id, { date : forms.get('date') }).then(function(response){
              Swal.fire('Success', 'Konfirmasi Pembayaran Berhasil', 'success');
              report.$nextTick(()=>{
                $('#addPayment').modal('hide');
              });
            }.bind(this)).then(()=>{
              this.getData(this.id);
            });
          },
          formatPrice(value) {
            let val = (value/1).toFixed(0).replace(',', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
          },
          addDetail : function(id){
            this.id_step = id;
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