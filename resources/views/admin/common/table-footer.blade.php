@if(count($results))

<div class="row m-20">
    <div class="col-6">
            @if($results->count())              
              	Showing {{$results->firstItem()}} to {{$results->lastItem()}} of {{ $results->total() }} entries
            @endif
    </div>  
    <div class="col-6 dataTables_paginate paging_simple_numbers">
    {{ $results->appends(request()->query())->links() }}          
    </div>   
	
</div>
@endif


