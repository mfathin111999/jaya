<div class="modal fade" id="signUp" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img class="modal-title" src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="registration">
        <div class="modal-body pl-4 pr-4">
          <div class="form-group">
            <label for="nameSign">Nama Lengkap</label>
            <input type="text" class="form-control" id="nameSign" placeholder="Nama Lengkap" name="name" required="">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Username" name="username" required="">
          </div>
          <div class="form-group">
            <label for="emailSign">Email</label>
            <input type="email" class="form-control" id="emailSign" aria-describedby="emailHelp" name="email" placeholder="Enter email" required="">
          </div>
          <div class="form-group">
            <label for="passwordSign">Password</label>
            <input type="password" class="form-control" id="passwordSign" placeholder="Password" name="password" minlength="8" required="">
          </div>
          <button type="submit" class="btn btn-info btn btn-block text-center">Daftar</button>
        </div>
        <div class="modal-footer" style="justify-content: center;">
          <p class="m-0">Sudah punya akun ?</p>
          <a class="text-info" data-dismiss="modal" id="trigLog">Login</a>
        </div>
      </form>
    </div>
  </div>
</div>