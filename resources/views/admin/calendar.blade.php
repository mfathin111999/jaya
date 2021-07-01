@extends('layout.app')

@if(session('id') == null || session('role') == 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else
  @section('sec-css')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugin/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugin/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugin/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugin/fullcalendar-bootstrap/main.min.css') }}">

    <style type="text/css">
      @media screen and (max-width:767px) { 
        .fc-toolbar.fc-header-toolbar {
          flex-wrap: wrap;
          justify-content: center;
          line-height: 3rem;
        }
        .fc-left{
          flex-basis: 100%;
          text-align: center;
        }
      }
    </style>
  @endsection

  @section('content')
    @include('layout.admin_header')
    <div id="app" v-cloak>
      <div class="modal fade" id="actionModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Reservasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="actionForm">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                          <label for="action">Action</label>
                          <select class="form-control" v-model = 'action' id="action" name="action" @change="valid()">
                            <option value="">Pilih Aksi</option>
                            <option value="acc">Terima</option>
                            <option value="ignore">Tolak</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                          <label for="employee">Surveyer</label>
                          <select class="form-control select2" v-model="thisEmployee" multiple="multiple" name="employee[]" id="employee" style="width: 100%;">
                            <option v-for='(employee, index) in employee' :value='employee.id'>@{{ employee.name }}</option>
                          </select>
                        </div>
                        <div class="col-12 mb-3" v-if = 'action == "ignore"'>
                          <label for="reason">Alasan</label>
                          <select class="form-control" v-model="thisReason" name="reason" id="reason" style="width: 100%;">
                            <option value="">Pilih Alasan</option>
                            <option v-for='(item, index) in reason' :value='item.id'>@{{ item.reason }}</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-12">
                          <button type="button" class="btn btn-success btn-block" @click='actionEngagement()'>Kirim Aksi</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="hidden" class="form-control" id="id" name="id">
                      <input type="text" class="form-control" id="name" name="name" disabled="">
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label for="code">Booking Code</label>
                          <input type="text" class="form-control" id="code" name="code" disabled="">
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number</label>
                          <input type="text" class="form-control" id="phone_number" name="phone_number" disabled="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" disabled="">
                    </div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="text" class="form-control" id="date" name="date" disabled="">
                    </div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="form-group">
                      <label for="time">Time</label>
                      <input type="text" class="form-control" id="time" name="time" disabled="">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea type="text" class="form-control" id="address" name="address" disabled=""></textarea>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="service">Service</label>
                      <textarea type="text" class="form-control" id="service" name="service" disabled=""></textarea>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="email">Description</label>
                      <textarea type="text" class="form-control" id="description" name="description" rows="3" disabled=""></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid" style="margin-top: 60px;">
        <div class="row">
          @include('layout.admin_side')
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h4 font-weight-bold">KALENDER</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
              </div>
            </div>

                <!-- THE CALENDAR -->
                <div class="row">
                  <div class="col-md-10">
                    <div class="card">
                      <div class="card-body">        
                        <div id="calendar" style="font-size: 12px !important;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <!-- <div class="card">
                      <div class="card-body">  -->                       
                        <div class="content-group text-center" id="external-events">
                          <label class="font-weight-bold p-0 m-0">Keterangan</label>
                          <div class="fc-events-container content-group">
                            <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #f56954;">Menunggu Konfimasi</div>
                            <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #17a2b8;">Diterima</div>
                            <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #ffc107;">Telah Disurvei</div>
                            <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #64bd63;">Telah Deal</div>
                            {{-- <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #26a69a;">Telah Dibayar</div> --}}
                            <div class="rounded mt-3 p-2 text-center text-white font-weight-bold" style="background-color: #546e7a;">Telah Selesai</div>
                          </div>
                        </div>
                      <!-- </div>
                    </div> -->
                  </div>
                </div>
              <!-- /.card-body -->
            <!-- /.card -->
          </main>
        </div>
      </div> 
    </div>


    

  @endsection
  @section('sec-js')

    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/fullcalendar/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/fullcalendar-daygrid/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/fullcalendar-timegrid/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/fullcalendar-interaction/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugin/fullcalendar-bootstrap/main.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/partial/calendar.js') }}"></script> --}}
    <script type="text/javascript">
      var app = new Vue({
        el: '#app',
        data: {
            data: [],
            employee: [],
            thisEmployee: [],
            view: [],
            form: {},
            action: '',
            role: "{{ session('role') }}",
        },
        mounted: function(){
         this.getCalendar();
         this.getEmployee();
         this.valid();
         this.getReason();
        },
        methods: {
          getData : function(){
            axios.get("{{ url('api/engagement') }}").then(function(response){
              this.data = response.data.data;
              this.$nextTick(() => {
                 $("#example").DataTable();
              });
            }.bind(this));
          },
          getReason : function(){
            axios.get("{{ url('api/getReason') }}").then(function(response){
              this.reason = response.data.data;
            }.bind(this));
          },
          getEmployee : function(){
            axios.get("{{ url('api/user/getSurveyer') }}").then(function(response){
              this.employee = response.data.data;
            }.bind(this));
          },
          viewData : function(id){
            axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
              this.view = response.data.data;
            }.bind(this));
          },
          valid: function() {
            if (this.action == 'acc') {
              document.getElementById('employee').disabled = false;
            }else{
              document.getElementById('employee').disabled = true;
            }
          },
          actionEngagement : function(){
            let forms = document.getElementById('actionForm');

            let data = new FormData(forms);

            if (this.action == '' || (this.action == 'acc' && data.get('employee[]') == null)) {
              Swal.fire(
                  'Warning!',
                  'Harap isi Aksi dan Surveyer.',
                  'warning'
              );
            }else{
              if (this.action == 'ignore' && (this.thisReason == null || this.thisReason == '' )) {
                Swal.fire(
                  'Warning!',
                  'Harap isi alasan penolakan.',
                  'warning'
                );
              }else{
                axios.post("{{ url('api/engagement/action') }}", data).then(function(response){
                  app.$nextTick(() => {
                    $('#actionModal').modal('hide');
                    $('#calendar').html('');
                  });
                  Swal.fire(
                      'Success!',
                      'Survey diterima.',
                      'success'
                  );
                }).then(()=>{
                  this.getCalendar();
                });
              }
            }
          },
          deleteItem: function(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.post("{{ url('api/engagement/destroy') }}/"+id).then(function(response){
                  app.$nextTick(() => {
                    $('#example').DataTable().destroy();
                  });
                }).then(() => {
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                  )
                });
                this.getData();
              }
            })
          },
          getCalendar: function(){
            this.$nextTick(() => {
              calendarInit();
            });

            // if ("{{ session('role') }}" == 1) {
            //   axios.get("{{ url('api/engagement/getCalendarData') }}").then(function(response){
            //     app.$nextTick(() => {
            //       calendarInit(response.data.data);
            //     });
            //   });
            // }else if ("{{ session('role') }}" == 2) {
            //   let id = "{{ session('id') }}";
            //   let form = {
            //     'id' : id
            //   };
            //   console.log(id)
            //   axios.post("{{ url('api/engagement/getCalendarDataSurveyer') }}", form).then(function(response){
            //     app.$nextTick(() => {
            //       calendarInit(response.data.data);
            //     });
            //   });
            // }else{
            //   let id = "{{ session('id') }}";
            //   let form = {
            //     'id' : id
            //   };
            //   console.log(id)
            //   axios.post("{{ url('api/engagement/getCalendarDataMandor') }}", form).then(function(response){
            //     app.$nextTick(() => {
            //       calendarInit(response.data.data);
            //     });
            //   });
            // }
          },
        }
      });

      $('.select2').select2({
        maximumSelectionLength: 3,
        allowClear: true,
        placeholder: 'Pilih Surveyer',
      });


  function calendarInit(data){
    function ini_events(ele) {
      ele.each(function () {
        var eventObject = {
          title: $.trim($(this).text())
        }
        $(this).data('eventObject', eventObject)
        $(this).draggable({
          zIndex        : 1070,
          revert        : true,
          revertDuration: 0 
        })

      })
    }

    ini_events($('#external-events div.external-event'))
    var date = new Date()
    var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      'themeSystem': 'bootstrap',

      events    : "{{ url('api/engagement/getCalendarData') }}",

      eventClick: function(info) {
        axios.get('api/engagement/getByCode/'+info.event.title).then(function(response){
            let view = response.data.data;
            console.log(view);
            if (view.status == 'acc' && view.report_count == 0 && view.locked == 'offer') {
              window.location ="report_survey/"+view.id;
            }
            else if (view.status == 'acc' && view.report_count != 0 && view.locked == 'offer') {
              window.location ="report_view/"+view.id;
            }
            else if (view.status == 'acc' && view.report_count != 0 && view.locked == 'deal') {
              window.location ="report_view/"+view.id;
            }else if (view.status == 'pending'){
              document.getElementById('action').value = '';
              $('#employee').val(null).trigger('change');
              $('#id').val(view.id);
              $('#name').val(view.name);
              $('#code').val(view.code);
              $('#email').val(view.email);
              $('#phone_number').val(view.phone_number);
              $('#date').val(view.date);
              $('#time').val(view.time);
              $('#service').html(view.service);
              $('#address').html(view.address+' '+view.village+', '+view.district+', '+view.regency+', '+view.province);
              $('#description').html(view.description);
              $('#actionModal').modal('show');
            }
        });
      }
    });

    calendar.render();

    var currColor = '#3c8dbc' //Red by default
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      currColor = $(this).css('color')
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)
      ini_events(event)
      $('#new-event').val('')
    })
  };

    </script>
  @endsection
@endif
