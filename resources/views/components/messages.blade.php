@if(isset($_GET['success']))
    <script>
        $.toast({
            heading: 'Success',
            text: "{{ $_GET['successMessage'] }}",
            position: 'top-right',
            icon: 'success'
        })
    </script>
@endif
@if(isset($_GET['error']))
    <script>
        $.toast({
            heading: 'Error',
            text: "{{ $_GET['errorMessage'] }}",
            position: 'top-right',
            icon: 'error'
        })
    </script>
@endif
@if(isset($_GET['shop_id']))
    @php $errors = \App\Services\SellerService::getErrors($_GET['shop_id']) @endphp
    @if(count($errors)>0)
        @foreach($errors as $error)
            <script>
                $.toast({
                    heading: 'Error',
                    text: "{{ $error->message }}",
                    position: 'top-right',
                    icon: 'error'
                })
            </script>
        @endforeach
    @endif
@endif
