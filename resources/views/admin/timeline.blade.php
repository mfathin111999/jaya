@extends('layout.app')

@section('content')
	@include('layout.admin_header')
  <div id="app" v-cloak>

  	<div class="modal fade" id="addPoint" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Bagian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="name">Nama Bagian</label>
                    <input type="text" class="form-control" id="name" v-model="vone">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click = 'sumbitAddForm()'>Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" style="margin-top: 60px;">
      <div class="row">
        @include('layout.admin_side')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-4">
          	<div class="card">
				<div class="card-header">
					<h3 class="text-center">Add Time Line</h3>
					<h3 class="text-center"><strong>@{{ view.code }} - @{{ view.name }}</strong></h3>

					<div class="btn-group mb-3">
              <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" v-on:click='addNewForm()'><i class="fa fa-plus pr-2"></i>Tambah Bagian</button>
          </div>
				</div>
					<div class="card-body">
						<div class="row" v-for='(form, index) in data'>
							<div class="col-md-12 mb-3 mt-3" v-if = 'index != 0' style="border-top: 1px solid #d8d8d8;"></div>
							<div class="col-md-12">
								<div class="form-group">
                    <label for="name">Nama Bagian @{{ index+1 }}</label>
                    <input type="text" class="form-control" v-model = 'form.name_part' required="">
                </div>
							</div>
							<div class="col-md-12">
								<div class="btn-group mb-3">
		                <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click='addNewPoint(index)' style="font-size: 12px;"><i class="fa fa-plus pr-2"></i>Tambah Point Detail</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click='addNewPoint(index)' style="font-size: 12px;"><i class="fa fa-plus pr-2"></i>Tambah Gambar</button>
		            </div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4 text-center">Nama detail</div>
									<div class="col-md-4 text-center">Unit</div>
									<div class="col-md-4 text-center">Volume</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row mt-3" v-for='(form1, index) in data[index].detail'>
									<div class="col-md-4">
                    <input type="text" class="form-control" v-model = 'form1.name_point' required="">
									</div>
									<div class="col-md-4">
                    <input type="text" class="form-control" v-model = 'form1.unit' required="">
									</div>
									<div class="col-md-4">
                    <input type="text" class="form-control" v-model = 'form1.volume' required="">
									</div>
								</div>
							</div>
              <div class="col-md-12">
                <div class="row mt-3" v-for='(form1, index) in data[index].detail'>
                  <div class="col-md-4">
                    <input type="text" class="form-control" v-model = 'form1.name_point' required="">
                  </div>
                </div>
              </div>
						</div>
					</div>
					<div class="card-footer text-center">
						<button type="button" class="btn btn-success" @click='submitform()'>Save</button>
					</div>
			</div>		
        </main>
      </div>
    </div> 
  </div>
  

@endsection
@section('sec-js')
  <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
  <script type="text/javascript">
    var app = new Vue({
      el: '#app',
      data: {
          id : '{{ $id }}',
          data: [],
          vone: '',
          view: {},
      },
      created: function(){
        this.getData(this.id);
      },
      methods: {
      	addNewForm : function(){
      		this.data.push(
      			{
	          		name_part: '',
	          		detail: [],
          		}
          	);
      		// console.log(this.data);
      	},
      	addNewPoint : function(index){
      		this.data[index].detail.push(
      			{
		          	name_point: '',
		          	unit: '',
		          	Volume: '',
		        }
	        );
      		// console.log(index);
      	},
        getData : function(id){
          axios.get("{{ url('api/engagement') }}/"+id).then(function(response){
            this.view = response.data.data;
          }.bind(this));
        },
        viewData : function(id){
          axios.get("{{ url('api/resource') }}/"+id).then(function(response){
            this.status = true;
            this.view = response.data.data;
          }.bind(this));
        },
        addForm : function(){
          this.status = false;
        },
        submitform : function(){
          axios.post("{{ url('api/report/create') }}", {id : this.id, data: this.data}).then(function(response){
            window.location = "{{ route('engagement') }}";
          });
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
              axios.post("{{ url('api/resource/destroy') }}/"+id).then(function(response){
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
        editData: function(id){
          axios.post("{{ url('api/resource/update-resource') }}/"+id, this.view).then(function(response){
            app.$nextTick(() => {
              $("#editModal").modal('hide');
              $("#example").DataTable().destroy();
            });
          }).then(() => {
            this.getData();
          });
        }
      }
    });
  </script>
@endsection