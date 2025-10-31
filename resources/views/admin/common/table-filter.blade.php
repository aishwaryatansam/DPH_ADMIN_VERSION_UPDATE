<div class="d-flex">
                        <input type="hidden" name="sortfield" id="sortfield" value="{{request('sortfield')}}"/>
                        <input type="hidden" name="sorttype" id="sorttype" value="{{request('sorttype')}}"/>

                         <div>
                            <label>Show 
                            <select name="pageLength" class="form-control form-control-line" id="pageLength" on-change="searchFun()">

                            @foreach(getPageLenthArr() as $pageLenght)
                            <option value="{{$pageLenght}}" {{SELECT($pageLenght,request('pageLength'))}}>{{$pageLenght}}</option>
                            @endforeach                                   
                           
                            </select>  
                            </label>
                         </div>
                         <div class="ml-auto">
                            <label>Search :<input type="search" placeholder="" class="form-control form-control-line searchable" name="keyword" id="keyword" value="{{request('keyword')}}">
                            </label>
                         </div>
                    </div>
                    