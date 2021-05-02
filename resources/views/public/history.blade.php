@extends('layout.app')

@if(session('id') == null || session('role') != 4)
  <script type="text/javascript">
    window.location = "{{ route('home') }}";
  </script>
@else

@section('sec-css')
	<style type="text/css">
		.max-400{
			width: auto !important;
			height: 400px;
		}

		.nurani-rezeki-unggul{
			
		}

		.max-500{
			width: auto !important;
			height: 500px;
		}

		.f-small{
			font-size: 14px;
		}

		.f-light{
			font-size: 12px;
		}

		.max-height-100{
			height: 30px;
		}

		.card{
			border-radius: 20px;
		}

		.card-footer{
			border-bottom-right-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
		}
	</style>
@endsection

@section('content')
	@include('layout.header')
  	<div id="app" v-cloak>
		<div class="h1 font-weight-bold text-center">showMe</div>
	</div>
	@include('layout.footer')
@endsection

@section('sec-js')
<script type="text/javascript">
	var app = new Vue({
      el: '#app',
      data: {
          data: [],
          defaultImg : '{{ asset('img/default.png') }}',
          service: '',
          time: [],
          addViewImage: '',
          province: {},
          thisProvince: '',
          regency: {},
          thisRegency: '',
          district: {},
          thisDistrict: '',
          village: {},
          thisVillage: '',
      },
      mounted: function(){

      },
      methods: {
        viewData : function(id){
          axios.get("{{ url('api/employee') }}/"+id).then(function(response){
            this.view = response.data.data;
            $("#editModal").modal('show');
          }.bind(this)).then(() => { 
            this.getAllAddress();
          });
        },
        submitform : function(){
          axios.post("{{ url('api/employee/create-employee') }}", this.form).then(function(response){
            app.$nextTick(() => {
              $("#editModal").modal('hide');
              $("#example").DataTable().destroy();
            });
          }).then(() => {
            this.form = {};
            this.getData();
          });
        }, 
        addForm: function(){
            this.thisProvince = '';
            this.regency = {};
            this.thisRegency = '';
            this.district = {};
            this.thisDistrict = '';
            this.village = {};
            this.thisVillage = '';        
        },
        loadTime(){
        	var i = 0;
          	for(i = 0; i < 15; i++){
          		this.time.push(moment('10:00', 'HH:mm').add(i*30, 'minutes').format('HH:mm'));
          	};
        },
        loadService(){
          axios.get("{{ url('api/service') }}").then(function(response){
            this.service = response.data.data;
          }.bind(this));
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
        sendReservation: function(){
        	let form 	= document.getElementById('form-engagement');
          	let forms 	= new FormData(form);
            axios.post(
              "{{ url('api/engagement/create-engagement') }}",
              forms,
              {
                headers: {
                  'Content-Type': 'multipart/form-data',
                }
              }
            ).then((response) => {
        		form.reset();
        		console.log(response);
              	Swal.fire('Success', response.data.message, 'success');
            });
         }
      }
    });

    $('#description').keyup(function () {
	    var left = 300 - $(this).val().length;
	    if (left < 0) {
	        left = 0;
	    }
	    $('#maxDescription').text(left + ' Karakter tersisa');
	});

	$('.owl-carousel').owlCarousel({
	    nav: true,
	    margin: 10,
	    loop: true,
		dots: true,
        autoplay:true,
    	autoplayTimeout:3000,
    	autoplayHoverPause:true,
	    responsive: {
	        0: {
	          items: 1
	        },
	        600: {
	          items: 1
	        },
	        1000: {
	          items: 3
	        }
	    }
	});

	$('.select2').select2({
		placeholder: "Pilih service"
	});

	$('.datePicker').daterangepicker({
	    singleDatePicker: true,
	    autoApply: true,
        disableTouchKeyboard: true,
	    startDate: moment().add(7, 'days'),
	    minDate: moment().add(7, 'days'),
	    locale: {
	      format: 'YYYY-MM-DD'
	    }
	});

</script>
@endsection

@endif