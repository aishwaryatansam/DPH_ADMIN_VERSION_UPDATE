

    <script type="text/javascript">

        @if(session()->has('success'))
            success("{{session()->get('success')}}","{{session()->get('title')}}");
        @endif
        
        @if(session()->has('info'))
            info("{{session()->get('info')}}","{{session()->get('title')}}");
        @endif

        @if(session()->has('warning'))
            warning("{{session()->get('warning')}}","{{session()->get('title')}}");
        @endif

        @if(session()->has('error'))
            error("{{session()->get('error')}}","{{session()->get('title')}}");
        @endif
      
    </script>