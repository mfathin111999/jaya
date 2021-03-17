<div class="modal fade" id="loginModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img class="modal-title" src="{{ asset('img/logo.png') }}" style="max-width: 50px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="login">
        <div class="modal-body pl-4 pr-4">
          <div class="form-group">
            <label for="emailLogin">Email address</label>
            <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Enter email" required="">
          </div>
          <div class="form-group">
            <label for="passwordLogin">Password</label>
            <input type="password" class="form-control" id="passwordLogin" name="password" placeholder="Password" required="">
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Ingat saya !</label>
          </div>
          <button type="submit" class="btn btn-info btn btn-block text-center">Login</button>
        </div>
        <div class="modal-footer" style="justify-content: center;">
          <p class="m-0">Belum punya akun ?</p>
          <a class="text-info" data-dismiss="modal" id="trigSign">Daftar</a>
        </div>
      </form>
    </div>
  </div>
</div>