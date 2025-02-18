<x-app-layout>
    @section('title', 'Home Page')

    @section('content')
        <h1>Welcome to the Home Page!</h1>
        <p>This is the content of your home page.</p>
        <button id="clickMe">Click Me</button>
        <p id="message"></p>
    @endsection

    @section('script')
    <script>
           $(document).ready(function(){
                $('#clickMe').click(function(){
                    $('#message').text("Hello This is awsome");
                })
            });
    </script>
     
    @endsection
</x-app-layout>
