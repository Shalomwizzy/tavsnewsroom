@if ($errors->any())
    @foreach ($errors->all() as $error )
        <div class="alert rounded-0 animate__animated animate__fadeInRight alert-dismissible fade show position-fixed" role="alert" style="z-index: 9999; top: 25%; right: 10px; background-color: red;">
            <strong>{{ $error }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger rounded-0 animate__animated animate__fadeInRight alert-dismissible fade show position-fixed" role="alert" style="z-index: 999; top: 25%; right: 10px;">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
@endif

@if ($message = Session::get('success'))
    <div class="alert rounded-0 animate__animated animate__fadeInRight text-white alert-dismissible fade show position-fixed top-0 end-0" role="alert" style="z-index: 9999; top: 25%; right: 10px;  background-color: green;">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
@endif

<script>
    // Auto-dismiss after 10 seconds
    // const alerts = document.querySelectorAll('.alert');
    // alerts.forEach(alert => {
    //     setTimeout(() => {
    //         alert.classList.add('animate__fadeOutRight');
    //         setTimeout(() => {
    //             alert.remove();
    //         }, 500);
    //     }, 6000); // 10 seconds
    // });
</script>